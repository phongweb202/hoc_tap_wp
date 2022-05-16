<?php
    global $woocommerce;
    $_id = maia_tbay_random_key();

    extract($args);
?>
<div class="tbay-topcart popup">
 <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown cart-popup dropdown">
        <a class="dropdown-toggle mini-cart" data-bs-toggle="dropdown" data-bs-auto-close="outside" href="javascript:void(0);" title="<?php esc_attr_e('View your shopping cart', 'maia'); ?>">
			<?php  maia_tbay_minicart_button($icon_mini_cart, $show_title_mini_cart, $title_mini_cart, $price_mini_cart); ?>
        </a>            
        <div class="dropdown-menu">
        	<div class="widget_shopping_cart_content">
            	<?php woocommerce_mini_cart(); ?>
       		</div>
    	</div>
    </div>
</div>     