<?php
/**
 * The Template for displaying Products list
 *
 * @package Betheme
 * @author M.Mounir
 * @link http://mounirdesigns.com
 */

get_header();


?> 


<script>


 jQuery(function($) {
	 
	 $(window).load(function(){
	
 $('.image_wrapper a').find('img').each(function(){
  var imgClass = (this.width/this.height > 1) ? 'wide' : 'tall';
  $(this).addClass(imgClass);
 })
})

    var $grid = $('.grid');
    var a=jQuery(".grid").children();

    var b=4;
    
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
		 //$(this).children().addClass('is-checked');
	
         var $buttonGroup = $this.parents('ul.filters_wrapper');
         var filterGroup = $buttonGroup.attr('data-filter-group');
         filters[filterGroup] = $this.attr('data-filter');
         var filterValue = concatValues(filters);
		
				 
         $grid.isotope({
             filter: filterValue
         });
     });
	



	$( 'ul.brands li a' ).live( 'click', function(e){
		e.preventDefault();

		$( 'ul.brands li a.is-checked' ).removeClass( 'is-checked' );
		$( this ).addClass('is-checked');

	});
	
		$( 'ul.showrooms li a' ).live( 'click', function(e){
		e.preventDefault();

		$( 'ul.showrooms li a.is-checked' ).removeClass( 'is-checked' );
		$( this ).addClass('is-checked');

	});
	
		$( 'ul.categories li a' ).live( 'click', function(e){
		e.preventDefault();

		$( 'ul.categories li a.is-checked' ).removeClass( 'is-checked' );
		$( this ).addClass('is-checked');

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
<div id="Subheader" style="">
	<div class="container">
		<div class="column one">
			<h1 class="title">Products</h1>
		</div>
	</div>
</div>
<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<div class="section section-filters">
				<div class="section_wrapper clearfix">

						
					<!-- #Filters -->
						<div id="Filters" class="column one">
							<ul class="filters_buttons">
								<li class="label"><i class="icon-search"></i> Filter by:</li>
								<li class="categories"><a class="open" href="#"><i class="icon-docs"></i>Categories</a></li>
								
								<li class="brands"><a class="open" href="#"><i class="icon-docs"></i>Brands</a></li>
								<li class="showrooms"><a class="open" href="#"><i class="icon-docs"></i>Showrooms</a></li>

							</ul>
							
							
							
							<div class="filters_wrapper">
							<!-- Categories Filters -->
								<ul class="filters_wrapper categories" data-filter-group="category">

		<?php 
		
			// Category | List -------
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
		
			// Category | List -------
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
								
																					<!-- Showroom Filters -->
								<ul class="filters_wrapper showrooms" data-filter-group="showroom">

		<?php 
		
			// Showroom | List -------
			$args = array( 'post_type' => 'showroom' );
			$postslist = get_posts( $args );
			foreach ( $postslist as $post ) : setup_postdata( $post ); ?> 

			<?php echo
			'<li data-filter =".'.$post->post_name.'"><a data-filter =".'.$post->post_name.'">'.$post->post_title.'</a></li>';
							
			endforeach; 
			wp_reset_postdata();	
		?>
									<li data-filter="" class="close is-checked"><a href="#" data-filter=""><i class="icon-cancel"></i></a></li>
								</ul>
								<!-- Showroom Filters -->
						
									
						</div>
					
					</div>
					
					
					
					
				</div>

				<div class="section">
				<div class="section_wrapper clearfix">

					<div class="column one column_portfolio">	
						<div class="portfolio_wrapper isotope_wrapper">
							<ul class="portfolio_group lm_wrapper isotope grid col-4">
							
							<?php
								
								$args = array( 'post_type' => 'product', 'posts_per_page' => -1 );
								$postslist = get_posts( $args );
								foreach ( $postslist as $post ) : setup_postdata( $post );
								$productCat = get_field_object('category');
								$productBrand = get_field_object('brand');
								$productShowroom = get_field_object('showroom');
							?> 
							
	<li class="portfolio-item isotope-item wide tall has-thumbnail <?php echo $productCat['value']->post_name; ?> <?php echo $productBrand['value']->post_name; ?> <?php echo $productShowroom['value']->post_name; ?>" data-cat="<?php echo $productCat['value']->post_name; ?>">
		<div class="portfolio-item-fw-bg" style="background-image:url('<?php echo get_field('thumbnail', $post->ID); ?>');">
			<div class="image_frame scale-with-grid" style="border-color: #CF102D; border-width: 5px;">
				<div class="image_wrapper">
					<a href="<?php echo get_permalink( $post->ID ) ?>">
						<div class="mask"></div>
							<img width="960" height="654" src="<?php echo get_field('thumbnail', $post->ID); ?>" class="scale-with-grid wp-post-image productList" itemprop="image">
					</a>

				</div>
			</div>
		</div>
		<div class="desc" style="text-align: center; background: #cf102d; padding: 10px;">
			<div class="title_wrapper">
				<h5 class="entry-title" itemprop="headline">
					<a class="link" style="color: #FFF;" href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title; ?></a></h5></div></div>
					
	</li>

	
<?php
endforeach; 
wp_reset_postdata();
?>
							<ul>

						</div>
							<div class="column one" id="show-more-wrapper"></div>
					</div>
					
				</div>
			</div>
			
			</div>
			
		</div>
	</div>
</div>

<?php get_footer(); ?>