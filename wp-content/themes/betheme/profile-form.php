<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?><style>table tr:hover td {    background: #fff;}</style>
<div class="fancy_heading fancy_heading_icon">
<h2 class="title"><i class="icon-user"></i> Welcome, <?php if($profileuser->first_name || $profileuser->last_name){
echo esc_attr( $profileuser->first_name ); ?> <?php echo esc_attr( $profileuser->last_name );} else{echo esc_attr( $profileuser->user_login );} ?></h2><div class="inside"><p><big>From your profile you can change your personal information, view reserved products and favorite products</big></p>  </div></div>
<div class="column mcb-column one column_tabs ">
    <div class="jq-tabs tabs_wrapper tabs_vertical ui-tabs ui-widget ui-widget-content ui-corner-all">
        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><i class="icon-user"></i> Account Information</a></li>
            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><i class="icon-tag"></i> Reserved Products</a></li>
            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><i class="icon-star"></i> Favorite Products</a></li>
        </ul>
        
        <div id="-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: block;">
           <div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
		   

	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>
		</table>

		<?php do_action( 'profile_personal_options', $profileuser ); ?>

<h3><?php _e( 'Personal Info', 'theme-my-login' ); ?></h3><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label><span class="description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></span>
<input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <label for="first_name"><?php _e( 'First Name', 'theme-my-login' ); ?></label><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /><input type="text" class="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" style="display:none!important;"/>
<label for="last_name"><?php _e( 'Last Name', 'theme-my-login' ); ?></label><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /><hr>
<h3><?php _e( 'Contact Info', 'theme-my-login' ); ?></h3>
<label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" />
			<?php
			$new_email = get_option( $current_user->ID . '_new_email' );
			if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
		<?php
				printf(
					__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
					'<code>' . $new_email['newemail'] . '</code>',
					esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
			); ?>
			<?php endif; ?>
		<?php
			foreach ( wp_get_user_contact_methods() as $name => $desc ) {
		?>
<label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ); ?>" class="regular-text" />

		<?php
			}
		?>



<hr>
		<table class="tml-form-table">

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		</table>

		<h3><?php _e( 'Account Management', 'theme-my-login' ); ?></h3>
		<table class="tml-form-table">
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
					</button>
					<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
						<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
					</button>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
			<td>
			<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
			<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
				</label>
			</td>
		</tr>
		<?php endif; ?>

		</table>

		<?php do_action( 'show_user_profile', $profileuser ); ?>

		<p class="tml-submit-wrap">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
		</p>
	</form>
</div>
        </div>

        <div id="-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
        
          <div class="column one column_portfolio">	
						<div class="portfolio_wrapper">
							<ul class="portfolio_group lm_wrapper grid col-3">
          <?php
			global $wpdb;
			$table_name = $wpdb->prefix . 'user_post';
			$user_id = $current_user->ID;
			$reservedProducts = $wpdb->get_col( "SELECT post_id FROM $table_name where user_id =$user_id and reseve = 1");
		
			if($reservedProducts)
			{
			foreach($reservedProducts as $reservedProduct)
				{
					echo '
						
						<li class="portfolio-item wide tall has-thumbnail">
								<div class="portfolio-item-fw-bg" style="background-image:url(' . get_field('thumbnail', $reservedProduct) . ');">
			<div class="image_frame scale-with-grid" style="border-color: #CF102D; border-width: 5px;">
				<div class="image_wrapper">
					<a href="'.get_permalink($reservedProduct).'">
						<div class="mask"></div>
							<img width="960" height="654" src="' . get_field('thumbnail', $reservedProduct) . '" class="scale-with-grid wp-post-image productList" itemprop="image">
					</a>

				</div>
			</div>
		</div>
						
								<div class="desc" style="text-align: center; background: #cf102d; padding: 10px;">
			<div class="title_wrapper">
				<h5 class="entry-title" itemprop="headline">
					<a class="link" style="color: #FFF;" href="'.get_permalink($reservedProduct).'">' . get_the_title($reservedProduct) . '</a></h5></div></div>
						</li>';
				}
			}
						else{
				echo '<h1>You did not reserved any products</h1>';
			}
		  ?>
							</ul>

						</div>
						
					</div>

        </div>

        <div id="-3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
       					<div class="column one column_portfolio">	
						<div class="portfolio_wrapper">
							<ul class="portfolio_group lm_wrapper grid col-3">
          <?php
			global $wpdb;
			$table_name = $wpdb->prefix . 'user_post';
			$user_id = $current_user->ID;
			$favoriteProducts = $wpdb->get_col( "SELECT post_id FROM $table_name where user_id =$user_id and is_like = 1");
		
			if($favoriteProducts)
			{
			foreach($favoriteProducts as $favoriteProduct)
				{
					echo '
						
						<li class="portfolio-item wide tall has-thumbnail">
								<div class="portfolio-item-fw-bg" style="background-image:url(' . get_field('thumbnail', $favoriteProduct) . ');">
			<div class="image_frame scale-with-grid" style="border-color: #CF102D; border-width: 5px;">
				<div class="image_wrapper">
					<a href="'.get_permalink($favoriteProduct).'">
						<div class="mask"></div>
							<img width="960" height="654" src="' . get_field('thumbnail', $favoriteProduct) . '" class="scale-with-grid wp-post-image productList" itemprop="image">
					</a>

				</div>
			</div>
		</div>
						
								<div class="desc" style="text-align: center; background: #cf102d; padding: 10px;">
			<div class="title_wrapper">
				<h5 class="entry-title" itemprop="headline">
					<a class="link" style="color: #FFF;" href="'.get_permalink($favoriteProduct).'">' . get_the_title($favoriteProduct) . '</a></h5></div></div>
						</li>';
				}
			}
			
						else{
				echo '<h1>You did not favorite any products</h1>';
			}
		  ?>
		  <?php wp_reset_query(); ?>
							</ul>

						</div>
						
					</div>
        </div>
    </div>
</div>


