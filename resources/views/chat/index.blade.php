@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mis Chats') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($chats->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">No tienes chats activos</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Cuando inicies una conversación con alguien, aparecerá aquí.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($chats as $chat)
                                <a href="{{ route('chat.show', $chat->otherUser->id) }}" 
                                   class="block p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center">
                                            <p class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $chat->otherUser->name }}</p>
                                            @if($chat->unread_count > 0)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">{{ $chat->unread_count }}</span>
                                            @endif
                                        </div>
                                        <div class="flex justify-between">
                                            <p class="text-sm text-gray-600 dark:text-gray-300 truncate">{{ $chat->lastMessage->content ?? 'Nuevo chat' }}</p>
                                            @if($chat->lastMessage)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $chat->lastMessage->created_at->diffForHumans() }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection