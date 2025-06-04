<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Chat con {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Estado de conexión -->
                    <div id="connection-status" class="mb-4 p-2 rounded text-sm">
                        <span id="status-text">Verificando conexión...</span>
                    </div>

                    <!-- Área de mensajes -->
                    <div id="messages" class="h-96 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-4 mb-4 space-y-4 bg-gray-50 dark:bg-gray-700">
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

                    <!-- Formulario de envío -->
                    <form id="message-form" class="flex gap-2">
                        @csrf
                        <input type="text" 
                               id="message-input" 
                               placeholder="Escribe tu mensaje..." 
                               class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                               required>
                        <button type="submit" 
                                id="send-button"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition disabled:opacity-50">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const userId = {{ auth()->id() }};
        const receiverId = {{ $user->id }};
        
        // Función para actualizar estado de conexión
        function updateConnectionStatus(status, message) {
            const statusEl = document.getElementById('connection-status');
            const textEl = document.getElementById('status-text');
            
            statusEl.className = 'mb-4 p-2 rounded text-sm ';
            
            switch(status) {
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

        // Verificar si Echo está disponible
        function initializeChat() {
            if (typeof window.Echo === 'undefined') {
                updateConnectionStatus('error', 'Error: Echo no está disponible. Verifica la configuración.');
                console.error('Echo no está definido. Verifica que los assets estén compilados correctamente.');
                return;
            }

            updateConnectionStatus('connecting', 'Conectando al chat...');

            try {
                // Configurar Echo
                window.Echo.private(`chat.${userId}`)
                    .listen('MessageSent', (e) => {
                        console.log('Mensaje recibido:', e);
                        addMessage(e.content, e.sender_name, e.created_at, false);
                        updateConnectionStatus('connected', 'Conectado - Chat en tiempo real activo');
                    })
                    .error((error) => {
                        console.error('Error en el canal:', error);
                        updateConnectionStatus('error', 'Error de conexión al canal');
                    });

                // Verificar conexión después de un tiempo
                setTimeout(() => {
                    updateConnectionStatus('connected', 'Conectado - Chat en tiempo real activo');
                }, 2000);

            } catch (error) {
                console.error('Error inicializando Echo:', error);
                updateConnectionStatus('error', 'Error al inicializar la conexión');
            }
        }

        // Formulario de envío
        document.getElementById('message-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const input = document.getElementById('message-input');
            const button = document.getElementById('send-button');
            const content = input.value.trim();
            
            if (!content) return;
            
            // Deshabilitar botón mientras se envía
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
                    addMessage(message.content, message.sender_name, message.created_at, true);
                    input.value = '';
                } else {
                    console.error('Error al enviar mensaje');
                    alert('Error al enviar el mensaje. Inténtalo de nuevo.');
                }
            } catch (error) {
                console.error('Error enviando mensaje:', error);
                alert('Error de conexión. Verifica tu conexión a internet.');
            } finally {
                // Rehabilitar botón
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

        // Auto-scroll al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Inicializar chat después de que se cargue la página
            setTimeout(initializeChat, 1000);
        });
    </script>
    @endpush
</x-app-layout>