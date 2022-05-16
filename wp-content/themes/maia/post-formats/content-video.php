<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */

$columns					= maia_tbay_blog_loop_columns('');
$date 						= maia_tbay_get_boolean_query_var('enable_date');
$author 					= maia_tbay_get_boolean_query_var('enable_author');
$categories 				= maia_tbay_get_boolean_query_var('enable_categories');
$cat_type 					= maia_tbay_categories_blog_type();
$short_descriptions 		= maia_tbay_get_boolean_query_var('enable_short_descriptions');
$read_more 					= maia_tbay_get_boolean_query_var('enable_readmore');
$comment					= maia_tbay_get_boolean_query_var('enable_comment');
$comment_text				= maia_tbay_get_boolean_query_var('enable_comment_text');

$layout_blog   			= apply_filters('maia_archive_layout_blog', 10, 2);

$class_main = $class_left = '';

$videolink =  get_post_meta(get_the_ID(), 'tbay_post_video_link', true);

if (!(isset($videolink) && $videolink)) {
    $content = apply_filters('the_content', get_the_content());
    $video = false;

    // Only get video from the content if a playlist isn't present.
    if (false === strpos($content, 'wp-playlist-script')) {
        $video = get_media_embedded_in_content($content, array( 'video', 'object', 'embed', 'iframe' ));
    }
}

?>
<!-- /post-standard -->
<?php if (! is_single()) : ?>
<div  class="post clearfix <?php echo esc_attr($layout_blog); ?>">
<?php endif; ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
<?php if (is_single()) : ?>
	<div class="entry-single">
	<?php echo maia_tbay_post_media(get_the_excerpt()); ?>
<?php endif; ?>
		<?php
            if (is_single()) : ?>
            <?php if (get_the_category_list() && $categories == 1): ?>
                    <div class="entry-category"><?php maia_the_post_category_full() ?></div>
            <?php endif; ?>
            
            <?php if (get_the_title()) {
                    ?>
                        <h1 class="entry-title">
                            <?php the_title(); ?>
                        </h1>
                    <?php
                } ?>

            <div class="entry-header">
                <?php maia_post_meta(array(
                    'date'     		=> 1,
                    'author'   		=> 1,
                    'comments' 		=> 1,
                    'comments_text' => 1,
                    'tags'     		=> 0,
                    'edit'     		=> 0,
                )); ?>
                
            </div>
            <?php $class_image = ($videolink) ? 'post-preview' : ''; ?>
			<?php
                if ($videolink || has_post_thumbnail()) {
                    ?>
						<div class="content-image <?php echo esc_attr($class_image); ?>">
							<?php if ($videolink) : ?>
								<div class="video-thumb video-responsive"><?php echo wp_oembed_get($videolink); ?></div>
							<?php elseif (has_post_thumbnail()) : ?>
								<?php maia_tbay_post_thumbnail(); ?>
							<?php endif; ?>
						</div>
					<?php
                }
            ?>
        	
			<div class="post-excerpt entry-content">

				<?php the_content(esc_html__('Continue Reading', 'maia')); ?>

				<div class="maia-tag-socials-box"><?php do_action('maia_tbay_post_tag_socials') ?></div>

				<?php do_action('maia_tbay_post_bottom') ?>
				
			</div><!-- /entry-content -->

			<?php
                wp_link_pages(array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'maia') . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'maia') . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ));
            ?>
		<?php endif; ?>
		
    <?php if (! is_single()) : ?>
    		
		<?php
            if (has_post_thumbnail()) {
                ?>
		  	<figure class="entry-thumb <?php echo esc_attr($class_left); ?> <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                <?php maia_tbay_post_thumbnail(); ?>
		  	</figure>
		  	<?php
            }
        ?>

		<div class="entry-content <?php echo esc_attr($class_left); ?> <?php echo (!has_post_thumbnail()) ? 'no-thumb' : ''; ?>">

			<div class="entry-header">
				
                <?php if (get_the_category_list() && $categories == 1): ?>
                    <div class="entry-category"><?php maia_the_post_category_full() ?></div>
                <?php endif; ?>

				

                <?php maia_post_meta(array(
                    'author'     => $author,
                    'date'     => $date,
                    'tags'     => 0,
                    'comments' 		=> $comment,
                    'cats'         => $categories,
                    'comments_text' 		=> $comment_text,
                    'edit'     => 0,
                )); ?>

                <?php maia_post_archive_the_title(); ?>
                
				<?php if ($short_descriptions) : ?>
					<?php maia_post_archive_the_short_description(); ?>
				<?php endif; ?>

				<?php if ($read_more) : ?>
					<?php maia_post_archive_the_read_more(); ?>
				<?php endif; ?>

		    </div>

		</div>
    <?php endif; ?>
    <?php if (is_single()) : ?>
</div>
<?php endif; ?>
</article>

<?php if (! is_single()) : ?>
</div>
<?php endif; ?>