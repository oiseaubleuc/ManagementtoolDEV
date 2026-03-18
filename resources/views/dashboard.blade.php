<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('projects.index') }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-indigo-300 hover:shadow-md">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-indigo-100 p-3">
                            <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Projets</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['projects'] ?? 0 }}</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('time-entries.index') }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-emerald-300 hover:shadow-md">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-emerald-100 p-3">
                            <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Heures cette semaine</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format(($stats['time_this_week'] ?? 0) / 60, 1) }} h</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('time-entries.create') }}" class="flex items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 text-gray-600 transition hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-700">
                    <span class="font-medium">+ Nouvelle saisie de temps</span>
                </a>
            </div>

            <div class="mt-8 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Démarrage rapide</h3>
                <div class="flex flex-wrap gap-3">
                    @can('create', \App\Models\Project::class)
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700">Nouveau projet</a>
                    @endcan
                    <a href="{{ route('time-entries.create') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">Saisir du temps</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
