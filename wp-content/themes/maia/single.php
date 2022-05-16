<?php

get_header();

$sidebar_configs = maia_tbay_get_blog_layout_configs();
$blog_single_layout =	(isset($_GET['blog_single_layout'])) ? $_GET['blog_single_layout']  :  maia_tbay_get_config('blog_single_layout', 'left-main');

$class_row = ($blog_single_layout === 'main-right') ? 'tb-column-reverse tb-custom-blog' : 'tb-custom-blog';

$class_main_content = (isset($sidebar_configs['sidebar']) && is_active_sidebar($sidebar_configs['sidebar']['id'])) ? 'col-12' : 'col-xxl-9 mx-auto';
$class_check_sidebar = (isset($sidebar_configs['sidebar']) && is_active_sidebar($sidebar_configs['sidebar']['id'])) ? 'active-sidebar' : '';
 

maia_tbay_render_breadcrumbs();

?>


<section id="main-container" class="main-content <?php echo esc_attr(apply_filters('maia_tbay_blog_content_class', 'container')); ?>">
	<div class="row <?php echo esc_attr($class_row); ?> <?php echo esc_attr($class_check_sidebar); ?>">
		
		<?php if ( isset($sidebar_configs['sidebar']) && is_active_sidebar($sidebar_configs['sidebar']['id'])) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['sidebar']['class']) ;?>">
			  	<aside class="sidebar" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_configs['sidebar']['id']); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
		<div id="main-content" class="<?php echo esc_attr($class_main_content) ?> <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content single-post" role="main">
					<?php
                        // Start the Loop.
                        while (have_posts()) : the_post();

                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part('post-formats/content', get_post_format());
                            // Previous/next post navigation.
                            maia_tbay_post_nav();

                            if (maia_tbay_get_config('show_blog_related', false)): ?>
								<div class="related-posts">
									<?php get_template_part('posts-releated'); ?>
								</div>
							<?php
                            endif;
                            
                            // If comments are open or we have at least one comment, load up the comment template.
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;

                            

                        // End the loop.
                        endwhile;
                    ?>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div>	

	</div>	
</section>
<?php get_footer(); ?>