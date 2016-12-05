<?php
/**
 * The main template file
 */
get_header(); ?>

	<div id="content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					
					<!-- section -->
					<section>

						<?php get_template_part('loop'); ?>

					</section>
					<!-- /section -->
					
			</div>
		</div>
	</div>

<?php get_footer(); ?>