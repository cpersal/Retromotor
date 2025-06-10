@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Chat con {{ $user->name }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="connection-status" class="mb-4 p-2 rounded text-sm">
                        <span id="status-text">Verificando conexión...</span>
                    </div>

                    <div id="messages"
                        class="h-96 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-4 mb-4 space-y-4 bg-gray-50 dark:bg-gray-700">
                        @forelse($messages as $message)
                            <div class="message flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100' }}">
                                    <div class="text-sm">{{ $message->content }}</div>
                                    <div class="text-xs opacity-75 mt-1">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                No hay mensajes aún. ¡Envía el primero!
                            </div>
                        @endforelse
                    </div>

                    <form id="message-form" class="flex gap-2">
                        @csrf
                        <input type="text" id="message-input" placeholder="Escribe tu mensaje..."
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                        <button type="submit" id="send-button"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition disabled:opacity-50">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const userId = {{ auth()->id() }};
        const receiverId = {{ $user->id }};

        function updateConnectionStatus(status, message) {
            const statusEl = document.getElementById('connection-status');
            const textEl = document.getElementById('status-text');
            statusEl.className = 'mb-4 p-2 rounded text-sm ';
            switch (status) {
                case 'connecting':
                    statusEl.className += 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                    break;
                case 'connected':
                    statusEl.className += 'bg-green-100 text-green-800 border border-green-200';
                    break;
                case 'error':
                    statusEl.className += 'bg-red-100 text-red-800 border border-red-200';
                    break;
            }
            textEl.textContent = message;
        }

        async function fetchNewMessages() {
            try {
                const response = await fetch(`/chat/${receiverId}/new-messages`);
                if (response.ok) {
                    const messages = await response.json();
                    if (messages.length > 0) {
                        messages.forEach(message => {
                            addMessage(
                                message.content,
                                message.sender.name,
                                new Date(message.created_at).toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }),
                                message.sender_id === userId
                            );
                        });
                    }
                }
            } catch (error) {
                console.error('Error en polling:', error);
                updateConnectionStatus('error', 'Error al obtener nuevos mensajes');
            }
        }

        function initializeChat() {
            updateConnectionStatus('connected', 'Conectado');
            const pollingInterval = setInterval(fetchNewMessages, 1000);
            window.addEventListener('beforeunload', () => {
                clearInterval(pollingInterval);
            });
        }

        document.getElementById('message-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const button = document.getElementById('send-button');
            const content = input.value.trim();
            if (!content) return;

            button.disabled = true;
            button.textContent = 'Enviando...';

            try {
                const response = await fetch(`/chat/{{ $user->id }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content })
                });

                if (response.ok) {
                    const message = await response.json();
                    addMessage(message.content, "Tú", message.created_at, true);
                    input.value = '';
                } else {
                    alert('Error al enviar el mensaje. Inténtalo de nuevo.');
                }
            } catch (error) {
                alert('Error de conexión. Verifica tu conexión a internet.');
            } finally {
                button.disabled = false;
                button.textContent = 'Enviar';
            }
        });

        function addMessage(content, senderName, time, isMine) {
            const messagesContainer = document.getElementById('messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message flex ${isMine ? 'justify-end' : 'justify-start'}`;
            messageDiv.innerHTML = `
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isMine ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100'}">
                    <div class="text-sm">${escapeHtml(content)}</div>
                    <div class="text-xs opacity-75 mt-1">${time}</div>
                </div>
            `;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            initializeChat();
        });
    </script>
@endpush
