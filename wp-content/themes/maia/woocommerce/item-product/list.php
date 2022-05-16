<?php
global $product;

?>
<div class="product-block list" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<?php
        /**
        * Hook: maia_woocommerce_before_shop_list_item.
        *
        * @hooked maia_remove_add_to_cart_list_product - 10
        */
        do_action('maia_woocommerce_before_shop_list_item');
    ?>
	<div class="product-content row">
		<div class="block-inner col-lg-4 col-4">
			<?php
                /**
                * Hook: woocommerce_before_shop_loop_item.
                *
                * @hooked woocommerce_template_loop_product_link_open - 10
                */
                do_action('woocommerce_before_shop_loop_item');
            ?>
			<figure class="image <?php maia_product_block_image_class(); ?>">
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="product-image">
					<?php
                        /**
                        * woocommerce_before_shop_loop_item_title hook
                        *
                        * @hooked woocommerce_show_product_loop_sale_flash - 10
                        * @hooked woocommerce_template_loop_product_thumbnail - 10
                        */
                        do_action('woocommerce_before_shop_loop_item_title');
                    ?>
				</a>

				<?php
                    /**
                    * maia_tbay_after_shop_loop_item_title hook
                    *
                    */
                    do_action('maia_tbay_after_shop_loop_item_title');
                ?>
				<?php
                    /**
                    * tbay_woocommerce_before_content_product hook
                    *
                    * @hooked woocommerce_show_product_loop_sale_flash - 10
                    */
                    do_action('tbay_woocommerce_before_content_product');
                ?>
				
			</figure>
		</div>
		<div class="caption col-lg-8 col-8">
            <div class="caption-right">
                
                <div class="group-content">

                    <div class="price-rating">

                        <?php               
                            /**
                            * maia_woo_list_price hook
                            *
                            * @hooked woocommerce_template_loop_price - 5
                            */
                            do_action('maia_woo_list_price');
                        ?>

                        <?php   
                            /**
                            * maia_woo_list_rating hook
                            *
                            * @hooked woocommerce_template_loop_rating - 5
                            */
                            do_action('maia_woo_list_rating');
                        ?>
                    </div>

                    <div class="group-buttons clearfix">	
                        <?php
                            /**
                            * maia_tbay_after_shop_loop_item_title hook
                            *
                            * @hooked maia_the_yith_wishlist - 20
                            * @hooked maia_the_quick_view - 30
                            * @hooked maia_the_yith_compare - 40
                            */
                            do_action('maia_woocommerce_group_buttons', $product->get_id());
                        ?>
                    </div>

                </div>

                <?php maia_the_product_name(); ?>
                <?php
                    /**
                    * maia_after_title_tbay_subtitle hook
                    *
                    * @hooked maia_woo_get_subtitle - 0
                    */
                    do_action('maia_after_title_tbay_subtitle');
                ?>


                <?php
                    do_action('maia_woo_before_shop_list_caption');
                ?>
                
				
				<?php
                if (!empty(get_the_excerpt())) {
                    ?>
					<div class="woocommerce-product-details__short-description">
						<?php the_excerpt(); ?>
					</div>
					<?php
                }
                ?>
				
				   <?php
                    /**
                    * maia_woo_list_after_short_description hook
                    *
                    * @hooked the_woocommerce_variable - 5
                    * @hooked list_variable_swatches_pro - 5
                    * @hooked maia_tbay_total_sales - 15
                    */
                    do_action('maia_woo_list_after_short_description');
                ?>


                <?php
                    /**
                    * Hook: woocommerce_after_shop_loop_item.
                    */
                    do_action('woocommerce_after_shop_loop_item');
                ?>
				
            </div>
	    </div>
	</div>
	<?php
        do_action('maia_woocommerce_after_shop_list_item');
    ?>
</div>


