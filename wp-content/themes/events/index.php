<?php
/**
 * The main template file
 */
get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php _e( 'Latest Posts', THEME_OPT ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>