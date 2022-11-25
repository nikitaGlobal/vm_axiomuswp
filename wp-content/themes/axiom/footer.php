<?php if (2==1) { ?>
<div class="contact-us" id="contact-us">
			<div class="container">
				<h2 class="contact-us__title">Contact us</h2>
				<div class="contact-us__cont">					
					<?php echo do_shortcode('[contact-form-7 id="143" title="Контактная форма 1"]');?>
					<img src="<?php echo bloginfo('template_url')?>/img/src/img-woman.png" alt="contact us image" class="contact-us__img">
				</div><!--.contact-us__cont-->
			</div><!--.container-->
		</div><!--.contact-us-->
<?php } ?>

<footer class="footer" id="footer">
			<div class="footer__upper-cont">
				<div class="container">
					<div class="logo-cont">
						<h2 class="footer__logo"><a href="<?php get_template_directory_uri();?>/main-page/" class="footer__logo-img">Axiom</a></h2>
						<p class="footer__address"><?php the_field('adress');?></p>							
					</div>
<?php
					if (2==1) {
						?>
					<div class="footer__services">
						<h3 class="footer__title">Services</h3>
						<div class="footer__services-cont">

						<?php
							wp_nav_menu([
								'menu' => 'servis-menu',
								'container' => false,
								'menu_class' => 'footer__list1',
								'echo' => true,
								'fallback_cb' => 'wp_page_menu',
								'items-wrap' => '<ul>%3$s</ul>',
								'depth' => 10,
							]);
						?>
						</div>
					</div>
<?php } ?>
					<div class="footer__contacts">
						<?php
							wp_nav_menu([
								'menu' => 'footer-menu',
								'container' => false,
								'menu_class' => 'footer__contact-list',
								'echo' => true,
								'fallback_cb' => 'wp_page_menu',
								'items-wrap' => '<ul>%3$s</ul>',
								'depth' => 10,
							]);
						?>
					</div>

					<p class="footer__address-mobile"><?php the_field('adress');?></p>
				</div><!--.container-->
			</div><!--.footer__upper-cont-->

			<div class="footer__lower-cont">
				<div class="container">
					<p class="footer__copyright">Copyright <?php echo gmdate('Y');?> AXIOM</p>
					<a href="<?php echo get_privacy_policy_url();?>" class="footer__policy-link">Privacy policy</a>
					
				</div>
			</div>
			<?php wp_footer();?>
		</footer><!--.footer-->
		<button id="scrollToTopBtn" class="scrollToTopBtn">To The Top</button>
	</body>
</html>