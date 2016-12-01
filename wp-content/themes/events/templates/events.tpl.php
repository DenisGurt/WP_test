<?php

/**
 * Template Name: Events Page
 */

get_header(); ?>

<div id="content">
	<div class="container">
		<div class="row">
		<?php
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

			$args = array(
				'posts_per_page'	=> 2,
				'post_type'			=> 'event',
				'orderby'			=> 'meta_value_num',
				'order'				=> 'ASC',
				'meta_key'			=> 'start_date',
				'paged'				=> $paged,
				'post_status'		=> 'publish',
			);

			$the_query = new WP_Query($args);
			if ($the_query) :
				while( $the_query->have_posts() ) :
				$the_query->the_post();
		?>
				<div class="col-lg-6">
					<div class="event" data-id="<?php echo $post->ID; ?>">
						<h2>
							<a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="desc"><?php event_theme_excerpt('events_excerpt_length', 'theme_more'); ?></p>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

		</div>
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Pagination -->
				<?php $pagenavi = get_pagenavi_array($the_query); ?>
				<?php if (is_array($pagenavi)) : ?>
					<ul class="pagination">
						<?php foreach ($pagenavi as $key => $link): ?>
							<li><?php echo $link; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php else: ?>
			<div class="row">
				<div class="col-lg-12">
					<h2><?php _e( 'Sorry, nothing to display.', THEME_OPT ); ?></h2>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>