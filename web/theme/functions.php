<?php
/**
 * Tibisay Hoteles — functions.php
 * Tema personalizado para Hoteles Tibisay
 *
 * @package TibisayHoteles
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   ESTILOS Y SCRIPTS
   ========================================================================== */

/**
 * Encolar estilos y Google Fonts
 */
function tibisay_enqueue_styles() {
    // Google Fonts — Inter + Playfair Display con font-display:swap
    wp_enqueue_style(
        'tibisay-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap',
        array(),
        null
    );

    // Estilo principal del tema
    wp_enqueue_style(
        'tibisay-style',
        get_stylesheet_uri(),
        array( 'tibisay-google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'tibisay_enqueue_styles' );

/**
 * Encolar scripts personalizados
 */
function tibisay_enqueue_scripts() {
    wp_enqueue_script(
        'tibisay-js',
        get_stylesheet_directory_uri() . '/js/tibisay.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Pasar variables a JS para AJAX
    wp_localize_script( 'tibisay-js', 'tibisayAjax', array(
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'tibisay_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'tibisay_enqueue_scripts' );

/* ==========================================================================
   RENDIMIENTO — Desactivar emoji scripts y jQuery Migrate
   ========================================================================== */

/**
 * Desactivar scripts de emojis de WordPress
 */
function tibisay_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'tibisay_disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'tibisay_disable_emojis_dns_prefetch', 10, 2 );
}
add_action( 'init', 'tibisay_disable_emojis' );

function tibisay_disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }
    return array();
}

function tibisay_disable_emojis_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_filter( $urls, function( $url ) use ( $emoji_svg_url ) {
            return false === strpos( $url, $emoji_svg_url );
        } );
    }
    return $urls;
}

/**
 * Desactivar jQuery Migrate para mejorar rendimiento
 */
function tibisay_remove_jquery_migrate( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}
add_action( 'wp_default_scripts', 'tibisay_remove_jquery_migrate' );

/* ==========================================================================
   SOPORTE DEL TEMA
   ========================================================================== */

function tibisay_theme_setup() {
    // Soporte para titulo dinamico
    add_theme_support( 'title-tag' );

    // Imagenes destacadas
    add_theme_support( 'post-thumbnails' );

    // Logo personalizado
    add_theme_support( 'custom-logo', array(
        'height'      => 90,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Soporte HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Menus de navegacion
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'tibisay' ),
        'footer'  => __( 'Menu del Pie de Pagina', 'tibisay' ),
    ) );

    // Tamanos de imagen optimizados para Venezuela (conexiones lentas)
    add_image_size( 'tibisay-medium', 600, 400, true );
    add_image_size( 'tibisay-large', 1200, 800, true );
}
add_action( 'after_setup_theme', 'tibisay_theme_setup' );

/* ==========================================================================
   WIDGETS
   ========================================================================== */

function tibisay_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Barra Lateral', 'tibisay' ),
        'id'            => 'sidebar',
        'description'   => __( 'Widgets de la barra lateral.', 'tibisay' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( __( 'Pie de Pagina %d', 'tibisay' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( __( 'Columna %d del pie de pagina.', 'tibisay' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'tibisay_widgets_init' );

/* ==========================================================================
   CUSTOM POST TYPE — SEDE
   ========================================================================== */

function tibisay_register_sede_cpt() {
    $labels = array(
        'name'                  => __( 'Sedes', 'tibisay' ),
        'singular_name'         => __( 'Sede', 'tibisay' ),
        'menu_name'             => __( 'Sedes', 'tibisay' ),
        'add_new'               => __( 'Agregar Sede', 'tibisay' ),
        'add_new_item'          => __( 'Agregar Nueva Sede', 'tibisay' ),
        'edit_item'             => __( 'Editar Sede', 'tibisay' ),
        'new_item'              => __( 'Nueva Sede', 'tibisay' ),
        'view_item'             => __( 'Ver Sede', 'tibisay' ),
        'all_items'             => __( 'Todas las Sedes', 'tibisay' ),
        'search_items'          => __( 'Buscar Sedes', 'tibisay' ),
        'not_found'             => __( 'No se encontraron sedes.', 'tibisay' ),
        'not_found_in_trash'    => __( 'No se encontraron sedes en la papelera.', 'tibisay' ),
        'featured_image'        => __( 'Imagen de la Sede', 'tibisay' ),
        'set_featured_image'    => __( 'Establecer imagen de la sede', 'tibisay' ),
        'remove_featured_image' => __( 'Quitar imagen de la sede', 'tibisay' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'sede' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'page-attributes',
        ),
    );

    register_post_type( 'sede', $args );
}
add_action( 'init', 'tibisay_register_sede_cpt' );

/* ==========================================================================
   AJAX — FORMULARIO DE RESERVAS
   ========================================================================== */

function tibisay_handle_reserva() {
    // Verificar nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tibisay_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Error de seguridad. Recargue la pagina e intente de nuevo.' ) );
    }

    // Sanitizar todos los campos
    $nombre     = isset( $_POST['nombre'] )     ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) )     : '';
    $email      = isset( $_POST['email'] )       ? sanitize_email( wp_unslash( $_POST['email'] ) )           : '';
    $telefono   = isset( $_POST['telefono'] )    ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) )   : '';
    $sede       = isset( $_POST['sede'] )        ? sanitize_text_field( wp_unslash( $_POST['sede'] ) )       : '';
    $llegada    = isset( $_POST['llegada'] )     ? sanitize_text_field( wp_unslash( $_POST['llegada'] ) )    : '';
    $salida     = isset( $_POST['salida'] )      ? sanitize_text_field( wp_unslash( $_POST['salida'] ) )     : '';
    $adultos    = isset( $_POST['adultos'] )     ? absint( $_POST['adultos'] )                                : 1;
    $ninos      = isset( $_POST['ninos'] )       ? absint( $_POST['ninos'] )                                  : 0;
    $habitacion = isset( $_POST['habitacion'] )  ? sanitize_text_field( wp_unslash( $_POST['habitacion'] ) ) : '';
    $comentarios = isset( $_POST['comentarios'] ) ? sanitize_textarea_field( wp_unslash( $_POST['comentarios'] ) ) : '';
    $corporativo = isset( $_POST['corporativo'] ) && $_POST['corporativo'] === '1';
    $empresa    = isset( $_POST['empresa'] )     ? sanitize_text_field( wp_unslash( $_POST['empresa'] ) )    : '';

    // Validaciones obligatorias
    if ( empty( $nombre ) || empty( $email ) || empty( $sede ) || empty( $llegada ) || empty( $salida ) ) {
        wp_send_json_error( array( 'message' => 'Por favor complete todos los campos obligatorios.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Por favor ingrese un correo electronico valido.' ) );
    }

    // Validar fechas
    $fecha_llegada = strtotime( $llegada );
    $fecha_salida  = strtotime( $salida );

    if ( ! $fecha_llegada || ! $fecha_salida || $fecha_salida <= $fecha_llegada ) {
        wp_send_json_error( array( 'message' => 'Las fechas ingresadas no son validas.' ) );
    }

    // Sedes permitidas
    $sedes_validas = array( 'merida', 'margarita', 'maracaibo', 'maturin', 'canaima', 'morrocoy', 'catatumbo' );
    if ( ! in_array( $sede, $sedes_validas, true ) ) {
        wp_send_json_error( array( 'message' => 'Sede seleccionada no valida.' ) );
    }

    // Preparar correo de notificacion
    $asunto = sprintf( '[Reserva Tibisay] %s — %s', ucfirst( $sede ), $nombre );

    $cuerpo  = "Nueva solicitud de reserva\n\n";
    $cuerpo .= "Nombre: {$nombre}\n";
    $cuerpo .= "Email: {$email}\n";
    $cuerpo .= "Telefono: {$telefono}\n";
    $cuerpo .= "Sede: " . ucfirst( $sede ) . "\n";
    $cuerpo .= "Fecha de llegada: {$llegada}\n";
    $cuerpo .= "Fecha de salida: {$salida}\n";
    $cuerpo .= "Adultos: {$adultos}\n";
    $cuerpo .= "Ninos: {$ninos}\n";
    $cuerpo .= "Tipo de habitacion: {$habitacion}\n";
    if ( $corporativo ) {
        $cuerpo .= "Viaje corporativo: Si\n";
        $cuerpo .= "Empresa: {$empresa}\n";
    }
    $cuerpo .= "Comentarios: {$comentarios}\n";

    $destinatario = get_option( 'admin_email' );
    $headers      = array( 'Content-Type: text/plain; charset=UTF-8' );

    if ( ! empty( $email ) ) {
        $headers[] = 'Reply-To: ' . $nombre . ' <' . $email . '>';
    }

    wp_mail( $destinatario, $asunto, $cuerpo, $headers );

    wp_send_json_success( array( 'message' => 'Su solicitud de reserva ha sido enviada con exito. Nos comunicaremos pronto con usted.' ) );
}
add_action( 'wp_ajax_tibisay_reserva', 'tibisay_handle_reserva' );
add_action( 'wp_ajax_nopriv_tibisay_reserva', 'tibisay_handle_reserva' );

