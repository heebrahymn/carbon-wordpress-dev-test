<?php
/**
 * Template Name: Carbon365 Landing Page
 */

get_header(); ?>

<main id="carbon365" class="carbon365-landing">

    <section class="carbon-posts">
        <h2>Latest Articles</h2>

        <ul class="carbon-post-list">
            <?php
            $recent_posts = new WP_Query([
                'post_type' => 'post',
                'posts_per_page' => 5
            ]);

            if ( $recent_posts->have_posts() ) :
                while ( $recent_posts->have_posts() ) :
                    $recent_posts->the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </section>

    <section class="carbon-hero">
        <h2>Call to Action Buttons</h2>

        <div class="carbon-cta">
            <a href="tel:+2348000000000" class="btn btn-call">Call</a> <span>or</span>
            <a href="https://wa.me/2348000000000" class="btn btn-whatsapp">WhatsApp</a>
        </div>
    </section>

    <section class="carbon-testimonials">
        <h2>Testimonials</h2>

        <?php echo do_shortcode('[cc_testimonials]'); ?>
    </section>

</main>

<?php get_footer(); ?>
