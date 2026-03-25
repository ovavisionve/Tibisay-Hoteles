<?php
/**
 * Tibisay Hoteles — front-page.php
 * Plantilla de la pagina de inicio
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/hero-home.jpg');"></div>
    <div class="hero-content">
        <h1>Descubre Venezuela desde sus mejores destinos</h1>
        <p>Siete experiencias unicas en los rincones mas extraordinarios del pais. Mas de 30 anos de tradicion hotelera al servicio de su comodidad.</p>
        <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>" class="btn btn-primary">Reservar Ahora</a>
        <a href="#sedes" class="btn btn-outline" style="margin-left:0.5rem;">Conocer Sedes</a>
    </div>
</section>

<!-- SEDES GRID -->
<section class="section" id="sedes">
    <div class="container">
        <div class="section-title">
            <h2>Nuestras Sedes</h2>
            <p>De los Andes al Caribe, de la selva al relampago. Encuentre su destino ideal en nuestra cadena hotelera.</p>
        </div>

        <div class="sedes-grid">

            <!-- Merida -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-merida.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-merida);">Montana</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Merida</h3>
                    <p>Aventura andina con el calor de siempre. Teleferico, paramos y gastronomia de altura.</p>
                    <a href="<?php echo esc_url( home_url( '/merida' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Margarita -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-margarita.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-margarita);">Playa</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Margarita</h3>
                    <p>Resort frente al mar con Beach Club y experiencias acuaticas en la Isla de Margarita.</p>
                    <a href="<?php echo esc_url( home_url( '/margarita' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Maracaibo -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-maracaibo.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-maracaibo);">Corporativo</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Del Lago</h3>
                    <p>Negocios y turismo frente al Lago de Maracaibo. Ubicacion estrategica para viajeros ejecutivos.</p>
                    <a href="<?php echo esc_url( home_url( '/maracaibo' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Maturin -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-maturin.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-maturin);">Ejecutivo</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Maturin</h3>
                    <p>Servicio VIP para el viajero corporativo frecuente en el corazon de Monagas.</p>
                    <a href="<?php echo esc_url( home_url( '/maturin' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Canaima -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-canaima.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-canaima);">Ecoturismo</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Canaima</h3>
                    <p>A las puertas del Salto Angel. Naturaleza, aventura y experiencias unicas en la Gran Sabana.</p>
                    <a href="<?php echo esc_url( home_url( '/canaima' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Morrocoy -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-morrocoy.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-morrocoy);">Boutique</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Morrocoy</h3>
                    <p>Exclusividad boutique entre cayos cristalinos y snorkeling en el Parque Nacional Morrocoy.</p>
                    <a href="<?php echo esc_url( home_url( '/morrocoy' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

            <!-- Catatumbo -->
            <div class="sede-card">
                <div class="sede-card-img" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-catatumbo.jpg');">
                    <span class="sede-card-badge" style="background:var(--color-catatumbo);">Expedicion</span>
                </div>
                <div class="sede-card-body">
                    <h3>Tibisay Catatumbo</h3>
                    <p>El unico lugar del mundo donde ver el Relampago del Catatumbo. Turismo de expedicion.</p>
                    <a href="<?php echo esc_url( home_url( '/catatumbo' ) ); ?>" class="btn btn-primary">Explorar</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- POR QUE TIBISAY -->
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Por que Hoteles Tibisay</h2>
            <p>Tradicion, calidad y pasion por Venezuela nos definen.</p>
        </div>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">+30</div>
                <h3>Anos de Experiencia</h3>
                <p>Mas de tres decadas creando experiencias memorables en la hoteleria venezolana.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">7</div>
                <h3>Destinos Unicos</h3>
                <p>Desde los Andes hasta el Caribe, con presencia en los mejores rincones del pais.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">&hearts;</div>
                <h3>Servicio Personalizado</h3>
                <p>Atencion cercana y dedicada. Cada huesped es especial para nuestro equipo.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">&star;</div>
                <h3>Experiencias Locales</h3>
                <p>Actividades y gastronomia autenticamente venezolana en cada sede.</p>
            </div>

        </div>
    </div>
</section>

<!-- TESTIMONIOS -->
<section class="section" id="testimonios">
    <div class="container">
        <div class="section-title">
            <h2>Lo que dicen nuestros huespedes</h2>
            <p>Opiniones reales de quienes han vivido la experiencia Tibisay.</p>
        </div>

        <div class="sedes-grid" style="max-width:900px;margin:0 auto;">

            <div class="info-card">
                <p style="font-style:italic;margin-bottom:1rem;">"Una experiencia increible en Merida. El personal siempre atento y las vistas desde el hotel son espectaculares."</p>
                <p style="font-weight:600;color:var(--color-primary);margin:0;">— Huesped, Tibisay Merida</p>
            </div>

            <div class="info-card">
                <p style="font-style:italic;margin-bottom:1rem;">"El Beach Club de Margarita es de lo mejor que hemos visitado. Volvemos cada ano sin falta."</p>
                <p style="font-weight:600;color:var(--color-primary);margin:0;">— Huesped, Tibisay Margarita</p>
            </div>

            <div class="info-card">
                <p style="font-style:italic;margin-bottom:1rem;">"Perfecto para viajes de negocios. Ubicacion centrica, internet estable y excelente servicio."</p>
                <p style="font-weight:600;color:var(--color-primary);margin:0;">— Huesped, Tibisay Del Lago</p>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
