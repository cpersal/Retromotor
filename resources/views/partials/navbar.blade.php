<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-car me-2"></i> RetroMotor
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('piezas.index') ? 'active' : '' }}" 
                       href="{{ route('piezas.index') }}">
                        <i class="fas fa-list me-1"></i> Catálogo
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-info-circle me-1"></i> Contacto
                        </a>
                    </li>
                </ul>
            </ul>
            
        </div>
    </div>
</nav>