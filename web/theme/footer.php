<?php
/**
 * Tibisay Hoteles — footer.php
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main><!-- #content -->

<section class="newsletter" id="newsletter">
    <div class="container">
        <h2>Reciba ofertas exclusivas</h2>
        <p>Suscribase a nuestro boletin y reciba las mejores tarifas y novedades de Hoteles Tibisay.</p>
        <form class="newsletter-form" id="newsletter-form" novalidate>
            <input type="email" name="newsletter_email" placeholder="Su correo electronico" required aria-label="Correo electronico">
            <select name="newsletter_sede" aria-label="Sede de interes">
                <option value="">Sede de interes</option>
                <option value="merida">Tibisay Merida</option>
                <option value="margarita">Tibisay Margarita</option>
                <option value="maracaibo">Tibisay Del Lago</option>
                <option value="maturin">Tibisay Maturin</option>
                <option value="canaima">Tibisay Canaima</option>
                <option value="morrocoy">Tibisay Morrocoy</option>
                <option value="catatumbo">Tibisay Catatumbo</option>
            </select>
            <button type="submit">Suscribirse</button>
        </form>
        <p class="newsletter-msg hidden" id="newsletter-msg" role="status"></p>
    </div>
</section>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <!-- Columna 1: Sobre nosotros -->
            <div class="footer-col">
                <h4>Hoteles Tibisay</h4>
                <p>Mas de 30 anos brindando experiencias unicas en los destinos mas hermosos de Venezuela. Calidad, servicio y tradicion en cada una de nuestras 7 sedes.</p>
            </div>

            <!-- Columna 2: Nuestras Sedes -->
            <div class="footer-col">
                <h4>Nuestras Sedes</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/merida' ) ); ?>">Tibisay Merida</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/margarita' ) ); ?>">Tibisay Margarita</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/maracaibo' ) ); ?>">Tibisay Del Lago</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/maturin' ) ); ?>">Tibisay Maturin</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/canaima' ) ); ?>">Tibisay Canaima</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/morrocoy' ) ); ?>">Tibisay Morrocoy</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/catatumbo' ) ); ?>">Tibisay Catatumbo</a></li>
                </ul>
            </div>

            <!-- Columna 3: Contacto -->
            <div class="footer-col">
                <h4>Contacto</h4>
                <ul>
                    <li>Merida: 0424 764 8679</li>
                    <li>Margarita: 0424 764 8679</li>
                    <li>Maracaibo: 0412 644 8918</li>
                    <li>Maturin: 0412 358 2965</li>
                    <li>Canaima: 0424 830 8891</li>
                    <li>Morrocoy: 0422 645 4665</li>
                    <li>Catatumbo: 0424 723 9935</li>
                </ul>
            </div>

            <!-- Columna 4: Redes Sociales -->
            <div class="footer-col">
                <h4>Siguenos</h4>
                <ul>
                    <li><a href="#" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                    <li><a href="#" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                    <li><a href="#" target="_blank" rel="noopener noreferrer">Twitter / X</a></li>
                    <li><a href="#" target="_blank" rel="noopener noreferrer">YouTube</a></li>
                </ul>
                <p style="margin-top:1rem;font-size:0.85rem;">
                    <a href="<?php echo esc_url( home_url( '/contacto' ) ); ?>" style="color:#fff;">Escribenos</a>
                </p>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Hoteles Tibisay — OTHTICA. Todos los derechos reservados. Desarrollado por <a href="https://ovavision.ve" target="_blank" rel="noopener noreferrer">OVA VISION</a>.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
