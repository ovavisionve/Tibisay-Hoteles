<?php
/**
 * Tibisay Hoteles — header.php
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> lang="es">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner">

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php esc_attr_e( 'Inicio — Hoteles Tibisay', 'tibisay' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php
                $logo_id  = get_theme_mod( 'custom_logo' );
                $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="180" height="45" loading="eager">
            <?php else : ?>
                <span style="font-family:var(--font-heading);font-size:1.3rem;font-weight:700;color:var(--color-primary);">
                    Hoteles Tibisay
                </span>
            <?php endif; ?>
        </a>

        <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="main-nav">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav" id="main-nav" role="navigation" aria-label="Menu principal">
            <ul>
                <li>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php if ( is_front_page() ) echo ' class="active"'; ?>>Inicio</a>
                </li>
                <li class="has-submenu">
                    <a href="#" aria-haspopup="true" aria-expanded="false">Sedes</a>
                    <ul class="submenu">
                        <li><a href="<?php echo esc_url( home_url( '/merida' ) ); ?>">Tibisay Merida</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/margarita' ) ); ?>">Tibisay Margarita</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/maracaibo' ) ); ?>">Tibisay Del Lago</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/maturin' ) ); ?>">Tibisay Maturin</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/canaima' ) ); ?>">Tibisay Canaima</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/morrocoy' ) ); ?>">Tibisay Morrocoy</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/catatumbo' ) ); ?>">Tibisay Catatumbo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>"<?php if ( is_page( 'reservas' ) ) echo ' class="active"'; ?>>Reservas</a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url( '/contacto' ) ); ?>"<?php if ( is_page( 'contacto' ) ) echo ' class="active"'; ?>>Contacto</a>
                </li>
                <li class="nav-cta">
                    <a href="<?php echo esc_url( home_url( '/reservas' ) ); ?>">Reservar Ahora</a>
                </li>
            </ul>
        </nav>

    </div>
</header>

<main id="content" role="main">
