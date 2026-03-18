<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle saisie de temps</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <form action="{{ route('time-entries.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="project_id" value="Project" />
                        <select id="project_id" name="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}" @selected(old('project_id', $selectedProject?->id) == $p->id)>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="task_id" value="Tâche (optionnel)" />
                        <select id="task_id" name="task_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Aucune —</option>
                            @foreach ($projects as $p)
                                @foreach ($p->tasks as $task)
                                    <option value="{{ $task->id }}" @selected(old('task_id') == $task->id)>{{ $p->name }}: {{ $task->title }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="started_at" value="Start" />
                            <x-text-input id="started_at" name="started_at" type="datetime-local" class="mt-1 block w-full" :value="old('started_at', now()->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('started_at')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="ended_at" value="Fin (optionnel)" />
                            <x-text-input id="ended_at" name="ended_at" type="datetime-local" class="mt-1 block w-full" :value="old('ended_at')" />
                            <x-input-error :messages="$errors->get('ended_at')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <input id="is_billable" name="is_billable" type="checkbox" value="1" {{ old('is_billable') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <x-input-label for="is_billable" value="Facturable" class="ml-2" />
                    </div>
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('time-entries.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
