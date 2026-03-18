<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projets</h2>
            @can('create', \App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">Nouveau projet</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                @if ($projects->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <p class="mb-4">Aucun projet pour le moment.</p>
                        @can('create', \App\Models\Project::class)
                            <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Créer votre premier projet</a>
                        @endcan
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($projects as $project)
                            <li>
                                <a href="{{ route('projects.show', $project) }}" class="block p-4 transition hover:bg-gray-50 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $project->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $project->owner->name }} · {{ $project->status }}</p>
                                        </div>
                                        <span class="text-gray-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
