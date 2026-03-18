<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeEntryController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', TimeEntry::class);

        $query = TimeEntry::with(['project', 'task', 'user'])
            ->when(! auth()->user()->hasPermission('view_all_time_entries'), fn ($q) => $q->where('user_id', auth()->id()));

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('started_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('started_at', '<=', $request->to);
        }

        $timeEntries = $query->latest('started_at')->paginate(15);
        $projects = auth()->user()->projects()->orderBy('name')->get();

        return view('time-entries.index', compact('timeEntries', 'projects'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', TimeEntry::class);

        $projectId = $request->get('project_id');
        $projects = auth()->user()->projects()->with('tasks')->orderBy('name')->get();
        $selectedProject = $projectId ? $projects->find($projectId) : $projects->first();

        return view('time-entries.create', [
            'projects' => $projects,
            'selectedProject' => $selectedProject,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', TimeEntry::class);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'task_id' => ['nullable', 'exists:tasks,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after:started_at'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_billable' => ['boolean'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_billable'] = $request->boolean('is_billable');

        if (! auth()->user()->isProjectMember(Project::find($validated['project_id']))) {
            abort(403);
        }

        TimeEntry::create($validated);

        return redirect()->route('time-entries.index')->with('success', 'Saisie de temps enregistrée.');
    }

    public function edit(TimeEntry $timeEntry): View|RedirectResponse
    {
        $this->authorize('update', $timeEntry);

        $timeEntry->load('project.tasks');
        $projects = auth()->user()->projects()->with('tasks')->orderBy('name')->get();

        return view('time-entries.edit', compact('timeEntry', 'projects'));
    }

    public function update(Request $request, TimeEntry $timeEntry): RedirectResponse
    {
        $this->authorize('update', $timeEntry);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'task_id' => ['nullable', 'exists:tasks,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after:started_at'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_billable' => ['boolean'],
        ]);

        $validated['is_billable'] = $request->boolean('is_billable');

        $timeEntry->update($validated);

        return redirect()->route('time-entries.index')->with('success', 'Saisie de temps mise à jour.');
    }

    public function destroy(TimeEntry $timeEntry): RedirectResponse
    {
        $this->authorize('delete', $timeEntry);

        $timeEntry->delete();

        return redirect()->route('time-entries.index')->with('success', 'Saisie de temps supprimée.');
    }

    public function stop(TimeEntry $timeEntry): RedirectResponse
    {
        $this->authorize('update', $timeEntry);

        if ($timeEntry->ended_at) {
            return redirect()->route('time-entries.index')->with('info', 'Cette saisie est déjà terminée.');
        }

        $timeEntry->update(['ended_at' => Carbon::now()]);

        return redirect()->route('time-entries.index')->with('success', 'Saisie de temps arrêtée.');
    }
}
