<?php
/**
 * Tibisay Hoteles — index.php
 * Plantilla principal (fallback requerido por WordPress)
 *
 * @package TibisayHoteles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="site-main">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No se encontró contenido.</p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
