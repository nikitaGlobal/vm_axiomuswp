<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php bloginfo('name'); echo " | ";  bloginfo('description'); ?></title>
		<?php wp_head();?>
	</head>
	<body>
		<header class="header">
			<div class="container header__container">
                <?php the_custom_logo();?>
				<input id="menu-toggle" type="checkbox"/>
				<label class="menu-button-container" for="menu-toggle">
					<span class="menu-button"></span>
				</label>
                <?php
                    wp_nav_menu([
                        'menu' => 'big-menu',
                        'container' => false,
                        'menu_class' => 'main-nav',
                        'echo' => true,
                        'fallback_cb' => 'wp_page_menu',
                        'items-wrap' => '<ul>%3$s</ul>',
                        'depth' => 10,
                    ]);
                ?>
				<a href="#contact-us" class="contact-btn anchor-trigger">Contact us</a>
			</div><!--.container-->
		</header><!--.header-->