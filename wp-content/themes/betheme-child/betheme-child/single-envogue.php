<?php
/**
 * The Template for displaying all single envogues.
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
    <!-- #Content -->
    <div id="Content">
        <div class="content_wrapper clearfix">
            <!-- .sections_group -->
            <div class="sections_group">
                
                <div class="post-wrapper-content" style="margin-bottom: 50px;">
                    <div class="section mcb-section">
                        <div class="section_wrapper mcb-section-inner">
                            <div class="wrap mcb-wrap one clearfix">
                                <!-- Slider -->
                                <div class="column mcb-column three-fifth column_slider" style="margin:0px;">
                                    <h1>En Vouge Gallery</h1>
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
                                    <h1>En Vouge Description</h1>
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
