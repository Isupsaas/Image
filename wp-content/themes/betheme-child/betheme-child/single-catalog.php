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
    <!-- #Content -->
    <div id="Content">
        <div class="content_wrapper clearfix">
            <!-- .sections_group -->
            <div class="sections_group">
                <div class="post-wrapper-content" style="margin-bottom: 50px;">
                    <div class="section mcb-section">
                        <div class="section_wrapper mcb-section-inner">
                            <div class="wrap mcb-wrap one clearfix" style="text-align: center;">

								<div class="column mcb-column one-second column_quick_fact "><div class="quick_fact"><div class="number-wrapper"><span class="number"><?php echo get_field('year'); ?></span></div><h3 class="title">Year</h3><hr class="hr_narrow"></div></div>
								
								<div class="column mcb-column one-second column_quick_fact "><div class="quick_fact"><div class="number-wrapper"><span class="number"><?php echo get_field('month'); ?></span></div><h3 class="title">Month</h3><hr class="hr_narrow"></div></div>
								
                             <iframe src="http://docs.google.com/gview?url=<?php echo get_field('file'); ?>&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>
