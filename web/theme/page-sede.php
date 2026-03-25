<?php
/**
 * Template Name: Pagina de Sede
 * Template Post Type: page
 *
 * Tibisay Hoteles — Plantilla individual para cada sede hotelera.
 * El contenido se obtiene de campos personalizados o del contenido de la pagina.
 *
 * Campos personalizados esperados (custom fields):
 *   sede_slug        — merida, margarita, maracaibo, maturin, canaima, morrocoy, catatumbo
 *   sede_estado      — Estado de Venezuela
 *   sede_telefono    — Telefono de contacto
 *   sede_color       — Variable CSS del color (ej. var(--color-merida))
 *   sede_tagline     — Frase corta descriptiva
 *   sede_mapa_embed  — URL de Google Maps embed
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Obtener campos personalizados
$sede_slug    = get_post_meta( get_the_ID(), 'sede_slug', true );
$sede_estado  = get_post_meta( get_the_ID(), 'sede_estado', true );
$sede_telefono = get_post_meta( get_the_ID(), 'sede_telefono', true );
$sede_color   = get_post_meta( get_the_ID(), 'sede_color', true );
$sede_tagline = get_post_meta( get_the_ID(), 'sede_tagline', true );
$sede_mapa    = get_post_meta( get_the_ID(), 'sede_mapa_embed', true );

// Valores por defecto si no hay custom fields
if ( empty( $sede_slug ) ) {
    $sede_slug = sanitize_title( get_the_title() );
}
if ( empty( $sede_color ) ) {
    $sede_color = 'var(--color-primary)';
}

// Datos de sedes para fallback
$sedes_data = array(
    'merida' => array(
        'nombre'   => 'Hotel Tibisay Merida',
        'estado'   => 'Merida',
        'telefono' => '0424 764 8679',
        'tagline'  => 'Aventura andina con el calor de siempre',
        'color'    => 'var(--color-merida)',
        'desc'     => 'Ubicado en el corazon de los Andes venezolanos, el Hotel Tibisay Merida ofrece una experiencia unica entre montanas, paramos y la calidez de nuestra gente. Disfrute del teleferico mas alto del mundo, explore los paramos y deguste la gastronomia local en nuestro restaurante.',
    ),
    'margarita' => array(
        'nombre'   => 'Hotel Tibisay Margarita',
        'estado'   => 'Nueva Esparta',
        'telefono' => '0424 764 8679',
        'tagline'  => 'Resort frente al mar Caribe',
        'color'    => 'var(--color-margarita)',
        'desc'     => 'Nuestro resort en la Isla de Margarita le ofrece lo mejor del Caribe venezolano. Beach Club exclusivo, actividades acuaticas, gastronomia de mar y una ubicacion privilegiada para disfrutar de la Perla del Caribe.',
    ),
    'maracaibo' => array(
        'nombre'   => 'Hotel Tibisay Del Lago',
        'estado'   => 'Zulia',
        'telefono' => '0412 644 8918',
        'tagline'  => 'Negocios y turismo frente al Lago',
        'color'    => 'var(--color-maracaibo)',
        'desc'     => 'Estrategicamente ubicado en Maracaibo, el Hotel Tibisay Del Lago combina comodidad corporativa con turismo de primer nivel. Vista al Lago de Maracaibo, salones de eventos y servicios ejecutivos para el viajero de negocios.',
    ),
    'maturin' => array(
        'nombre'   => 'Hotel Tibisay Maturin',
        'estado'   => 'Monagas',
        'telefono' => '0412 358 2965',
        'tagline'  => 'Servicio VIP para el ejecutivo frecuente',
        'color'    => 'var(--color-maturin)',
        'desc'     => 'En el corazon de Monagas, nuestro hotel atiende al viajero corporativo con la eficiencia y el confort que merece. Habitaciones ejecutivas, conectividad y servicios pensados para estadias productivas.',
    ),
    'canaima' => array(
        'nombre'   => 'Campamento Tibisay Canaima',
        'estado'   => 'Bolivar',
        'telefono' => '0424 830 8891',
        'tagline'  => 'A las puertas del Salto Angel',
        'color'    => 'var(--color-canaima)',
        'desc'     => 'Viva la experiencia del ecoturismo en el Parque Nacional Canaima, Patrimonio de la Humanidad. Excursiones al Salto Angel, recorridos por la Gran Sabana y contacto directo con la naturaleza mas imponente de Venezuela.',
    ),
    'morrocoy' => array(
        'nombre'   => 'Hotel Tibisay Morrocoy',
        'estado'   => 'Falcon',
        'telefono' => '0422 645 4665',
        'tagline'  => 'Exclusividad boutique entre cayos',
        'color'    => 'var(--color-morrocoy)',
        'desc'     => 'Un hotel boutique en el Parque Nacional Morrocoy. Cayos de aguas cristalinas, snorkeling, manglares y la tranquilidad de un destino exclusivo e intimo frente al mar.',
    ),
    'catatumbo' => array(
        'nombre'   => 'Tibisay Catatumbo',
        'estado'   => 'Zulia',
        'telefono' => '0424 723 9935',
        'tagline'  => 'El fenomeno natural unico en el mundo',
        'color'    => 'var(--color-catatumbo)',
        'desc'     => 'El unico lugar del planeta donde se puede observar el Relampago del Catatumbo, un fenomeno meteorologico extraordinario. Turismo de expedicion con la comodidad y seguridad de Hoteles Tibisay.',
    ),
);

// Usar datos del array como fallback
$data = isset( $sedes_data[ $sede_slug ] ) ? $sedes_data[ $sede_slug ] : array();

$nombre   = ! empty( $data['nombre'] ) ? $data['nombre'] : get_the_title();
$estado   = ! empty( $sede_estado ) ? $sede_estado : ( ! empty( $data['estado'] ) ? $data['estado'] : '' );
$telefono = ! empty( $sede_telefono ) ? $sede_telefono : ( ! empty( $data['telefono'] ) ? $data['telefono'] : '' );
$tagline  = ! empty( $sede_tagline ) ? $sede_tagline : ( ! empty( $data['tagline'] ) ? $data['tagline'] : '' );
$color    = ! empty( $sede_color ) ? $sede_color : ( ! empty( $data['color'] ) ? $data['color'] : 'var(--color-primary)' );
$desc     = ! empty( $data['desc'] ) ? $data['desc'] : '';
?>

<!-- HERO DE LA SEDE -->
<section class="hero sede-hero">
    <div class="hero-bg" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/sede-<?php echo esc_attr( $sede_slug ); ?>-hero.jpg');"></div>
    <div class="hero-content">
        <span class="sede-card-badge" style="background:<?php echo esc_attr( $color ); ?>;display:inline-block;margin-bottom:1rem;"><?php echo esc_html( $estado ); ?></span>
        <h1><?php echo esc_html( $nombre ); ?></h1>
        <p><?php echo esc_html( $tagline ); ?></p>
        <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>?sede=<?php echo esc_attr( $sede_slug ); ?>" class="btn btn-primary">Reservar en esta sede</a>
    </div>
</section>

<!-- SOBRE EL HOTEL -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Sobre el Hotel</h2>
        </div>
        <div class="sede-info">
            <div class="info-card">
                <h3>Descripcion</h3>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php if ( get_the_content() ) : ?>
                        <?php the_content(); ?>
                    <?php else : ?>
                        <p><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>
                <?php endwhile; endif; ?>
            </div>
            <div class="info-card">
                <h3>Informacion General</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.75rem;"><strong>Ubicacion:</strong> <?php echo esc_html( $estado ); ?>, Venezuela</li>
                    <li style="margin-bottom:0.75rem;"><strong>Telefono:</strong> <?php echo esc_html( $telefono ); ?></li>
                    <li style="margin-bottom:0.75rem;"><strong>Check-in:</strong> 3:00 PM</li>
                    <li style="margin-bottom:0.75rem;"><strong>Check-out:</strong> 12:00 PM</li>
                    <li><strong>Recepcion:</strong> 24 horas</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- HABITACIONES -->
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Nuestras Habitaciones</h2>
            <p>Confort y descanso en cada una de nuestras opciones de alojamiento.</p>
        </div>

        <div class="rooms-grid">

            <div class="room-card">
                <div class="room-card-img lazy-placeholder" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/room-estandar-<?php echo esc_attr( $sede_slug ); ?>.jpg');"></div>
                <div class="room-card-body">
                    <h3>Habitacion Estandar</h3>
                    <p class="price">Consulte tarifas vigentes</p>
                    <div class="room-amenities">
                        <span>Aire acondicionado</span>
                        <span>TV</span>
                        <span>Wi-Fi</span>
                        <span>Bano privado</span>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>?sede=<?php echo esc_attr( $sede_slug ); ?>&tipo=estandar" class="btn btn-primary">Reservar</a>
                </div>
            </div>

            <div class="room-card">
                <div class="room-card-img lazy-placeholder" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/room-superior-<?php echo esc_attr( $sede_slug ); ?>.jpg');"></div>
                <div class="room-card-body">
                    <h3>Habitacion Superior</h3>
                    <p class="price">Consulte tarifas vigentes</p>
                    <div class="room-amenities">
                        <span>Aire acondicionado</span>
                        <span>TV</span>
                        <span>Wi-Fi</span>
                        <span>Minibar</span>
                        <span>Vista</span>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>?sede=<?php echo esc_attr( $sede_slug ); ?>&tipo=superior" class="btn btn-primary">Reservar</a>
                </div>
            </div>

            <div class="room-card">
                <div class="room-card-img lazy-placeholder" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/room-suite-<?php echo esc_attr( $sede_slug ); ?>.jpg');"></div>
                <div class="room-card-body">
                    <h3>Suite</h3>
                    <p class="price">Consulte tarifas vigentes</p>
                    <div class="room-amenities">
                        <span>Aire acondicionado</span>
                        <span>TV pantalla plana</span>
                        <span>Wi-Fi</span>
                        <span>Minibar</span>
                        <span>Sala de estar</span>
                        <span>Vista privilegiada</span>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>?sede=<?php echo esc_attr( $sede_slug ); ?>&tipo=suite" class="btn btn-primary">Reservar</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SERVICIOS Y ACTIVIDADES -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Servicios y Actividades</h2>
            <p>Todo lo que necesita para una estadia perfecta.</p>
        </div>

        <div class="features">

            <div class="feature">
                <div class="feature-icon">&#9749;</div>
                <h3>Restaurante</h3>
                <p>Gastronomia local e internacional con ingredientes frescos de la region.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">&#9878;</div>
                <h3>Estacionamiento</h3>
                <p>Estacionamiento privado y seguro para nuestros huespedes.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">&#128246;</div>
                <h3>Wi-Fi</h3>
                <p>Conexion a internet en todas las areas del hotel.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">&#9873;</div>
                <h3>Actividades</h3>
                <p>Excursiones y experiencias locales organizadas para nuestros huespedes.</p>
            </div>

        </div>
    </div>
</section>

<!-- GALERIA -->
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Galeria</h2>
            <p>Conozca nuestras instalaciones y alrededores.</p>
        </div>

        <div class="gallery-grid">
            <?php for ( $i = 1; $i <= 8; $i++ ) : ?>
                <div class="gallery-item">
                    <img
                        src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/gallery-<?php echo esc_attr( $sede_slug ); ?>-<?php echo esc_attr( $i ); ?>.jpg"
                        alt="<?php echo esc_attr( $nombre ); ?> — Galeria <?php echo esc_attr( $i ); ?>"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- UBICACION -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Ubicacion</h2>
            <p><?php echo esc_html( $nombre ); ?> — <?php echo esc_html( $estado ); ?>, Venezuela</p>
        </div>

        <div class="map-container">
            <?php if ( ! empty( $sede_mapa ) ) : ?>
                <iframe
                    src="<?php echo esc_url( $sede_mapa ); ?>"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Ubicacion de <?php echo esc_attr( $nombre ); ?>"
                ></iframe>
            <?php else : ?>
                <div style="display:flex;align-items:center;justify-content:center;height:100%;background:var(--color-bg-alt);color:var(--color-text-light);">
                    <p>Mapa disponible proximamente. Contactenos para indicaciones.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- TARIFAS -->
<section class="section section-alt">
    <div class="container text-center">
        <div class="section-title">
            <h2>Tarifas y Disponibilidad</h2>
            <p>Las tarifas varian segun la temporada y el tipo de habitacion. Consulte disponibilidad para las fechas de su interes.</p>
        </div>
        <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>?sede=<?php echo esc_attr( $sede_slug ); ?>" class="btn btn-primary" style="font-size:1.1rem;padding:1rem 3rem;">Consultar Disponibilidad</a>
    </div>
</section>

<!-- CONTACTO DE LA SEDE -->
<section class="section">
    <div class="container">
        <div class="sede-info" style="max-width:600px;margin:0 auto;">
            <div class="info-card" style="grid-column:1/-1;">
                <h3>Contacto Directo</h3>
                <ul style="list-style:none;padding:0;">
                    <li style="margin-bottom:0.75rem;"><strong>Hotel:</strong> <?php echo esc_html( $nombre ); ?></li>
                    <li style="margin-bottom:0.75rem;"><strong>Ubicacion:</strong> <?php echo esc_html( $estado ); ?>, Venezuela</li>
                    <li style="margin-bottom:0.75rem;"><strong>Telefono:</strong> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $telefono ) ); ?>"><?php echo esc_html( $telefono ); ?></a></li>
                    <li><strong>Reservas generales:</strong> <a href="<?php echo esc_url( home_url( '/contacto' ) ); ?>">Formulario de contacto</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
