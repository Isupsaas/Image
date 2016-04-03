<?php
/**
 * Template Name: Home Page
 * Description: A Page Template that display home page promoted items.
 *
 * @package Betheme
 * @author M.Mounir
 */

get_header(); 
?>

		<!-- Slick -->
		<script type="text/javascript" src="wp-content/themes/betheme-child/betheme-child/owl/owl.carousel.js"></script>
		<link rel="stylesheet" type="text/css" href="wp-content/themes/betheme-child/betheme-child/owl/owl.theme.css"/>
		<link rel="stylesheet" type="text/css" href="wp-content/themes/betheme-child/betheme-child/owl/owl.carousel.css"/>

		<!-- CSS STYLE-->
		<link rel="stylesheet" type="text/css" href="wp-content/themes/betheme-child/betheme-child/rs-plugin/css/style.css" media="screen" />

		<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
		<script type="text/javascript" src="wp-content/themes/betheme-child/betheme-child/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script type="text/javascript" src="wp-content/themes/betheme-child/betheme-child/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
		<link rel="stylesheet" type="text/css" href="wp-content/themes/betheme-child/betheme-child/rs-plugin/css/settings.css" media="screen" />
		

<!-- #Content -->
<div id="Content" style="padding-top: 0px;">
	<div class="section mcb-section full-width">
		<div class="section_wrapper mcb-section-inner">
			<div class="wrap mcb-wrap one  column-margin-0px clearfix">
				<div class="tp-banner-container">
					<div class="tp-banner" id="mainSlider">
						<ul>
							<!-- SLIDE  -->
							<?php					
								$args = array( 'post_type' => 'showroom', 'meta_key' => 'promoted', 'meta_value' => '1', 'numberposts' => 5 );
								$postslist = get_posts( $args );
								foreach ( $postslist as $post ) : setup_postdata( $post );
							?> 
							<li data-transition="fade" data-slotamount="7" data-masterspeed="100" >
								<!-- MAIN IMAGE -->
								<img src="<?php echo get_field('thumbnail', $post->ID); ?>" data-lazyload="<?php echo get_field('thumbnail', $post->ID); ?>" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
								<!-- LAYERS -->
							</li>
							<?php
							endforeach; 
							wp_reset_postdata();
							?>
		
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	
	
	

	<!-- Catalog of the Day Section -->
	<div class="sections_group codSection">
		<div class="section mcb-section full-width" style="padding-top:20px; padding-bottom:20px; background-color:#050505">
			<div class="section_wrapper mcb-section-inner">
				<div class="wrap mcb-wrap one  column-margin-0px clearfix">
					<div id="owl">
						<!-- SLIDE  -->
						<?php					
							$args = array( 'post_type' => 'catalog', 'meta_key' => 'promoted', 'meta_value' => '1', 'posts_per_page' => -1 );
							$postslist = get_posts( $args );
							foreach ( $postslist as $post ) : setup_postdata( $post );
						?> 
						<a href="<?php echo get_permalink( $post->ID ) ?>">
						<div class="item" style="background:url('<?php echo get_field('thumbnail', $post->ID); ?>');">
						</div>
						</a>
							
						<?php
						endforeach; 
						wp_reset_postdata();
						?>
		
					</div>
				</div>
			</div>
		</div>
	</div>


		<!-- Product of the Day Section -->
		<div class="sections_group podSection">
			<div class="section_wrapper mcb-section-inner">
				<div class="wrap mcb-wrap one clearfix">		
					<div class="column mcb-column one column_fancy_heading pod-heading">
						<div class="fancy_heading fancy_heading_line">
							<span class="slogan">Recent handpicked products</span>
							<h1 class="title">Products of the day</h1>
						</div>
					</div>
					
					<?php
			$podPosts = get_posts(array(
				'numberposts' => 8,
				'post_type' => 'product',
				'meta_key' => 'promoted',
				'meta_value' => '1'
			));

			if($podPosts)
			{
			foreach($podPosts as $podPost)
				{
					echo '
					<div class="column mcb-column one-fourth column_sliding_box ">
						<div class="sliding_box">
							<a href="' . get_permalink($podPost->ID) . '">
								<div class="photo_wrapper">
									<img class="scale-with-grid productImg" src="' . get_field('thumbnail', $podPost->ID) . '" alt="Product 1" width="500" height="500" />
								</div>
									<div class="desc_wrapper">
										<h4>' . get_the_title($podPost->ID) . '</h4>
									</div>
							</a>
						</div>
					</div>';
				}
			}
			?>
					<div class="wrap mcb-wrap one clearfix">	
						<p style="text-align: center;">
							<a class="button btn-more button_left button_large button_js kill_the_icon" href='<?php echo get_post_type_archive_link( 'product' ); ?>' target="_blank">
								<span class="button_icon"><i class="icon-plus"></i></span>
								<span class="button_label">More Products</span>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		
		<!-- Showroom of the Day Section -->
		<div class="sections_group sodSection">
			<div class="section_wrapper mcb-section-inner">
				<div class="wrap mcb-wrap one clearfix">		
					<div class="column mcb-column one column_fancy_heading pod-heading">
						<div class="fancy_heading fancy_heading_line">
							<span class="slogan">Recent handpicked showrooms</span>
							<h1 class="title">Showrooms of the day</h1>
						</div>
					</div>
					<?php
						$sodPosts = get_posts(array(
						  'numberposts' => 5,
						  'post_type' => 'showroom',
						  'meta_key' => 'promoted',
						  'meta_value' => '1'
						));

