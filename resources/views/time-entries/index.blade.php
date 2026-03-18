<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saisie de temps</h2>
            <a href="{{ route('time-entries.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">Nouvelle saisie</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="mb-4 rounded-lg bg-blue-100 p-4 text-blue-800">{{ session('info') }}</div>
            @endif

            <form method="GET" class="mb-6 flex flex-wrap items-end gap-4 rounded-xl bg-white p-4 shadow-sm">
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                    <select id="project_id" name="project_id" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous</option>
                        @foreach ($projects as $p)
                            <option value="{{ $p->id }}" @selected(request('project_id') == $p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="from" class="block text-sm font-medium text-gray-700">Du</label>
                    <input type="date" id="from" name="from" value="{{ request('from') }}" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="to" class="block text-sm font-medium text-gray-700">Au</label>
                    <input type="date" id="to" name="to" value="{{ request('to') }}" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Filtrer</button>
            </form>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                @if ($timeEntries->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <p class="mb-4">Aucune saisie de temps.</p>
                        <a href="{{ route('time-entries.create') }}" class="text-indigo-600 hover:underline">Saisir du temps</a>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($timeEntries as $entry)
                            <li class="flex items-center justify-between px-4 py-3 sm:px-6">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $entry->project->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $entry->started_at->format('d-m-Y H:i') }}
                                        @if ($entry->ended_at)
                                            – {{ $entry->ended_at->format('H:i') }}
                                            · {{ $entry->duration_minutes ? round($entry->duration_minutes / 60, 1) . ' h' : '—' }}
                                        @else
                                            <span class="text-amber-600">(en cours)</span>
                                        @endif
                                        @if ($entry->task)
                                            · {{ $entry->task->title }}
                                        @endif
                                    </p>
                                    @if ($entry->description)
                                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($entry->description, 80) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if (! $entry->ended_at)
                                        <form action="{{ route('time-entries.stop', $entry) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="rounded bg-amber-100 px-2 py-1 text-xs font-medium text-amber-800 hover:bg-amber-200">Arrêter</button>
                                        </form>
                                    @endif
                                    @can('update', $entry)
                                        <a href="{{ route('time-entries.edit', $entry) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                    @endcan
                                    @can('delete', $entry)
                                        <form action="{{ route('time-entries.destroy', $entry) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette saisie de temps ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    @endcan
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                        {{ $timeEntries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
