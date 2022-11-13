<?php
/*
    Template Name: Contacts
*/
?>
<?php get_header();?>	
		
		<main class="main-content" role="main">
			<div class="map">
				<div id="map"><?php the_field('map');?></div>
			</div>

			<div class="container">
				<div class="page-content page-content_contacts">
					<h1 class="page-title page-title_contacts">Contacts</h1>
					<div class="page-content__row"><!-- start row -->
						<div class="page-content__cell100"><!-- start 100% block -->
							<div class="contacts">
								<div class="contacts__list">
									<div class="contacts__item">
										<h3>Address</h3>
										<p><?php the_field('adress');?></p>
									</div>
									<div class="contacts__item">
										<h3>Work hours</h3>
										<p>
											We work from monday to friday, 10-18:00
										</p>
									</div>
									<div class="contacts__item">
										<h3>Follow Us</h3>
										<p>
											We are no ordinary insurance and reinsurance broker. Founded over twenty years ago, we are one the region’s oldest independent, privately owned insurance broker.
										</p>
										<div class="contacts__social-list">
											<div class="contacts__social-item">
												<a href="<?php the_field('instagram');?>" class="contacts__social-link"><img src="<?php echo bloginfo('template_url')?>/img/instagram.png" alt=""></a>
											</div>
											<div class="contacts__social-item">
												<a href="<?php the_field('linkedin');?>" class="contacts__social-link"><img src="<?php echo bloginfo('template_url')?>/img/linkedin.png" alt=""></a>
											</div>
											<div class="contacts__social-item">
												<a href="<?php the_field('twitter');?>" class="contacts__social-link"><img src="<?php echo bloginfo('template_url')?>/img/twitter.png" alt=""></a>
											</div>
										</div>
									</div>
								</div>
							</div><!--.contacts-->
						</div><!-- end 100% block -->
					</div><!-- end row -->
				</div><!--.page-content-->

				<div class="clients">
					<h2 class="clients__title"><span class="clients__title-cont">Clients</span></h2>
					<div class="clients__list">
						<?php the_field('logo_clients');?>

						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client1.png" alt="client 1" class="clients__img">
						</div>
						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client2.png" alt="client 1" class="clients__img">
						</div>
						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client3.png" alt="client 1" class="clients__img">
						</div>
						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client4.png" alt="client 1" class="clients__img">
						</div>
						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client5.png" alt="client 1" class="clients__img">
						</div>
						<div class="clients__list-item">
							<img src="<?php echo bloginfo('template_url')?>/img/src/client6.png" alt="client 1" class="clients__img">
						</div>
					</div>
				</div>
			</div><!--.container-->
		</main><!--.main-content-->

		<?php get_footer();?>