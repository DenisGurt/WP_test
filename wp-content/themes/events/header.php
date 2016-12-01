<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php bloginfo('name'); ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>

	<!-- wrapper -->
	<div class="wrapper">
		<header>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<a class="logo" href="<?php echo home_url(); ?>">WP Task</a>
					</div>
				</div>
			</div>
		</header>