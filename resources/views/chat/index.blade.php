<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Usuarios disponibles</h3>
                    <div class="space-y-2">
                        @forelse($users as $user)
                            <a href="{{ route('chat.show', $user) }}" 
                               class="block p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition">
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No hay otros usuarios disponibles.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>