<?php
/**
 * Singular Template
 *
 * WordPress currently supports custom post types displayed on the singular post level. This template
 * is a catchall template for the singular views of these posts. It should only be used as a backup or if
 * your custom post type doesn't require a custom structure. The template hierarchy for singular views
 * of post types is like so: $post_type-$template.php, $post_type-$slug.php, $post_type-$id.php,
 * $post_type.php, and singular.php.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content p2blog">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<div class="controls">
					<a href="#" id="togglecomments"><?php _e( 'Hide threads', 'p2' ); ?></a>
                    &nbsp;|&nbsp;
					<a href="#directions" id="directions-keyboard"><?php  _e( 'Keyboard Shortcuts', 'p2' ); ?></a>
				</div>

				<?php hybrid_before_entry(); // Before entry hook ?>

				<div class="entry-content">
					<ul id="postlist">
					<?php p2_load_entry() // loads entry.php ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>
					</ul>
				</div><!-- .entry-content -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- .hentry -->

			<?php hybrid_after_singular(); // After singular hook ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', 'hybrid' ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>
	</div><!-- .content .hfeed -->

<?php get_footer(); ?>