/* ==========================================================================
   AJAX — FORMULARIO DE CONTACTO
   ========================================================================== */

function tibisay_handle_contacto() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tibisay_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Error de seguridad. Recargue la pagina e intente de nuevo.' ) );
    }

    $nombre  = isset( $_POST['nombre'] )  ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) )         : '';
    $email   = isset( $_POST['email'] )    ? sanitize_email( wp_unslash( $_POST['email'] ) )                : '';
    $telefono = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) )       : '';
    $sede    = isset( $_POST['sede'] )     ? sanitize_text_field( wp_unslash( $_POST['sede'] ) )            : '';
    $motivo  = isset( $_POST['motivo'] )   ? sanitize_text_field( wp_unslash( $_POST['motivo'] ) )          : '';
    $mensaje = isset( $_POST['mensaje'] )  ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) )     : '';

    if ( empty( $nombre ) || empty( $email ) || empty( $mensaje ) ) {
        wp_send_json_error( array( 'message' => 'Por favor complete todos los campos obligatorios.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Por favor ingrese un correo electronico valido.' ) );
    }

    $asunto = sprintf( '[Contacto Tibisay] %s — %s', $motivo, $nombre );

    $cuerpo  = "Nuevo mensaje de contacto\n\n";
    $cuerpo .= "Nombre: {$nombre}\n";
    $cuerpo .= "Email: {$email}\n";
    $cuerpo .= "Telefono: {$telefono}\n";
    $cuerpo .= "Sede: " . ucfirst( $sede ) . "\n";
    $cuerpo .= "Motivo: {$motivo}\n\n";
    $cuerpo .= "Mensaje:\n{$mensaje}\n";

    $destinatario = get_option( 'admin_email' );
    $headers      = array( 'Content-Type: text/plain; charset=UTF-8' );

    if ( ! empty( $email ) ) {
        $headers[] = 'Reply-To: ' . $nombre . ' <' . $email . '>';
    }

    wp_mail( $destinatario, $asunto, $cuerpo, $headers );

    wp_send_json_success( array( 'message' => 'Su mensaje ha sido enviado. Nos pondremos en contacto lo antes posible.' ) );
}
add_action( 'wp_ajax_tibisay_contacto', 'tibisay_handle_contacto' );
add_action( 'wp_ajax_nopriv_tibisay_contacto', 'tibisay_handle_contacto' );

