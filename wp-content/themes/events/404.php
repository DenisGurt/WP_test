<?php get_header(); ?>

<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

			<!-- article -->
			<article id="post-404">

				<h1><?php _e( 'Page not found', THEME_OPT ); ?></h1>
				<h2>
					<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', THEME_OPT ); ?></a>
				</h2>

			</article>
			<!-- /article -->

			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>