<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\AuditProject;
use App\Models\AuditProjectProcess;
use App\Models\CobitProcess;
use App\Models\CobitQuestion;
use App\Models\AssessmentResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller
{
    /**
     * Display a listing of assigned audit projects.
     */
    public function index()
    {
        $projects = AuditProject::where('asesor_id', auth()->id())
            ->withCount('projectProcesses')
            ->latest()
            ->get();

        return view('asesor.projects.index', compact('projects'));
    }

    /**
     * Display the specified project details.
     */
    public function showProject($id)
    {
        $project = AuditProject::with([
                'projectProcesses.cobitProcess.domain',
                'projectProcesses.cobitProcess.practices.questions',
                'responses.question'
            ])
            ->findOrFail($id);

        return view('asesor.projects.show', compact('project'));
    }

    /**
     * Render the interactive workspace for a specific process assessment.
     */
    public function workspace($projectId, $processCode)
    {
        $project = AuditProject::findOrFail($projectId);
        
        $projectProcess = AuditProjectProcess::where('project_id', $projectId)
            ->where('process_code', $processCode)
            ->with('cobitProcess.domain')
            ->firstOrFail();

        // Get all practices and questions for this process
        $process = CobitProcess::with('practices.questions')->findOrFail($processCode);
        $practiceCodes = $process->practices->pluck('code')->toArray();

        // Find the active capability level for this assessment
        $activeLevelInfo = $this->determineActiveLevel($projectId, $practiceCodes);

        if ($activeLevelInfo['status'] === 'completed') {
            // The assessment is completed, redirect to summary or show completed state
            $projectProcess->update([
                'status' => 'completed',
                'computed_capability_level' => $activeLevelInfo['capability_level']
            ]);

            // Update project overall maturity index
            $this->recalculateMaturityIndex($projectId);

            return view('asesor.projects.workspace_completed', [
                'project' => $project,
                'projectProcess' => $projectProcess,
                'capabilityLevel' => $activeLevelInfo['capability_level'],
                'history' => $activeLevelInfo['history']
            ]);
        }

        $activeLevel = $activeLevelInfo['active_level'];

        // Get questions for this active level
        $questions = CobitQuestion::whereIn('practice_code', $practiceCodes)
            ->where('level', $activeLevel)
            ->get();

        // Get existing responses for these questions
        $responses = AssessmentResponse::where('project_id', $projectId)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        // Mark process as in_progress if it was not_started
        if ($projectProcess->status === 'not_started') {
            $projectProcess->update(['status' => 'in_progress']);
        }

        return view('asesor.projects.workspace', [
            'project' => $project,
            'projectProcess' => $projectProcess,
            'activeLevel' => $activeLevel,
            'questions' => $questions,
            'responses' => $responses,
            'history' => $activeLevelInfo['history']
        ]);
    }

    /**
     * Submit responses for the active capability level.
     */
    public function submitWorkspace(Request $request, $projectId, $processCode)
    {
        $project = AuditProject::findOrFail($projectId);
        
        $projectProcess = AuditProjectProcess::where('project_id', $projectId)
            ->where('process_code', $processCode)
            ->firstOrFail();

        $request->validate([
            'level' => ['required', 'integer', 'in:2,3,4,5'],
            'answers' => ['required', 'array'],
            'notes' => ['nullable', 'array'],
            'evidence_files' => ['nullable', 'array'],
            'evidence_files.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', 'max:5120'], // max 5MB
            'evidence_texts' => ['nullable', 'array'],
        ]);

        $activeLevel = (int)$request->level;

        // Process answers and files
        foreach ($request->answers as $questionId => $answer) {
            $existing = AssessmentResponse::where('project_id', $projectId)
                ->where('question_id', $questionId)
                ->first();

            $note = $request->input("notes.{$questionId}");
            $evidenceText = $request->input("evidence_texts.{$questionId}");
            $evidenceFilePath = $existing ? $existing->evidence_file : null;

            // Handle file upload if provided
            if ($request->hasFile("evidence_files.{$questionId}")) {
                $file = $request->file("evidence_files.{$questionId}");
                $filename = 'evidence_' . $projectId . '_' . $questionId . '_' . time() . '.' . $file->getClientOriginalExtension();
                $evidenceFilePath = $file->storeAs('evidences', $filename, 'public');

                // Delete old file if exists
                if ($existing && $existing->evidence_file) {
                    Storage::disk('public')->delete($existing->evidence_file);
                }
            }

            $evidenceInfo = $evidenceText;
            if ($evidenceFilePath) {
                $evidenceInfo = ($evidenceText ? $evidenceText . ' | ' : '') . 'File: ' . $evidenceFilePath;
            }

            AssessmentResponse::updateOrCreate(
                [
                    'project_id' => $projectId,
                    'question_id' => $questionId,
                ],
                [
                    'answer' => $answer,
                    'notes' => $note,
                    'evidence_file' => $evidenceFilePath ?: ($existing ? $existing->evidence_file : null),
                ]
            );
        }

        // Now, evaluate the result for this level to decide the next step
        $process = CobitProcess::with('practices.questions')->findOrFail($processCode);
        $practiceCodes = $process->practices->pluck('code')->toArray();

        $activeLevelInfo = $this->determineActiveLevel($projectId, $practiceCodes);

        if ($activeLevelInfo['status'] === 'completed') {
            $projectProcess->update([
                'status' => 'completed',
                'computed_capability_level' => $activeLevelInfo['capability_level']
            ]);

            $this->recalculateMaturityIndex($projectId);

            return response()->json([
                'success' => true,
                'status' => 'completed',
                'capability_level' => $activeLevelInfo['capability_level'],
                'message' => 'Asesmen proses ini telah selesai!'
            ]);
        }

        // If active level has advanced
        if ($activeLevelInfo['active_level'] > $activeLevel) {
            return response()->json([
                'success' => true,
                'status' => 'advanced',
                'next_level' => $activeLevelInfo['active_level'],
                'message' => 'Selamat! Level ' . $activeLevel . ' berhasil dilewati. Melanjutkan ke Level ' . $activeLevelInfo['active_level'] . '.'
            ]);
        }

        // If active level is the same, it means they failed the level or it's incomplete
        // But since we just submitted the full level, if they failed it, the status should have changed to completed.
        // If they failed, the activeLevelInfo['status'] would be 'completed' with level = L - 1.
        return response()->json([
            'success' => true,
            'status' => 'same',
            'active_level' => $activeLevelInfo['active_level'],
            'message' => 'Jawaban disimpan.'
        ]);
    }

    /**
     * Reset the specified process assessment responses and status.
     */
    public function resetWorkspace($projectId, $processCode)
    {
        $project = AuditProject::findOrFail($projectId);
        $process = CobitProcess::with('practices.questions')->findOrFail($processCode);
        $questionIds = CobitQuestion::whereIn('practice_code', $process->practices->pluck('code'))->pluck('id');

        // Delete all responses uploaded by this assessor for this project process
        $responses = AssessmentResponse::where('project_id', $projectId)
            ->whereIn('question_id', $questionIds)
            ->get();

        foreach ($responses as $response) {
            if ($response->evidence_file) {
                Storage::disk('public')->delete($response->evidence_file);
            }
            $response->delete();
        }

        // Reset process status & score
        $projectProcess = AuditProjectProcess::where('project_id', $projectId)
            ->where('process_code', $processCode)
            ->firstOrFail();

        $projectProcess->update([
            'status' => 'not_started',
            'computed_capability_level' => 0
        ]);

        // Recalculate project maturity index
        $this->recalculateMaturityIndex($projectId);

        return redirect()->route('asesor.projects.workspace', [$projectId, $processCode])
            ->with('success', 'Asesmen proses berhasil direset kembali ke awal.');
    }

    /**
     * Determine the active capability level based on response answers and sequential COBIT rules.
     */
    private function determineActiveLevel(int $projectId, array $practiceCodes): array
    {
        $history = [];
        
        // Loop through levels 2, 3, 4, 5 sequentially
        for ($level = 2; $level <= 5; $level++) {
            // Get all seeded questions for this level
            $levelQuestions = CobitQuestion::whereIn('practice_code', $practiceCodes)
                ->where('level', $level)
                ->get();

            // If there are no questions seeded for this level, does it pass?
            if ($levelQuestions->isEmpty()) {
                // If there are no questions, we skip this level and check the next
                $history[$level] = [
                    'questions_count' => 0,
                    'answered_count' => 0,
                    'pass' => true,
                    'score' => 100,
                    'status' => 'skipped'
                ];
                continue;
            }

            // Get answers for these questions
            $questionIds = $levelQuestions->pluck('id')->toArray();
            $responses = AssessmentResponse::where('project_id', $projectId)
                ->whereIn('question_id', $questionIds)
                ->get();

            $totalQuestions = $levelQuestions->count();
            $totalAnswered = $responses->count();

            // If not all questions at this level are answered yet, this is the active level!
            if ($totalAnswered < $totalQuestions) {
                return [
                    'status' => 'in_progress',
                    'active_level' => $level,
                    'history' => $history
                ];
            }

            // All questions are answered, check if they passed
            // Pass criteria: F or L answers must be >= 85% of total questions
            $flCount = $responses->whereIn('answer', ['F', 'L'])->count();
            $scorePercent = ($flCount / $totalQuestions) * 100;
            $passed = $scorePercent >= 85;

            $history[$level] = [
                'questions_count' => $totalQuestions,
                'answered_count' => $totalAnswered,
                'fl_count' => $flCount,
                'pass' => $passed,
                'score' => $scorePercent,
                'status' => $passed ? 'passed' : 'failed'
            ];

            // If failed, the assessment stops immediately! Capability level is locked at $level - 1.
            if (!$passed) {
                return [
                    'status' => 'completed',
                    'capability_level' => $level - 1, // failed this level, so capability is the previous one
                    'history' => $history
                ];
            }
        }

        // If we completed level 5 and passed, then capability level is 5!
        // If all levels with questions were passed, the final capability is the highest passed level.
        $finalLevel = 5;
        // Search back to find the actual maximum level assessed
        for ($lvl = 5; $lvl >= 2; $lvl--) {
            if (isset($history[$lvl]) && $history[$lvl]['status'] === 'passed') {
                $finalLevel = $lvl;
                break;
            }
        }

        return [
            'status' => 'completed',
            'capability_level' => $finalLevel,
            'history' => $history
        ];
    }

    /**
     * Recalculate the overall maturity index for the project.
     */
    private function recalculateMaturityIndex(int $projectId)
    {
        $project = AuditProject::with('projectProcesses')->findOrFail($projectId);
        
        // Count only completed processes
        $completedProcesses = $project->projectProcesses->where('status', 'completed');

        if ($completedProcesses->isNotEmpty()) {
            $average = $completedProcesses->avg('computed_capability_level');
            $project->update([
                'maturity_index' => $average,
                // If all processes are completed, mark project as completed
                'status' => $project->projectProcesses->count() === $completedProcesses->count() ? 'completed' : 'in_progress'
            ]);
        } else {
            $project->update([
                'status' => 'in_progress'
            ]);
        }
    }
}