/* ==========================================================================
   AJAX — SUSCRIPCION AL NEWSLETTER
   ========================================================================== */

function tibisay_handle_newsletter() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tibisay_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Error de seguridad. Recargue la pagina e intente de nuevo.' ) );
    }

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $sede  = isset( $_POST['sede'] )  ? sanitize_text_field( wp_unslash( $_POST['sede'] ) ) : '';

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Por favor ingrese un correo electronico valido.' ) );
    }

    // Guardar suscripcion como opcion de WordPress (se migrara a Brevo/Mailchimp)
    $suscriptores = get_option( 'tibisay_newsletter_suscriptores', array() );

    // Verificar duplicados
    $duplicado = false;
    foreach ( $suscriptores as $suscriptor ) {
        if ( $suscriptor['email'] === $email ) {
            $duplicado = true;
            break;
        }
    }

    if ( ! $duplicado ) {
        $suscriptores[] = array(
            'email' => $email,
            'sede'  => $sede,
            'fecha' => current_time( 'mysql' ),
        );
        update_option( 'tibisay_newsletter_suscriptores', $suscriptores );
    }

    wp_send_json_success( array( 'message' => 'Se ha suscrito exitosamente a nuestro boletin informativo.' ) );
}
add_action( 'wp_ajax_tibisay_newsletter', 'tibisay_handle_newsletter' );
add_action( 'wp_ajax_nopriv_tibisay_newsletter', 'tibisay_handle_newsletter' );
