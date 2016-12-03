<?php get_header(); ?>

<div id="content">
	<div class="container">
	<?php if (have_posts()): ?>
		<div class="row">
			<?php while (have_posts()) : the_post(); ?>
				<div class="col-lg-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
						<div class="title"><h2><?php the_title(); ?></h2></div>

						<div class="desc"><?php the_content(); ?></div>

					</article>
				</div>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php
		$args = array(
			'posts_per_page'	=> 3,
			'post_type'			=> 'event',
			'orderby'			=> 'meta_value_num',
			'order'				=> 'ASC',
			'meta_key'			=> 'start_date',
			'post_status'		=> 'publish',
			'meta_query' => array(
				array(
					'key'		=> 'news',
					'value'		=> '"' .$post->ID. '"',
					'compare'	=> 'LIKE',
				),
			),
		);

		$the_query = new WP_Query($args);
		if($the_query):
	?>
			<div class="row">
				<div class="col-lg-12">
					<h3><?php _e('Related Events', THEME_OPT) ?></h3>
				</div>
				<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div class="col-lg-4">
						<div class="event" data-id="<?php echo $post->ID; ?>">
							<h2>
								<a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="desc"><?php event_theme_excerpt('home_excerpt_length', 'theme_more'); ?></p>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>

			</div>
			
		<?php endif; ?>
	<?php else: ?>
		<div class="row">
			<div class="col-lg-12">
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', THEME_OPT ); ?></h2>

				</article>
			</div>
		</div>
	<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>