if($sodPosts)
{
    echo '<div class="column mcb-column one column_portfolio_slider ">
			<div class="portfolio_slider  arrows arrows_always">
				<a class="slider_nav slider_prev themebg" href="#" style="display: block;">
					<i class="icon-left-open-big"></i>
				</a>
				<a class="slider_nav slider_next themebg" href="#" style="display: block;">
					<i class="icon-right-open-big"></i>
				</a>
				<div class="caroufredsel_wrapper" style="display: block; text-align: start; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: auto; width: 1196px; height: 283px; margin: 0px; overflow: hidden; cursor: move;">
					<ul class="portfolio_slider_ul" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 4116px; height: 70px;">';
		foreach($sodPosts as $sodPost)
				  {
			echo ' <li style="width: 294px;">
						<div class="image_frame scale-with-grid">
							<div class="image_wrapper">
								<a href="' . get_permalink($sodPost->ID) . '">
									<div class="mask"></div>
									<img width="960" height="632" src="' . get_field('thumbnail', $sodPost->ID) . '" class="scale-with-grid wp-post-image showroomsCarousel" itemprop="image">
								</a>
								<div class="image_links double">
									<a href="' . get_field('thumbnail', $sodPost->ID) . '" class="zoom" rel="prettyphoto">
									<i class="icon-search"></i>
									</a>
									<a href="' . get_permalink($sodPost->ID) . '" class="link">
									<i class="icon-link"></i>
									</a>
								</div>
							</div>
						</div>
					</li>';
				 }
					echo '</ul>
						</div>
					</div>
				</div>';
				}
