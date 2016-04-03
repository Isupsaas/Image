<?php
/**
 * The Template for displaying all single products.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
?>
<link href="http://inerdeg.com/imageID/wp-content/plugins/rate/jquery.rateyo.css" rel="stylesheet" type="text/css">

<script src="http://inerdeg.com/imageID/wp-content/plugins/rate/jquery.rateyo.js"></script>
<script>

			
jQuery(function($){
	/*Rating*/
	var storedRating = jQuery('#rating').data('rating');
	var user_ID = jQuery('#rating').data('user');
	var post_id = jQuery('#rating').data('post');
	console.log("stored rating is ", storedRating);
			  $("#rating").rateYo({
				  rating: storedRating,
				  fullStar: true,
					onSet: function (rating, rateYoInstance) {
						console.log("new rating = ", rating);
					do_rate_post(user_ID, post_id, rating);
						},
				  
			});
			
			
			
			
	/*Favorite*/
		var likesCount = jQuery( '.likes' ).data( 'likes' );
	$('.likes').text(likesCount+" people added this to favorites");
	console.log("likes count = " + likesCount);

	$(document).on("click", ".liked", function(){
		var post_id = $(this).data( 'postid' );
		do_unlike_post(post_id);
		$(this).removeClass("liked").addClass("unliked");
	});


	$(document).on("click", ".unliked", function(){
		var post_id = $(this).data( 'postid' );
		do_like_post(post_id);
		$(this).removeClass("unliked").addClass("liked");
	});

});
</script>

<div id="Subheader" style="">
	<div class="container">
		<div class="column one">
			<h1 class="title"><?php the_title(); ?></h1><?php echo do_shortcode("[iid_favorites]"); ?>
		</div>
		<div class="column one">
			<?php echo do_shortcode("[iid_reserve]"); ?>
		</div>
		<div class="column one">
			<?php echo do_shortcode("[iid_rating]"); ?>
			
		</div>
		
	</div>
</div>
    <!-- #Content -->
    <div id="Content">
        <div class="content_wrapper clearfix">
            <!-- .sections_group -->
            <div class="sections_group">
                <div class="section_wrapper clearfix" style="margin-bottom:15px;">
                    <div class="post-meta clearfix">
                        <div class="author-date">
                            <?php
                              $post_object = get_field('category');
                              if( $post_object ): 
                                // override $post
                                $post = $post_object;
                                setup_postdata( $post ); 
                            ?>
                                <span class="author">In <b>Category</b> <?php the_title(); ?>,</span>
                                <?php wp_reset_postdata();?>
                                    <?php endif; ?>
                                        <?php
                                            $post_object = get_field('brand');
                                            if( $post_object ): 
                                              // override $post
                                              $post = $post_object;
                                              setup_postdata( $post ); 
                                        ?>
                                            <span class="author"><b>Brand</b> <?php the_title(); ?>,</span>
                                            <?php wp_reset_postdata();?>
                                                <?php endif; ?>
                                                    <?php
                                                      $post_object = get_field('showroom');
                                                      if( $post_object ): 
                                                        // override $post
                                                        $post = $post_object;
                                                        setup_postdata( $post ); 
                                                    ?>
                                            <span class="author"><b>Showroom</b> <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?></a></span>
                                                <?php wp_reset_postdata();?>
                                                <?php endif; ?>
                        </div>
                    </div>
                </div>
				
                <div class="post-wrapper-content" style="margin-bottom: 50px;">
                    <div class="section mcb-section">
                        <div class="section_wrapper mcb-section-inner">
                            <div class="wrap mcb-wrap one clearfix">
                                <!-- Slider -->
                                <div class="column mcb-column three-fifth column_slider" style="margin:0px;">
                                    <h1>Product Gallery</h1>
                                    <div class="content_slider">
                                        <div class="caroufredsel_wrapper">
                                            <?php 
                                                $images = get_field('gallery');
                                                if( $images ): ?>
                                                <ul class="content_slider_ul">
                                                    <?php foreach( $images as $image ): ?>
                                                        <li class="content_slider_li">
                                                            <a href="<?php echo $image['url']; ?>" class="zoom" rel="prettyphoto"><img align="middle" src="<?php echo $image['url']; ?>" class="scale-with-grid wp-post-image product-image"></a>
                                                        </li>
                                                        <?php endforeach; ?>
                                                </ul>
                                                <?php endif; ?>
                                        </div>
                                        <a class="button button_js slider_prev" href="#">
                                            <span class="button_icon"><i class="icon-left-open-big"></i></span>
                                        </a>
                                        <a class="button button_js slider_next" href="#">
                                            <span class="button_icon"><i class="icon-right-open-big"></i></span>
                                        </a>
                                        <div class="slider_pagination"></div>
                                    </div>
                                </div>
                                <div class="column mcb-column two-fifth column_visual">
                                    <h1>Product Description</h1>
                                    <p style="line-height: 20px;">
                                        <?php echo get_field('description');?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>
