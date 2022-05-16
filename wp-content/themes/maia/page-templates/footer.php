<?php

$footer 	= apply_filters('maia_tbay_get_footer_layout', 'footer_default');

?>

	</div><!-- .site-content -->
	<?php if (maia_tbay_active_newsletter_sidebar()) : ?>
		<div id="newsletter-popup" class="newsletter-popup">
			<?php dynamic_sidebar('newsletter-popup'); ?>
		</div>
	<?php endif; ?>
	
	<?php if( !maia_checkout_optimized() ) : ?>
	<footer id="tbay-footer" <?php maia_tbay_footer_class();?>>
		<?php if ($footer != 'footer_default'): ?>
			
			<?php maia_tbay_display_footer_builder(); ?>

		<?php else: ?> 
			
			<?php get_template_part('page-templates/footer-default'); ?>
			
		<?php endif; ?>			
	</footer><!-- .site-footer -->
	<?php endif; ?>
	
	<?php

    $_id = maia_tbay_random_key();
	$img_back_to_top = maia_tbay_get_config('bg_img_back_to_top');
	
	$type_bg_back_top_top = isset($img_back_to_top['url']) && !empty($img_back_to_top['url']) && maia_tbay_get_config('bg_type_back_to_top') === 'type_image' ? 'enable-bg-img' : 'enable-bg-color';
    ?>

	<?php
    if (maia_tbay_get_config('back_to_top')) { ?>
		<div class="tbay-to-top">
			<a href="javascript:void(0);" id="back-to-top" class="<?php echo trim($type_bg_back_top_top); ?>">
				<i class="tb-icon tb-icon-arrow-top"></i>
				<?php 
					if (isset($img_back_to_top['url']) && !empty($img_back_to_top['url']) && maia_tbay_get_config('bg_type_back_to_top') === 'type_image' ) {
						?>
							<img src="<?php echo esc_url($img_back_to_top['url']); ?>" alt="<?php esc_attr_e('Img back to top', 'maia'); ?>">
						<?php
					}
				?>
			</a>
		</div>
	<?php
    } 
    ?>

	<?php
    if (maia_tbay_get_config('mobile_back_to_top')) { ?>
		<div class="tbay-to-top-mobile tbay-to-top">

			<div class="more-to-top">
			
				<a href="javascript:void(0);" id="back-to-top-mobile" class="<?php echo trim($type_bg_back_top_top); ?>">
				<i class="tb-icon tb-icon-arrow-top"></i>
					<?php 
						if (isset($img_back_to_top['url']) && !empty($img_back_to_top['url']) && maia_tbay_get_config('bg_type_back_to_top') === 'type_image' ) {
							?>
								<img src="<?php echo esc_url($img_back_to_top['url']); ?>" alt="<?php esc_attr_e('Img back to top', 'maia'); ?>">
							<?php
						}
					?>
				</a> 
				
			</div>
		</div>
		
		
	<?php
    }
    ?>
	
	

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>