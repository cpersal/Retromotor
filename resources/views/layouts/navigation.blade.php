<nav x-data="{ open: false }" class="bg-indigo-600 border-b border-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('piezas.index') }}">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                </a>

                <div class="hidden sm:flex space-x-8">
                    <x-nav-link :href="route('piezas.index')" :active="request()->routeIs('piezas.index')" :class="request()->routeIs('piezas.index')
                        ? 'text-white font-bold border-b-2 border-white'
                        : 'text-white hover:text-yellow-200'">
                        {{ __('Piezas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('piezas.create')" :active="request()->routeIs('piezas.create')" :class="request()->routeIs('piezas.create')
                        ? 'text-white font-bold border-b-2 border-white'
                        : 'text-white hover:text-yellow-200'">
                        {{ __('Subir Artículo') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('vendedor.show')" :class="request()->routeIs('vendedor.show')
                            ? 'text-white font-bold border-b-2 border-white'
                            : 'text-white hover:text-yellow-200'">
                            {{ __('Perfil') }}
                        </x-nav-link>
                        <x-nav-link :href="route('favoritos.index')" :active="request()->routeIs('favoritos.index')" :class="request()->routeIs('favoritos.index')
                            ? 'text-white font-bold border-b-2 border-white'
                            : 'text-white hover:text-yellow-200'">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-1 text-red-800" fill="currentColor" stroke="none"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ __('Favoritos') }}
                            </div>
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center space-x-4">
                @auth
                    <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')" :class="request()->routeIs('chat.*')
                        ? 'text-white font-bold border-b-2 border-white'
                        : 'text-white hover:text-yellow-200'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            {{ __('Chat') }}
                        </div>
                    </x-nav-link>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-yellow-200 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link class="text-white hover:text-yellow-200"
                        :href="route('login')">{{ __('Iniciar sesión') }}</x-nav-link>
                    @if (Route::has('register'))
                        <x-nav-link class="text-white hover:text-yellow-200"
                            :href="route('register')">{{ __('Registrarme') }}</x-nav-link>
                    @endif
                @endauth
            </div>

            <div class="sm:hidden flex items-center">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-white hover:text-yellow-200 hover:bg-pink-600 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1 text-white">
                <x-responsive-nav-link :href="route('piezas.index')" :active="request()->routeIs('piezas.index')" :class="request()->routeIs('piezas.index')
                    ? 'text-white font-bold border-b-2 border-white'
                    : 'text-white hover:text-yellow-200'">
                    {{ __('Piezas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('piezas.create')" :active="request()->routeIs('piezas.create')" :class="request()->routeIs('piezas.create')
                    ? 'text-white font-bold border-b-2 border-white'
                    : 'text-white hover:text-yellow-200'">
                    {{ __('Subir Artículo') }}
                </x-responsive-nav-link>
                @auth
                    <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')" :class="request()->routeIs('chat.*')
                        ? 'text-white font-bold border-b-2 border-white'
                        : 'text-white hover:text-yellow-200'">
                        {{ __('Chat') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('vendedor.show')" :class="request()->routeIs('vendedor.show')
                        ? 'text-white font-bold border-b-2 border-white'
                        : 'text-white hover:text-yellow-200'">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('favoritos.index')" :active="request()->routeIs('favoritos.index')" class="text-white hover:text-gray-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-1 text-red-800" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            {{ __('Favoritos') }}
                        </div>
                    </x-responsive-nav-link>
                @endauth
            </div>

            @auth
                <div class="pt-4 pb-1 border-t border-pink-300">
                    <div class="px-4">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-pink-100">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @else
                <div class="pt-4 pb-1 border-t border-pink-300">
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Iniciar sesión') }}
                        </x-responsive-nav-link>
                        @if (Route::has('register'))
                            <x-responsive-nav-link :href="route('register')">
                                {{ __('Registrarme') }}
                            </x-responsive-nav-link>
                        @endif
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
