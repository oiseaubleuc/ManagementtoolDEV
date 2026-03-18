<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'projects' => auth()->user()->projects()->count(),
            'time_this_week' => auth()->user()->timeEntries()
                ->whereBetween('started_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('duration_minutes'),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    Route::resource('projects', ProjectController::class)->middleware('permission:view_projects');

    Route::middleware('permission:view_time_entries')->group(function () {
        Route::get('time-entries', [TimeEntryController::class, 'index'])->name('time-entries.index');
        Route::get('time-entries/create', [TimeEntryController::class, 'create'])->name('time-entries.create');
        Route::post('time-entries', [TimeEntryController::class, 'store'])->name('time-entries.store');
        Route::get('time-entries/{timeEntry}/edit', [TimeEntryController::class, 'edit'])->name('time-entries.edit');
        Route::put('time-entries/{timeEntry}', [TimeEntryController::class, 'update'])->name('time-entries.update');
        Route::delete('time-entries/{timeEntry}', [TimeEntryController::class, 'destroy'])->name('time-entries.destroy');
        Route::post('time-entries/{timeEntry}/stop', [TimeEntryController::class, 'stop'])->name('time-entries.stop');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
