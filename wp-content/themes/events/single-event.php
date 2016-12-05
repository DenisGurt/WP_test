<?php get_header(); ?>

<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<div class="title"><h2><?php the_title(); ?></h2></div>
					<p class="date">
						<b><?php _e('Event Date:', THEME_OPT);?></b>
						<?php echo date("d/m/Y", strtotime(get_field('start_date'))); ?>
						<?php 
							if(get_field('end_date')) {
								echo ' - ' . date("d/m/Y", strtotime(get_field('end_date')));
							}
						?>
					</p>
					<div class="desc"><?php the_content(); ?></div>

					<?php if (get_field('external_link')): ?>
						<?php
							$external_link = get_field('external_link');
							preg_match( '/^(http|https):\\/\\//', $external_link, $matches);
							if ( ! $matches) {
								$external_link = 'http://' . $external_link;
							}
						?>
						<?php if (filter_var($external_link, FILTER_VALIDATE_URL)) : ?>
							<a href="<?php echo $external_link; ?>" target="_blank"><?php _e('More information', THEME_OPT); ?></a>
						<?php endif; ?>

					<?php elseif (get_field('news')): ?>
						<?php $news_arr = get_field('news'); ?>
						<a href="<?php the_permalink($news_arr[0]->ID); ?>"><?php _e('More information', THEME_OPT); ?></a>
					<?php endif; ?>

				</article>
				<!-- /article -->

			<?php endwhile; ?>

			<?php else: ?>

				<!-- article -->
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', THEME_OPT ); ?></h2>

				</article>
				<!-- /article -->

			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>