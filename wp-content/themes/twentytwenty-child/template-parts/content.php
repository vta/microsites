<?php
/**
 * The child template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 *
 * TEMPLATE OVERRIDE - added query param for email confirmation (line 41)
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php

    get_template_part( 'template-parts/entry-header' );

    if ( ! is_search() ) {
        get_template_part( 'template-parts/featured-image' );
    }

    ?>

    <div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

        <div class="entry-content">

            <?php
            if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
                the_excerpt();
            } else {
                the_content( __( 'Continue reading', 'twentytwenty' ) );
            }

            // Check if email is set as a query param and if it is /email-confirmation page
            if ( isset ( $_GET['email'] ) && get_page_uri( get_the_ID() ) == 'email-confirmation' ) {
              $email = $_GET['email'];
              echo "
                <span class='email-registration'>Sent to email: <strong>$email</strong></span>
              ";
            }
            ?>

        </div><!-- .entry-content -->

    </div><!-- .post-inner -->

    <div class="section-inner">
        <?php
        wp_link_pages(
            array(
                'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
                'after'       => '</nav>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>',
            )
        );

        edit_post_link();

        // Single bottom post meta.
        twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

        if ( is_single() ) {

            get_template_part( 'template-parts/entry-author-bio' );

        }
        ?>

    </div><!-- .section-inner -->

    <?php

    if ( is_single() ) {

        get_template_part( 'template-parts/navigation' );

    }

    /**
     *  Output comments wrapper if it's a post, or if comments are open,
     * or if there's a comment number – and check for password.
     * */
    if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
        ?>

        <div class="comments-wrapper section-inner">

            <?php comments_template(); ?>

        </div><!-- .comments-wrapper -->

        <?php
    }
    ?>

</article><!-- .post -->
