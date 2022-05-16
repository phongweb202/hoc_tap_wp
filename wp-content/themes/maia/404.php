<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Maia
 * @since Maia 1.0
 */
/*

*Template Name: 404 Page
*/
get_header();
$image = maia_tbay_get_config('img_404');
if (isset($image['url']) && !empty($image['url'])) {
    $image = $image['url'];
} else {
    $image = MAIA_IMAGES . '/img-404.jpg';
}
?>

<section id="main-container" class=" container inner page-404">
	<div id="main-content" class="main-page">
		<div class="row">
			<div class="maia-img-404 col-md-6">
				<img src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('Img 404', 'maia'); ?>">
			</div>
			<section class="error-404 col-md-6">

				<h1 class="title-404"><?php esc_html_e('OOPS!', 'maia') ?></h1>
				<h2 class="subtitle-404"><?php esc_html_e('Error 404: Page Not Found', 'maia') ?></h2>

				
				<div class="maia-content-404">
					<p class="sub-title"><?php esc_html_e( 'We’re very sorry but the page you are looking for doesn’t exist or has been moved. Please back to', 'maia') ?> <a href="<?php echo esc_url(home_url( '/' )) ?>" class="back"><?php esc_html_e('home page', 'maia'); ?></a> <?php esc_html_e( 'if It’s mistake.', 'maia') ?></p>
				</div>
			</section><!-- .error-404 -->
		</div>
	</div>
</section>

<?php get_footer(); ?>