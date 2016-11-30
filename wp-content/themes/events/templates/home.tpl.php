<?php

/**
 * Template Name: Home Page
 */

get_header(); ?>

<div id="content">
	<div class="container">
	<?php
		$today = date('Ymd');

		$args = array(
			'posts_per_page'	=> 5,
			'post_type'			=> 'event',
			'orderby'			=> 'date_start',
			'order'				=> 'DESC',
			'post_status'		=> 'publish',
			'meta_query' => array(
				array(
			        'key'		=> 'start_date',
			        'compare'	=> '>=',
			        'value'		=> $today,
			    ),
			)
		);

		$posts = get_posts($args);
	?>
	<?php if ($posts) : ?>
		<?php foreach($posts as $post): setup_postdata($post); ?>
			<div class="col-lg-4">
				<div class="event" data-id="<?php echo $post->ID; ?>">
					<h1>
						<a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h1>
					<p class="date">Event Date: <?php the_field('start_date'); ?></p>
					<p class="desc"><?php echo get_the_excerpt(); ?></p>
					<?php if (get_field('external_link')): ?>
						<a href="<?php the_field('external_link'); ?>"><?php _e('More information', THEME_OPT); ?></a>
					<?php elseif (get_field('news')): ?>
						<a href="<?php the_field('news'); ?>"><?php _e('More information', THEME_OPT); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>

	<?php else: ?>
		<h2><?php _e( 'Sorry, nothing to display.', THEME_OPT ); ?></h2>
	<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>