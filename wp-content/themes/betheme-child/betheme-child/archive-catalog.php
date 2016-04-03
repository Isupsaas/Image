<?php
/**
 * The Template for displaying Catalog list
 *
 * @package Betheme
 * @author M.Mounir
 * @link http://mounirdesigns.com
 */

get_header();


?> 
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


	 
	 
	 	$( 'ul.month li a' ).live( 'click', function(e){
		e.preventDefault();

		$( 'ul.month li a.is-checked' ).removeClass( 'is-checked' );
		$( this ).addClass('is-checked');

	});
	
		 	$( 'ul.year li a' ).live( 'click', function(e){
		e.preventDefault();

		$( 'ul.year li a.is-checked' ).removeClass( 'is-checked' );
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
								<li class="year"><a class="open" href="#"><i class="icon-docs"></i>Year</a></li>
								<li class="month"><a class="open" href="#"><i class="icon-docs"></i>Month</a></li>

							</ul>
							
							
							
							<div class="filters_wrapper">
							<!-- Categories Filters -->
								<ul class="filters_wrapper year" data-filter-group="year">

		<?php 
			
			
			
			// Years | List -------
			$args = array( 'post_type' => 'catalog' );
			$postslist = get_posts( $args );
			foreach ( $postslist as $post ) : setup_postdata( $post ); ?> 
			
			<?php 
			$cYear = get_field('year');
			echo
			'<li data-filter =".'.$cYear.'"><a data-filter =".'.$cYear.'">'.$cYear.'</a></li>';
							
			endforeach; 
			wp_reset_postdata();	
		?>
									<li data-filter="" class="close is-checked"><a href="#" data-filter=""><i class="icon-cancel"></i></a></li>
								</ul>
								<!-- Year Filters -->
								
								
															<!-- Month Filters -->
								<ul class="filters_wrapper month" data-filter-group="month">

		<?php 
		
			// Category | List -------
			$args = array( 'post_type' => 'catalog' );
			$postslist = get_posts( $args );
			foreach ( $postslist as $post ) : setup_postdata( $post ); ?> 

			<?php
			$cMonth = get_field('month');
			echo
			'<li data-filter =".'.$cMonth.'"><a data-filter =".'.$cMonth.'">'.$cMonth.'</a></li>';
							
			endforeach; 
			wp_reset_postdata();	
		?>
									<li data-filter="" class="close is-checked"><a href="#" data-filter=""><i class="icon-cancel"></i></a></li>
									
								</ul>
								<!-- Brands Filters -->
								
						
									
						</div>
					
					</div>
					
					
					
					
				</div>

				<div class="section">
				<div class="section_wrapper clearfix">

					<div class="column one column_portfolio">	
						<div class="portfolio_wrapper isotope_wrapper">
							<ul class="portfolio_group lm_wrapper isotope grid col-6">
							
							<?php
								
								$args = array( 'post_type' => 'catalog', 'posts_per_page' => -1 );
								$postslist = get_posts( $args );
								foreach ( $postslist as $post ) : setup_postdata( $post );
							?> 
							
	<li class="portfolio-item isotope-item wide tall has-thumbnail <?php echo get_field('year', $post->ID); ?> <?php echo get_field('month', $post->ID); ?>" data-year="<?php echo get_field('year', $post->ID); ?>" data-month="<?php echo get_field('month', $post->ID); ?>">
		<div class="portfolio-item-fw-bg" style="background-image:url('<?php echo get_field('thumbnail', $post->ID); ?>');">
			<div class="image_frame scale-with-grid" style="border-color: #CF102D; border-width: 5px;">
				<div class="image_wrapper">
					<a href="<?php echo get_permalink( $post->ID ) ?>">
						<div class="mask"></div>
							<img width="960" height="654" src="<?php echo get_field('thumbnail', $post->ID); ?>" class="scale-with-grid wp-post-image catalogList" itemprop="image">
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