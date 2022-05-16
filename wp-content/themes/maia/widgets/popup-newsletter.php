<div class="popupnewsletter">
    <!-- Modal -->
    <div class="modal fade" id="popupNewsletterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup-newsletter-widget widget-newletter">
                        <?php
                            $bg = !empty($image) ? 'style="background-image: url( '. $image .')"' : '';
                        ?>
                        <div class="popup-image" <?php echo trim($bg); ?>></div>
                        <div class="popup-content">
                            <a class="popupnewsletter-close" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#popupNewsletterModal"><i class="tb-icon tb-icon-close-01"></i></a>
                            <?php if (!empty($title)) { ?>
                                <h3>
                                    <span><?php echo trim($title); ?></span>
                                </h3>
                            <?php } ?>  
                            <?php if (!empty($description)) { ?>
                                <p class="description">
                                    <?php echo trim($description); ?>
                                </p>
                            <?php } ?>  
                            <?php
                                if (function_exists('mc4wp_show_form')) {
                                    try {
                                        $form = mc4wp_get_form();
                                        echo do_shortcode('[mc4wp_form id="'. $form->ID .'"]');
                                    } catch (Exception $e) {
                                        esc_html_e('Please create a newsletter form from Mailchip plugins', 'maia');
                                    }
                                }
                            ?>
                            <?php if (isset($socials) && is_array($socials)) { ?>

                            
                            <?php if (count(array_column($socials, 'status')) > 0) : ?> 
                                <ul class="social list-inline style2">
                                    <?php foreach ($socials as $key=>$social):
                                            if (isset($social['status']) && !empty($social['page_url'])): ?>
                                                <li>
                                                    <a href="<?php echo esc_url($social['page_url']);?>" class="<?php echo esc_attr($key); ?>">
                                                        <i class="zmdi zmdi-<?php echo esc_attr($key); ?>"></i><span class="hidden"><?php echo esc_html($social['name']); ?></span>
                                                    </a>
                                                </li>
                                    <?php
                                            endif;
                                        endforeach;
                                    ?>
                                </ul>
                            <?php endif; ?>

                            <?php } ?>


                            <?php if (!empty($message)) { ?>
                                <span class="btn-text-close" data-bs-dismiss="modal" aria-label="Close"><?php echo trim($message); ?></span>
                            <?php } ?>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>