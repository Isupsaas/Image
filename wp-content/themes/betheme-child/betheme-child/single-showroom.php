<?php
/**
 * The Template for displaying all single catalogs.
 *
 * @package Betheme
 * @author M.Mounir
 * @link http://muffingroup.com
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
<script>
 jQuery(function($) {

    var $grid = $('.grid');
    var a=jQuery(".grid").children();
console.log(a);
    var b=8;
    
    if(a.length>b){a.each(function(c){
        if(c>=b){
            
          $grid.isotope({
                    itemSelector : '.portfolio-item'
                  }); 
        jQuery(this).addClass("hidden");
          
      
                  $grid.isotope('layout');
        }
      //$grid.find(".hidden").detach();
       
    });
                   
               
                   jQuery("#show-more-wrapper").append('<button class="btn-more" id="show-more"> <i class="icon-plus"></i> Load More</button>');
                   jQuery("#show-more").click(function(){
                       var c=jQuery(".grid").children(".hidden");
                       c.each(function(d){
                           if(d<=b){
// jQuery(this).appendTo(".grid");                 
                             jQuery(this).removeClass("hidden");
                                      $grid.isotope('layout');
                                    
                           }
                       });

                       c=jQuery(".grid").children(".hidden");
                       if(c.length==0){
                           jQuery("#show-more").hide()
                       }
                   })
                  }

     var filters = {};
     $('.filters_wrapper').on('click', 'li', function() {
         var $this = $(this);
         var $buttonGroup = $this.parents('ul.filters_wrapper');
         var filterGroup = $buttonGroup.attr('data-filter-group');
         filters[filterGroup] = $this.attr('data-filter');
         var filterValue = concatValues(filters);
         $grid.isotope({
             filter: filterValue
         });
     });

     // change is-checked class on filters
     $('.filters_wrapper').each(function(i, buttonGroup) {
         var $buttonGroup = $(buttonGroup);
         $buttonGroup.on('click', 'a', function() {
             $(this).addClass('is-checked');
             //var sameLevel = $(this).attr("data-filter");
             $buttonGroup.find('.is-checked').removeClass('is-checked');
         });
     });

     function concatValues(obj) {
         var value = '';
         for (var prop in obj) {
             value += obj[prop];
         }
         return value;
     }
 });

</script>
<?php 
	$vendor = get_field('vendor');
	$phone = get_field('phone');
	$email = get_field('email');
	$address = get_field('address');
	$location = get_field('location');
	$thumbnail = get_field('thumbnail');
	
	wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js?sensor=true', true);
?>

<!-- #Content -->
<div id="Content" style="padding-top:0px;">

	<div class="content_wrapper clearfix">
		<div class="entry-content" itemprop="mainContentOfPage">
			<div class="section mcb-section full-width">
				<div class="section_wrapper mcb-section-inner">
					<div class="wrap mcb-wrap one column-margin-0px clearfix">
						<div class="column mcb-column one-third column_image" style="margin:0px; width:30%;">
							<div class="image_wrapper product-thumb" style="background:url('<?php echo $thumbnail; ?>');">
							</div>
						</div>
						
						<div class="column mcb-column two-third column_map" style="margin:0px; width:70%;">
						<script>
						
						function google_maps_568478328f55b(){
						var lat = document.getElementById("google-map-area-568478328f55b").getAttribute("data-lat");
						var lng = document.getElementById("google-map-area-568478328f55b").getAttribute("data-lng");
	
						var latlng = new google.maps.LatLng(lat,lng);
						var draggable = true;
						var myOptions = {	zoom: 13,
											center: latlng,
											mapTypeId: google.maps.MapTypeId.ROADMAP,
											draggable: draggable,
											zoomControl: true,
											mapTypeControl: true,
											streetViewControl: false,
											scrollwheel : false
										};
										
						var map = new google.maps.Map(document.getElementById("google-map-area-568478328f55b"), myOptions);
						var marker = new google.maps.Marker({position: latlng,map: map});
						
						}
						jQuery(document).ready(function($){
							google_maps_568478328f55b();
							});
						</script>
							<div class="google-map-wrapper no_border">
								<div class="google-map-contact-wrapper">
									<div class="get_in_touch">
										<h3><?php single_post_title(); ?></h3>
										<div class="get_in_touch_wrapper">
											<ul>
												<li class="address">
													<span class="icon"><i class="icon-location"></i></span>
													<span class="address_wrapper"><?php echo $address ?></span>
												</li>
												<li class="phone">
													<span class="icon"><i class="icon-phone"></i></span>
													<p><a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a></p>
												</li>
												<?php 
												if($email){
												echo '
												<li class="mail">
													<span class="icon"><i class="icon-mail"></i></span>
													<p><a href="mailto:'.$email.'">'.$email.'</a></p>
												</li>
												';
												}
												?>


												<li class="www">
													<span class="icon"><i class="icon-home"></i></span>
													<p><?php echo $vendor ?></p>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="google-map" id="google-map-area-568478328f55b" data-lat="<?php echo $location['lat'] ?>" data-lng="<?php echo $location['lng'] ?>">
								</div>
							</div>
						</div>
				
				
					</div>
				</div>
			</div>
			
			<div class="section_wrapper mcb-section-inner" style="margin-top: 30px;">
			
				<div class="wrap mcb-wrap one clearfix">
					<div class="column mcb-column one column_fancy_heading">
						<div class="fancy_heading fancy_heading_line">
							<h1 class="title"><?php single_post_title(); ?> Products</h1>
						</div>
					</div>
					<div class="section_wrapper clearfix">

						
					<!-- #Filters -->
						<div id="Filters" class="column one">
							<ul class="filters_buttons">
								<li class="label"><i class="icon-search"></i> Filter by:</li>
								<li class="categories"><a class="open" href="#"><i class="icon-docs"></i>Categories</a></li>
								<li class="brands"><a class="open" href="#"><i class="icon-docs"></i>Brands</a></li>
							</ul>

							<div class="filters_wrapper">
							<!-- Categories Filters -->
								<ul class="filters_wrapper categories" data-filter-group="category">
									<?php 
										$args = array( 'post_type' => 'producttype' );
										$postslist = get_posts( $args );
										foreach ( $postslist as $post ) : setup_postdata( $post ); ?> 

										<?php echo
										'<li data-filter =".'.$post->post_name.'"><a data-filter =".'.$post->post_name.'">'.$post->post_title.'</a></li>';
														
										endforeach; 
										wp_reset_postdata();	
									?>
									<li data-filter="" class="close is-checked"><a href="#" data-filter=""><i class="icon-cancel"></i></a></li>
								</ul>
								<!-- Categories Filters -->
								
								
								<!-- Brands Filters -->
								<ul class="filters_wrapper brands" data-filter-group="brand">
									<?php 
										$args = array( 'post_type' => 'brand' );
										$postslist = get_posts( $args );
										foreach ( $postslist as $post ) : setup_postdata( $post ); ?> 

										<?php echo
										'<li data-filter =".'.$post->post_name.'"><a data-filter =".'.$post->post_name.'">'.$post->post_title.'</a></li>';
														
										endforeach; 
										wp_reset_postdata();	
									?>
									<li data-filter="" class="close is-checked"><a href="#" data-filter=""><i class="icon-cancel"></i></a></li>
								</ul>
								<!-- Brands Filters -->
						</div>
					</div>

				</div>
					<div class="column one column_portfolio">
					
						<div class="portfolio_wrapper isotope_wrapper">
							<ul class="portfolio_group lm_wrapper isotope grid col-4">
							
							<?php
								$currentShowroomID = get_the_ID();
								$currentShowroomProducts = get_posts(array (
								'post_type' => 'product',
									'posts_per_page' => -1,
									'meta_query' => array(
									array(
										'key'       => 'showroom',
										'compare'   => 'LIKE',
										'value'     => $currentShowroomID,
									)
									),
								));

			if($currentShowroomProducts)
			{
			foreach ( $currentShowroomProducts as $product ) : setup_postdata( $product );
				$productCat = get_field( "category", $product->ID );
				$productBrand = get_field( "brand", $product->ID );
			?>
	<li class="portfolio-item isotope-item wide tall has-thumbnail <?php echo $productCat->post_name; ?> <?php echo $productBrand->post_name; ?>" data-brand="<?php echo $productBrand->post_name; ?>" data-cat="<?php echo $productCat->post_name; ?>">
		<div class="portfolio-item-fw-bg" style="background-image:url('<?php echo get_field('thumbnail', $product->ID); ?>');">
			<div class="image_frame scale-with-grid" style="border-color: #CF102D; border-width: 5px;">
				<div class="image_wrapper">
					<a href="<?php echo get_permalink( $product->ID ) ?>">
						<div class="mask"></div>
							<img width="960" height="654" src="<?php echo get_field('thumbnail', $product->ID); ?>" class="scale-with-grid wp-post-image productList" itemprop="image">
					</a>

				</div>
			</div>
		</div>
		<div class="desc" style="text-align: center; background: #cf102d; padding: 10px;">
			<div class="title_wrapper">
				<h5 class="entry-title" itemprop="headline">
					<a class="link" style="color: #FFF;" href="<?php echo get_permalink( $product->ID ) ?>"><?php echo $product->post_title; ?></a></h5></div></div>
					
	</li>
					
							
	<?php
endforeach; 
wp_reset_postdata();
}
?>
							<ul>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>


<?php get_footer(); ?>