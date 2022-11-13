<?php
/*
    Template Name: About us
*/
?>
<?php get_header();?>		
		<main class="main-content">
			<div class="container">
				<h2 class="page-title">About us</h2>
				<div class="page-content">
				<?php the_content();?>
				<?php if (0 !== (strlen(get_field('item_1')))) { ?>
					<div class="page-content__row"><!-- start row -->
						<div class="page-content__cell100"><!-- start 100% block -->
							<div class="goals">
								<h3>Our goals</h3>
								<div class="goals__list">
									<div class="goals__item">
										<h6>1</h6>
										<p><?php the_field('item_1');?></p>
									</div>
									<div class="goals__item">
										<h6>2</h6>
										<p><?php the_field('item_2');?></p>
									</div>
									<div class="goals__item">
										<h6>3</h6>
										<p><?php the_field('item_3');?></p>
									</div>
								</div>
							</div><!-- .goals -->
						</div><!-- end 100% block -->
					</div><!-- end row -->
				<?php } ?>
				</div><!--.page-content-->
			</div><!--.container-->
		</main><!--.main-content-->

		
<?php get_footer();?>