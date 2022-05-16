<?php
    global $woocommerce;
    $_id = maia_tbay_random_key();
    
    extract($args);
?>
<div class="tbay-topcart left-right">
 	<div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
        <a class="dropdown-toggle mini-cart v2" data-bs-toggle="offcanvas" data-bs-target="#cart-offcanvas-right" aria-controls="cart-offcanvas-right" href="javascript:void(0);">
			<?php  maia_tbay_minicart_button($icon_mini_cart, $show_title_mini_cart, $title_mini_cart, $price_mini_cart); ?>
        </a>    
    </div> 
	<?php maia_tbay_get_page_templates_parts('offcanvas-cart', 'right'); ?>
</div>    

  