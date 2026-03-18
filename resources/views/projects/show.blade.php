<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $project->name }}</h2>
            @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Modifier</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="mb-8 rounded-xl bg-white p-6 shadow-sm">
                @if ($project->description)
                    <p class="text-gray-600">{{ $project->description }}</p>
                @endif
                <dl class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Propriétaire</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $project->owner->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                @if($project->status === 'active') bg-green-100 text-green-800
                                @elseif($project->status === 'on_hold') bg-amber-100 text-amber-800
                                @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $project->status }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $project->due_date?->format('d-m-Y') ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-3 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Tâches</h3>
                </div>
                @if ($project->tasks->isEmpty())
                    <div class="p-8 text-center text-gray-500">Aucune tâche dans ce projet.</div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($project->tasks as $task)
                            <li class="px-4 py-3 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $task->title }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $task->assignee?->name ?? 'Non assigné' }} ·
                                            <span class="capitalize">{{ $task->status }}</span> ·
                                            {{ $task->priority }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
