<?php
/**
 * Plugin Name: CC Simple Testimonials
 * Description: Custom testimonial plugin with rating and shortcode.
 * Version: 1.0
 * Author: Carbon Dev Test
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register Testimonial CPT
 */
function cc_register_testimonial_cpt() {

    register_post_type( 'testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial'
        ],
        'public' => true,
        'has_archive' => false,
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-testimonial'
    ]);

}
add_action( 'init', 'cc_register_testimonial_cpt' );

/**
 * Add Rating Meta Box
 */
function cc_add_rating_meta_box() {
    add_meta_box(
        'cc_testimonial_rating',
        'Testimonial Rating',
        'cc_render_rating_meta_box',
        'testimonial',
        'side'
    );
}
add_action( 'add_meta_boxes', 'cc_add_rating_meta_box' );

function cc_render_rating_meta_box( $post ) {

    wp_nonce_field( 'cc_save_rating', 'cc_rating_nonce' );
    $rating = get_post_meta( $post->ID, '_cc_rating', true );

    ?>
    <select name="cc_rating">
        <option value="">Select Rating</option>
        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
            <option value="<?php echo $i; ?>" <?php selected( $rating, $i ); ?>>
                <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?>
            </option>
        <?php endfor; ?>
    </select>
    <?php
}

/**
 * Save Rating Meta
 */
function cc_save_testimonial_rating( $post_id ) {

    if ( ! isset( $_POST['cc_rating_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['cc_rating_nonce'], 'cc_save_rating' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    if ( isset( $_POST['cc_rating'] ) ) {
        update_post_meta(
            $post_id,
            '_cc_rating',
            intval( $_POST['cc_rating'] )
        );
    }
}
add_action( 'save_post', 'cc_save_testimonial_rating' );

/**
 * Testimonials Shortcode
 */
function cc_testimonials_shortcode() {

    $query = new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => 5
    ]);

    if ( ! $query->have_posts() ) {
        return '<p>No testimonials found.</p>';
    }

    ob_start();

    echo '<div class="cc-testimonials">';

    while ( $query->have_posts() ) {
        $query->the_post();
        $rating = intval( get_post_meta( get_the_ID(), '_cc_rating', true ) );

        echo '<div class="cc-testimonial">';
        echo '<h4>' . esc_html( get_the_title() ) . '</h4>';
        echo '<div>' . wp_kses_post( get_the_content() ) . '</div>';

        if ( $rating ) {
            echo '<div class="cc-rating">';
            echo str_repeat( '★', $rating );
            echo '</div>';
        }

        echo '</div>';
    }

    echo '</div>';

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'cc_testimonials', 'cc_testimonials_shortcode' );
