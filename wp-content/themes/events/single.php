<?php get_header(); ?>

<main role="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<div class="title"><h2><?php the_title(); ?></h2></div>

					<div class="desc"><?php the_content(); ?></div>

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
</main>
<?php get_footer(); ?>