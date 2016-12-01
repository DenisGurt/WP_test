<?php

/**
 * Template Name: Home Page
 */

get_header(); ?>

<div id="content">
	<div id="latest-events">
		<div class="container">
			<div class="row row-eq-height">
			<?php
				$today = date('Ymd');

				$args = array(
					'posts_per_page'	=> 5,
					'post_type'			=> 'event',
					'orderby'			=> 'date_start',
					'order'				=> 'DESC',
					'post_status'		=> 'publish',
					'meta_query' => array(
						'relation'		=> 'OR',
						array(
					        'key'		=> 'start_date',
					        'compare'	=> '>=',
					        'value'		=> $today,
					    ),
					    array(
					        'key'		=> 'end_date',
					        'compare'	=> '>=',
					        'value'		=> $today,
					    ),
					)
				);

				$posts = get_posts($args);
			?>
			<?php if ($posts) : ?>
				<?php foreach($posts as $i => $post): setup_postdata($post); ?>
				<?php if ($i && $i % 3 == 0): ?>
					</div>
					<div class="row row-eq-height">
				<?php endif; ?>
					<div class="col-lg-4 <?php echo ($i && $i % 3 == 0)?'col-lg-offset-2':''; ?>">
						<div class="event" data-id="<?php echo $post->ID; ?>">
							<h2>
								<a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="date">
								<b><?php _e('Event Date:', THEME_OPT);?></b>
								<?php echo date("d/m/Y", strtotime(get_field('start_date'))); ?>
								<?php 
									if(get_field('end_date')) {
										echo ' - ' . date("d/m/Y", strtotime(get_field('end_date')));
									}
								?>
							</p>
							<p class="desc"><?php event_theme_excerpt('home_excerpt_length', 'theme_more'); ?></p>

							<?php if (get_field('external_link')): ?>
								<a href="<?php the_field('external_link'); ?>"><?php _e('More information', THEME_OPT); ?></a>
							<?php elseif (get_field('news')): ?>
								<?php $news_arr = get_field('news'); ?>
								<a href="<?php the_permalink($news_arr[0]->ID); ?>"><?php _e('More information', THEME_OPT); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>

			<?php else: ?>
				<div class="col-lg-12">
					<h2><?php _e( 'Sorry, nothing to display.', THEME_OPT ); ?></h2>
				</div>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<div id="events-link">
		<div class="row">
			<div class="col-lg-12 text-center">
				<a class="btn btn-primary" href="<?php echo home_url('/events'); ?>"><?php _e('All Events', THEME_OPT); ?></a>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>