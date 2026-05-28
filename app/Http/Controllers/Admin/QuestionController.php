<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CobitPractice;
use App\Models\CobitQuestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index(Request $request)
    {
        $practices = CobitPractice::with('process')->get();
        
        $query = CobitQuestion::with('practice.process');

        // Apply practice code filter if requested
        if ($request->filled('practice')) {
            $query->where('practice_code', $request->practice);
        }

        $questions = $query->latest()->get();

        return view('admin.questions.index', compact('questions', 'practices'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $processes = \App\Models\CobitProcess::all();
        $practices = CobitPractice::with('process')->get();
        return view('admin.questions.create', compact('processes', 'practices'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'process_code' => ['required', 'exists:cobit_processes,code'],
            'practice_code' => ['required', 'string', 'max:50'],
            'practice_name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'in:2,3,4,5'],
            'question_text' => ['required', 'string'],
            'expected_evidence' => ['nullable', 'string'],
        ], [
            'process_code.required' => 'Wajib memilih Proses COBIT.',
            'process_code.exists' => 'Proses COBIT tidak valid.',
            'practice_code.required' => 'Wajib mengisi kode sub-praktik COBIT.',
            'practice_name.required' => 'Wajib mengisi nama sub-praktik COBIT.',
            'level.required' => 'Wajib menentukan tingkat kapabilitas (level).',
            'level.in' => 'Tingkat level harus berada di rentang Level 2 sampai Level 5.',
            'question_text.required' => 'Butir pertanyaan wajib diisi.',
        ]);

        // Auto-create practice if it does not exist yet
        $practice = CobitPractice::firstOrCreate(
            ['code' => $request->practice_code],
            [
                'process_code' => $request->process_code,
                'name' => $request->practice_name,
                'description' => $request->practice_name,
            ]
        );

        $questionData = [
            'practice_code' => $practice->code,
            'level' => $request->level,
            'question_text' => $request->question_text,
        ];

        if ($request->has('expected_evidence')) {
            $questionData['expected_evidence'] = $request->expected_evidence;
        }

        CobitQuestion::create($questionData);

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan kuesioner baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit($id)
    {
        $question = CobitQuestion::with('practice.process')->findOrFail($id);
        $processes = \App\Models\CobitProcess::all();
        $practices = CobitPractice::with('process')->get();
        return view('admin.questions.edit', compact('question', 'processes', 'practices'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, $id)
    {
        $question = CobitQuestion::findOrFail($id);

        $request->validate([
            'process_code' => ['required', 'exists:cobit_processes,code'],
            'practice_code' => ['required', 'string', 'max:50'],
            'practice_name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'in:2,3,4,5'],
            'question_text' => ['required', 'string'],
            'expected_evidence' => ['nullable', 'string'],
        ], [
            'process_code.required' => 'Wajib memilih Proses COBIT.',
            'process_code.exists' => 'Proses COBIT tidak valid.',
            'practice_code.required' => 'Wajib mengisi kode sub-praktik COBIT.',
            'practice_name.required' => 'Wajib mengisi nama sub-praktik COBIT.',
            'level.required' => 'Wajib menentukan tingkat kapabilitas (level).',
            'level.in' => 'Tingkat level harus berada di rentang Level 2 sampai Level 5.',
            'question_text.required' => 'Butir pertanyaan wajib diisi.',
        ]);

        // Auto-create/update practice if it does not exist yet
        $practice = CobitPractice::firstOrCreate(
            ['code' => $request->practice_code],
            [
                'process_code' => $request->process_code,
                'name' => $request->practice_name,
                'description' => $request->practice_name,
            ]
        );

        $updateData = [
            'practice_code' => $practice->code,
            'level' => $request->level,
            'question_text' => $request->question_text,
        ];

        if ($request->has('expected_evidence')) {
            $updateData['expected_evidence'] = $request->expected_evidence;
        }

        $question->update($updateData);

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan kuesioner berhasil diperbarui.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy($id)
    {
        $question = CobitQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan kuesioner berhasil dihapus.');
    }
}
