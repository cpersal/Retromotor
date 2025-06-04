<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5><i class="fas fa-car me-2"></i> RetroMotor</h5>
                <p class="text-muted">Tu catálogo de piezas automotrices de confianza.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Enlaces útiles</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('piezas.index') }}" class="text-decoration-none text-muted">Catálogo</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Contacto</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Términos y condiciones</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Contacto</h5>
                <ul class="list-unstyled text-muted">
                    <li><i class="fas fa-envelope me-2"></i> info@retromotor.com</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                </ul>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center text-muted">
            <small>&copy; {{ date('Y') }} RetroMotor. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>