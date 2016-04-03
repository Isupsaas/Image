<?php
/**
 * The Template for displaying all single houses.
 *
 * @package Betheme
 * @author M.Mounir
 * @link http://mounirdesigns.com
 */

get_header();
?>
<div id="Subheader" style="">
	<div class="container">
		<div class="column one">
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<?php 
	$website = get_field('website');
	$phone = get_field('phone');
	$email = get_field('email');
	$cover_photo = get_field('cover_photo');
	$thumbnail = get_field('thumbnail');

?>

<!-- #Content -->
<div id="Content" style="padding-top:0px;">

	<div class="content_wrapper clearfix">
		<div class="entry-content" itemprop="mainContentOfPage">
			<div class="section mcb-section full-width">
				<div class="section_wrapper mcb-section-inner" style="max-width: 100%!important;">
					<div class="wrap mcb-wrap one column-margin-0px clearfix">
					
					<div class="image_wrapper designer-cover" style="background:url('<?php echo $cover_photo; ?>') center center;">
					<h1 class="designer-name"><?php single_post_title(); ?></h1>
					<div class="designer-contact-info section_wrapper clearfix">
					<a class="call-to-action" href="mailto:<?php echo $email; ?>" target="_blank">
						<span class="button_icon"><i class="icon-email"></i></span>
						<span class="button_label">Email Me</span></a>
						
						
					<a class="call-to-action" href="tel:<?php echo $phone; ?>" target="_blank">
						<span class="button_icon"><i class="icon-phone"></i></span>
						<span class="button_label">Call Me</span></a>
						
					<a class="call-to-action" href="<?php echo $website; ?>" target="_blank">
						<span class="button_icon"><i class="icon-globe"></i></span>
						<span class="button_label">Visit My Website</span></a>
					</div>
					
					</div>
					</div>
					<div class="image_wrapper designer-thumb" style="background:url('<?php echo $thumbnail; ?>');">
					</div>

					</div>
				</div>
			</div>
			
			<div class="section_wrapper mcb-section-inner" style="margin-top: 130px;">
			
				<div class="wrap mcb-wrap one clearfix">
					<div class="column mcb-column one column_fancy_heading">
						<div class="fancy_heading fancy_heading_line">
							<h1 class="title"><?php single_post_title(); ?> Gallery</h1>
						</div>
					</div>


<div class="column mcb-column one column_slider ">
    <div class="content_slider ">
        <div class="caroufredsel_wrapper">
            <ul class="content_slider_ul gallery" id="gallery">
							<?php

			$designerGallery = get_field('gallery', $post->ID);
			if($designerGallery)
			{
			foreach ( $designerGallery as $galleryItem ) : setup_postdata( $galleryItem );
			?>
			    <a href="<?php echo $galleryItem['url'] ?>" rel="prettyphoto[gallery]"><li class="content_slider_li gallery-item"><img src="<?php echo $galleryItem['url'] ?>" class="scale-with-grid wp-post-image"></li></a>
					
							
	<?php
endforeach; 
wp_reset_postdata();
}
?>

            </ul>
        </div><a class="button button_js slider_prev" href="#" style="display: block;"><span class="button_icon"><i class="icon-left-open-big"></i></span></a><a class="button button_js slider_next" href="#" style="display: block;"><span class="button_icon"><i class="icon-right-open-big"></i></span></a>
        <div class="slider_pagination" style="display: block;"></div>
    </div>
</div>


			</div>
		</div>
	</div>		
</div>


<?php get_footer(); ?>