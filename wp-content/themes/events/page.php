<?php get_header(); ?>

<!-- main content goes here -->
<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				
				<!-- section -->
				<section>
					<div class="title"><h1><?php the_title(); ?></h1></div>

				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

					<!-- article -->
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php the_content(); ?>

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

				</section>
				<!-- /section -->
				
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>