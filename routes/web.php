<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Authentication)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Main Dashboard
    Route::get('/', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $totalProjects = \App\Models\AuditProject::count();
            $totalAsesors = \App\Models\User::where('role', 'asesor')->count();
            $totalQuestions = \App\Models\CobitQuestion::count();
            $avgMaturity = \App\Models\AuditProject::whereNotNull('maturity_index')->avg('maturity_index') ?: 0;
            $recentProjects = \App\Models\AuditProject::with('asesor')->latest()->take(5)->get();

            return view('index', compact('totalProjects', 'totalAsesors', 'totalQuestions', 'avgMaturity', 'recentProjects'));
        } else {
            $myProjectsCount = \App\Models\AuditProject::where('asesor_id', $user->id)->count();
            $myCompletedCount = \App\Models\AuditProject::where('asesor_id', $user->id)->where('status', 'completed')->count();
            $myActiveProjects = \App\Models\AuditProject::where('asesor_id', $user->id)
                ->withCount('projectProcesses')
                ->latest()
                ->take(5)
                ->get();

            return view('index', compact('myProjectsCount', 'myCompletedCount', 'myActiveProjects'));
        }
    });

    // Shared projects routes (both Admin and Asesor can manage)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('projects/{id}/print', [\App\Http\Controllers\Admin\AuditProjectController::class, 'printProject'])->name('projects.print');
        Route::resource('projects', \App\Http\Controllers\Admin\AuditProjectController::class);
    });

    // Admin Only Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('asesors', \App\Http\Controllers\Admin\AsesorController::class);
        Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
        Route::resource('processes', \App\Http\Controllers\Admin\ProcessController::class);
        Route::resource('domains', \App\Http\Controllers\Admin\DomainController::class);
    });

    // Asesor Only Routes
    Route::middleware('role:asesor')->prefix('asesor')->name('asesor.')->group(function () {
        Route::get('/projects', [\App\Http\Controllers\Asesor\AssessmentController::class, 'index'])->name('projects.index');
        Route::get('/projects/{id}', [\App\Http\Controllers\Asesor\AssessmentController::class, 'showProject'])->name('projects.show');
        Route::get('/projects/{projectId}/process/{processCode}', [\App\Http\Controllers\Asesor\AssessmentController::class, 'workspace'])->name('projects.workspace');
        Route::post('/projects/{projectId}/process/{processCode}', [\App\Http\Controllers\Asesor\AssessmentController::class, 'submitWorkspace'])->name('projects.workspace.submit');
        Route::post('/projects/{projectId}/process/{processCode}/reset', [\App\Http\Controllers\Asesor\AssessmentController::class, 'resetWorkspace'])->name('projects.workspace.reset');
    });
});
