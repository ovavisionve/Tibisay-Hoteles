<?php
/**
 * Tibisay Hoteles — page.php
 * Template generico de pagina — compatible con Elementor
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="page-content">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php
get_footer();