?>
	
					<div class="wrap mcb-wrap one clearfix">	
						<p style="text-align: center;">
							<a class="button btn-more button_left button_large button_js kill_the_icon" href='<?php echo get_post_type_archive_link( 'showroom' ); ?>' target="_blank">
								<span class="button_icon"><i class="icon-plus"></i></span>
								<span class="button_label">More Showrooms</span>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<!-- Designers of the Day Section -->
		<div class="sections_group dodSection">
			<div class="section_wrapper mcb-section-inner">
				<div class="wrap mcb-wrap one clearfix">		
					<div class="column mcb-column one column_fancy_heading pod-heading">
						<div class="fancy_heading fancy_heading_line">
							<span class="slogan">Recent handpicked designers</span>
							<h1 class="title">Designers of the day</h1>
						</div>
					</div>
				</div>
				
				<div class="column mcb-column three-fourth">

				<div class="caroufredsel_wrapper">
						<ul class="shop_slider_ul">
							<!-- SLIDE  -->
							<?php					
								$args = array( 'post_type' => 'designer', 'meta_key' => 'promoted', 'meta_value' => '1', 'numberposts' => 6 );
								$designersList = get_posts( $args );
								foreach ( $designersList as $post ) : setup_postdata( $post );
							?> 

							
                <li class="designer status-publish has-post-thumbnail">
                    <div class="item_wrapper">
                        <div class="image_frame scale-with-grid product-loop-thumb">
                            <div class="image_wrapper">
                           
                                    <div class="mask"></div><img width="500" height="500" src="<?php echo get_field('thumbnail', $post->ID); ?>" class="scale-with-grid wp-post-image">
                                <div class="image_links"><a class="zoom" rel="prettyphoto" href="<?php echo get_field('thumbnail', $post->ID); ?>"><i class="icon-search"></i></a></div>
                            </div>
                        </div>
                        <div class="desc">
                            <h4 class="designerName"><a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title; ?></a></h4>
                        </div>
                    </div>
                </li>							
							<?php
							endforeach; 
							wp_reset_postdata();
							?>
		
						</ul>
						</div>
				</div>
				
				<!-- Ad 1 -->
				<div class="column mcb-column one-fourth column_image">
					<div class="image_frame image_item no_link scale-with-grid no_border" style="height: 300px;">
					<?php					
								$args = array( 'post_type' => 'ad', 'numberposts' => 1 );
								$ads = get_posts( $args );
								foreach ( $ads as $post ) : setup_postdata( $post );
							?> 

								<a target="_blank" href="<?php echo get_field('url', $post->ID); ?>"><div class="image_wrapper" style="height: 300px;"><img class="scale-with-grid" src="<?php echo get_field('thumbnail', $post->ID); ?>" style="height: 100%;">
						</div></a>
						
							<?php
							endforeach; 
							wp_reset_postdata();
							?>
					
					</div>
				</div>
				<!-- Ad 1 -->
				
				
			</div>
		</div>

			
	</div>
</div>		
					
<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#owl").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 6,

	  pagination: true,
	  paginationNumbers: true,
	  responsive: true,
      itemsDesktop : [1199,6],
      itemsDesktopSmall : [979,6]
 
  });
					jQuery('#mainSlider').show().revolution(
					{
						sliderType:"carousel",
						dottedOverlay:"none",
						delay:16000,
						startwidth:1170,
						startheight:500,
						hideThumbs:200,
						
						thumbWidth:100,
						thumbHeight:50,
						thumbAmount:5,
						
						navigationType:"bullet",
						navigationArrows:"solo",
						navigationStyle:"preview4",
						
						touchenabled:"on",
						onHoverStop:"on",
						
						swipe_velocity: 0.7,
						swipe_min_touches: 1,
						swipe_max_touches: 1,
						drag_block_vertical: false,
												
												parallax:"mouse",
						parallaxBgFreeze:"on",
						parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
												
						keyboardNavigation:"off",
						
						navigationHAlign:"center",
						navigationVAlign:"bottom",
						navigationHOffset:0,
						navigationVOffset:20,

						soloArrowLeftHalign:"left",
						soloArrowLeftValign:"center",
						soloArrowLeftHOffset:20,
						soloArrowLeftVOffset:0,

						soloArrowRightHalign:"right",
						soloArrowRightValign:"center",
						soloArrowRightHOffset:20,
						soloArrowRightVOffset:0,
								
						shadow:0,
						fullWidth:"on",
						fullScreen:"off",

						spinner:"spinner4",
						
						stopLoop:"off",
						stopAfterLoops:-1,
						stopAtSlide:-1,

						shuffle:"off",
						
						autoHeight:"off",						
						forceFullWidth:"on",						
															
						hideThumbsOnMobile:"off",
						hideNavDelayOnMobile:1500,						
						hideBulletsOnMobile:"off",
						hideArrowsOnMobile:"off",
						hideThumbsUnderResolution:0,
						
			
						fullScreenOffsetContainer: ""	
					});				
				});
				
			</script>
			
<?php get_footer(); ?>