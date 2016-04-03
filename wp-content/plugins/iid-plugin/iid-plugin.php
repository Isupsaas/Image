<?php 
    /*
    Plugin Name: IID Plugin
    Plugin URI: http://www.elkady.me
    Description: Plugin for test
    Author: M. Elkady
    Version: 1.0.0
    Author URI: http://www.elkady.me
    */

global $up_db_version;
$up_db_version = '1.0';

global $iid_admin_email;
$iid_admin_email = "mohamedelkady@gmail.com";
global $iid_sender_email;
$iid_sender_email = 'wordpress@mounir.io';



add_action('init', 'iid_myplugin_activate');
function iid_myplugin_activate(){
	iid_setupTypes();
	iid_setup_db();
	add_action( 'rest_api_init', 'iid_addCustomRoutes' );

	// For Admin UI....
	iid_addFilters();
	iid_adminFixForNonAdmins();
	add_action( 'admin_bar_menu', 'iid_modify_admin_bar' );

	// For Web UI...
	add_action('wp_enqueue_scripts', 'iid_loadWebScripts');
	iid_register_shortcodes();

	add_action( 'save_post', 'iid_save_post', 10, 3 );
}

class IIDPostType {
	public $id;
	public $name;
	public $icon;

	public function __construct($id, $name, $icon) {
		$this->id = $id;
		$this->name = $name;
		$this->icon = $icon;
	}

	public function __toString(){
		return "ID: " . $this->id;
	}
}

// Setting types...................................
function iid_setupTypes(){
	$myTypes = array(
		new IIDPostType('Ad', 'Advertisement', 'dashicons-rss'),
		new IIDPostType('ProductType', 'Product Type', 'dashicons-welcome-add-page'),
		new IIDPostType('Brand', 'Brand', 'dashicons-awards'),
		new IIDPostType('Showroom', 'Showroom', 'dashicons-store'),
		new IIDPostType('Product', 'Product', 'dashicons-products'),

		new IIDPostType('Catalog', 'Catalog', 'dashicons-media-document'),
		new IIDPostType('House', 'House', 'dashicons-admin-home'),
		new IIDPostType('EnVogue', 'En Vogue', 'dashicons-screenoptions'),
		new IIDPostType('Designer', 'Designer', 'dashicons-admin-customizer'),
		
		new IIDPostType('Communication', 'Log', 'dashicons-email'),
		new IIDPostType('Notification', 'Notification', 'dashicons-email')
	);
	foreach( $myTypes as $iid_post_type ) {
		$slug_name = $iid_post_type->id;
		$real_name = $iid_post_type->name;
		$labels = array(
	        'name' => $real_name . 's',
	        'singular_name' => $real_name
	    );
	    $args = array(
	        'labels' => $labels,
	        'public' => true,
	        'publicly_queryable' => true,
			'has_archive' => true,
	        'show_in_rest' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => $slug_name ),
	        'capability_type'    => 'post',
	        'supports'           => array( 'title' ),
	        'menu_icon' => $iid_post_type->icon,
			'capabilities' => array(
				'edit_post' => 'edit_'.$slug_name,
				'edit_posts' => 'edit_'.$slug_name.'s',
				'edit_others_posts' => 'edit_other_'.$slug_name.'s',
				'edit_published_posts' => 'edit_published_'.$slug_name,
				'publish_posts' => 'publish_'.$slug_name.'s',
				'read_post' => 'read_'.$slug_name,
				'read_private_posts' => 'read_private_'.$slug_name.'s',
				'delete_post' => 'delete_'.$slug_name,
				'delete_published_posts' => 'delete_published_'.$slug_name
		    ),
		    'map_meta_cap' => true
	    );
	    register_post_type( $slug_name , $args );
	}
}

function iid_save_post( $post_id, $post, $update ){
	if (!isset($post->post_status) || 'publish' != $post->post_status) {
		return;
	}
	if ( 'notification' == $post->post_type ) {
		$post_title = get_the_title( $post_id );
		$post_url = get_permalink( $post_id );

		$fields = get_fields( $post_id );
		$promoted_item = $fields["promoted_item"];
		$message = "New notification with text:" . $fields["text"] . "\n to promot " . $promoted_item->post_type . " with ID: " . $promoted_item->ID;
        wp_mail( 'mohamedelkady@gmail.com', 'Test from WP', $message );

        return iid_send_push_notification($fields["text"], $promoted_item->ID);
    }
}

// Setting up DB
function iid_setup_db() {
	global $wpdb;
	global $up_db_version;
	$table_name = $wpdb->prefix . 'user_post';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT, 
		post_id bigint(20) NOT NULL, 
		user_id bigint(20) NOT NULL, 
		is_like tinyint(1), 
		rating tinyint(1), 
		reseve tinyint(1), 
		UNIQUE KEY id (id) ) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$table_name = $wpdb->prefix . 'user_devices';
	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT, 
		user_id bigint(20) NOT NULL, 
		device_type VARCHAR(24) NOT NULL, 
		pn_token VARCHAR(256) NOT NULL, 
		UNIQUE KEY id (id) ) $charset_collate;";
	dbDelta( $sql );

	add_option( 'up_db_version', $up_db_version );
}

// Setting routes...................................
function iid_addCustomRoutes(){
	register_rest_route( 'wp/v2', '/imageid/homepage', array(
        'methods' => 'GET',
        'callback' => 'iid_get_homepage'
    ) );
	register_rest_route( 'wp/v2', '/imageid/type/(?P<type>\w+)', array(
        'methods' => 'GET',
        'callback' => 'iid_get_list'
    ) );
	register_rest_route( 'wp/v2', '/imageid/type/(?P<type>\w+)/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iid_get_by_id'
    ) );
	register_rest_route( 'wp/v2', '/imageid/showroom/(?P<id>\d+)/products', array(
        'methods' => 'GET',
        'callback' => 'iid_get_showroom_products'
    ) );
	register_rest_route( 'wp/v2', '/imageid/do/communications', array(
        'methods' => 'POST',
        'callback' => 'iid_send_communication'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/like/(?P<post_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iid_like'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/unlike/(?P<post_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iid_unlike'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/rate/(?P<post_id>\d+)/(?P<rating>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iid_rate'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/reserve/(?P<post_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iid_reserve'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/actions', array(
        'methods' => 'GET',
        'callback' => 'iid_get_user_actions'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/profile', array(
        'methods' => 'GET',
        'callback' => 'iid_get_user_profile'
    ) );
	register_rest_route( 'wp/v2', '/imageid/user/(?P<user_id>\d+)/device', array(
        'methods' => 'POST',
        'callback' => 'iid_add_device_token'
    ) );
	register_rest_route( 'wp/v2', '/imageid/test_notification', array(
        'methods' => 'GET',
        'callback' => 'iid_send_test_notification'
    ) );
}

function iid_send_test_notification(){
    return iid_send_push_notification("Test", "3258");
}

function iid_send_push_notification( $message, $post_id){
	// TODO get all IDs
	global $wpdb;
	$table_name = $wpdb->prefix . 'user_devices';
	$user_devices = $wpdb->get_col( "SELECT pn_token FROM $table_name where device_type = 'android'");

	$post_type = get_post_type($post_id);

	// Replace "to" with "registration_ids"
	$body = json_encode(array(
        'notification'   => array(
    		"title" => "Image Interiors",
    		"message" => $message,
    		"msgcnt" => "1",
    		"post_id" => $post_id,
    		"post_type" => $post_type
    	),
        'registration_ids' => $user_devices
    ));
    // 'to'     => "APA91bHX1ZydiORFcYJMqZOoa33wAo1HTXoWGWwT5uZP-zJ_gfncOiDhv5zhTXFLftJF8_20eJnYCiX6ehTveiHclCeRvuL_4a6FIPESH4XfyzuoMhDRuhqsVy_oVOL7WOJ4RjVOm0tC"

    $headers = array( 
		"Content-type" => "application/json" ,
		"Authorization" => "key=AIzaSyDKKMXnAbOHz6PGSAjj6Qn6gBSeAdD8o_Y"
	);

	$response = wp_remote_post(
        "https://gcm-http.googleapis.com/gcm/send",
        array(
        	'headers' => $headers,
            'body' => $body
        )
    );

	$response["request"] = array(
		"headers" => $headers,
		"body" => $body
	);
    return $response;
}

function iid_get_homepage ( $data ) {
	$posts = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type'			=> array( 'designer', 'vendor', 'showroom', 'catalog', 'product', 'house' ),
		'meta_key' => 'promoted',
		'meta_query' => array(
		    array(
		        'key' => 'promoted',
		        'value' => true,
		        'compare' => '=',
		    ),
		)
	));
	return iid_prepare_posts($posts);
}

function iid_get_list( $data ){
	$type = $data["type"];
	$posts = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type'			=> $type
	));
	return iid_prepare_posts($posts);
}

function iid_get_by_id( $data ) {
	$type = $data["type"];
	$posts = get_posts(array(
		'post_type' => $type,
		'post__in' => array($data['id'])
	));
	return iid_prepare_posts($posts);
}

function iid_get_showroom_products( $data ){
	$posts = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type' => 'product',
		'meta_key' => 'showroom',
		'meta_query' => array(
			array(
				'key' => 'showroom',
				'value' => $data['id'],
				'compare' => '='
			)
		)
	));
	return iid_prepare_posts($posts);
}

function iid_send_communication($data){
	$to = $data['to'];
	$toPost = get_post($to);
	$from = $data['from'];
	$fromUser = get_userdata($from);
	$text = $data['text'];

	$user_ID = '1';
	$new_post = array(
		'post_title' => 'From ' . $fromUser->user_login . ' to ' . $toPost->post_title,
		'post_content' => '...',
		'post_status' => 'publish',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => $user_ID,
		'post_type' => 'communication',
		'post_category' => array(0)
	);
	$post_id = wp_insert_post($new_post);

	update_field('from', $fromUser, $post_id);
	update_field('to', $toPost, $post_id);
	update_field('text', $text, $post_id);

	global $iid_admin_email;
	$to_email = get_field("email", $to);
	$toList = array(
		$iid_admin_email,
		get_field("email", $to)
	);

	global $iid_sender_email;
	$headers = 'From: Image <' . $iid_sender_email . '>' . "\r\n";
	$subject = "Communication from Image Interiors Client";
	$body = "You got a communication from Image Interiors client (" . $fromUser->user_login . ")\nMessage: " . $text . "\nPlease reply to: " . $fromUser->user_email;
	wp_mail($toList, $subject, $body, $headers );

	return $post_id;
}

function iid_prepare_posts($posts){
	$res = array();
	if( $posts ):
		foreach( $posts as $post ): 
			$thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
			$p = array(
				'id' => $post->ID,
				'post_date' => $post->post_date,
				'post_title' => $post->post_title,
				'post_type' => $post->post_type,
				'featured_image_thumbnail_url' => $thumbs[0],
				'url' => get_permalink($post->ID)
			);

			$fields = get_fields($post->ID);
			foreach( $fields as $field_name => $value ) {
				$p[$field_name] = $value;
			}

			//array_merge($res, get_fields($post->ID));
			array_push($res, $p);
		endforeach;
	endif;
	return $res;
}

function iid_get_user_actions($data){
	$user_id = $data['user_id'];

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$useractions = $wpdb->get_results( "SELECT *  FROM $table_name WHERE user_id = '$user_id' ");

	return $useractions;
}

function iid_get_user_profile($data){
	$user_id = $data['user_id'];

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$useractions = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id = '$user_id' ");

	$fav_posts = array();
	$res_posts = array();
	foreach ( $useractions as $useraction ) {
		if($useraction->is_like){
			array_push($fav_posts, $useraction->post_id);
		}
		if($useraction->reseve){
			array_push($res_posts, $useraction->post_id);
		}
	}

	$resArray = iid_prepare_posts(get_posts(array(
		'posts_per_page'	=> -1,
		'post_type' => 'product',
		'post__in' => $res_posts
	)));

	$favArray = iid_prepare_posts(get_posts(array(
		'posts_per_page'	=> -1,
		'post_type' => 'product',
		'post__in' => $fav_posts
	)));

	return array(
		'liked' => $favArray,
		'reserved' => $resArray
	);
}

function iid_add_device_token ( $data ){
	$user_id = $data["user_id"];
	$pn_token = $data["pn_token"];
	$device_type = $data["device_type"];

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_devices';

	$record_id = $wpdb->get_var( "SELECT `id` FROM $table_name where pn_token = '$pn_token' and user_id = $user_id" );
	$status = "";

	if($record_id){
		$status = "Old";
	} else {
		$status = "New";

		$wpdb->insert($table_name, array( 
			'user_id' => $user_id, 
			'device_type' => $device_type, 
			"pn_token" => $pn_token
		));

		$record_id = $wpdb->insert_id;
	}

	$p = array(
		'id' => $record_id,
		'success' => 1,
		'device_type' => $device_type,
		'user_id' => $user_id,
		'pn_token' => $pn_token,
		'status' => $status
	);

	return $p;
}

function iid_rate($data){
	$post_id = $data['post_id'];
	$user_id = $data['user_id'];
	$rating = $data['rating'];
	return iid_update_field($post_id, $user_id, 'rating', $rating);
}

function iid_reserve($data){
	$post_id = $data['post_id'];
	$user_id = $data['user_id'];
	$res = iid_update_field($post_id, $user_id, 'reseve', 1);


	global $iid_sender_email;
	global $iid_admin_email;
	$headers = 'From: Image Interiors <' . $iid_sender_email . '>' . "\r\n";
	$subject = "Communication from Image Interiors";
	$body = "User ( " .  get_userdata($user_id)->user_login . " ) reserved product ( " . get_permalink($post_id) . " ) ";
	wp_mail($iid_admin_email, $subject, $body, $headers );

	return $res;
}

function iid_like($data){
	$post_id = $data['post_id'];
	$user_id = $data['user_id'];
	return iid_update_field($post_id, $user_id, 'is_like', 1);
}

function iid_unlike($data){
	$post_id = $data['post_id'];
	$user_id = $data['user_id'];
	return iid_update_field($post_id, $user_id, 'is_like', 0);
}

function iid_update_field($post_id, $user_id, $field, $value){
	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$record_id = $wpdb->get_var( "SELECT `id` FROM $table_name where post_id = $post_id and user_id = $user_id" );

	if($record_id){
		$values = array();
		$values[$field] = $value;
		$wpdb->update($table_name, 
				array( 
					"$field" => $value
				),
				array( 
					'post_id' => $post_id,
					'user_id' => $user_id
				)
			);
	} else {
		$wpdb->insert($table_name, array( 
				'post_id' => $post_id, 
				'user_id' => $user_id, 
				"$field" => $value
			));

		$record_id = $wpdb->insert_id;
	}

	$p = array(
		'id' => $record_id,
		'success' => 1
	);

	return $p;
}


///////////////////////////////////////////////////////////////
// Adding filters to customise post lists
///////////////////////////////////////////////////////////////
function iid_addFilters(){
	add_filter('manage_edit-ad_columns','iid_ad_column_headers');
	add_filter('manage_ad_posts_custom_column','iid_ad_column_data',1,2);

	add_filter('manage_edit-product_columns','iid_product_column_headers');
	add_filter('manage_edit-product_sortable_columns', 'iid_product_sortable_column' );
	add_filter('manage_product_posts_custom_column','iid_product_column_data',1,2);

	add_filter('manage_edit-communication_columns','iid_communication_column_headers');
	add_filter('manage_communication_posts_custom_column','iid_communication_column_data',1,2);
}
function iid_communication_column_headers( $columns ) {
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title' => __('Title'),
		'from'=>__('From'),
		'to'=>__('To'),
		'message'=>__('Message'),
		'date'=>__('Date')
	);
	return $columns;
}
function iid_communication_column_data( $column, $post_id ) {
	$output = '';
	switch( $column ) {
		case 'from':
			$fromField = get_field('from', $post_id );
			$email = $fromField->nickname;
			$output .= $email;
			break;
		case 'to':
			$email = get_field('to', $post_id )->post_title;
			$output .= $email;
			break;
		case 'message':
			$email = get_field('text', $post_id );
			$output .= $email;
			break;
	}
	echo $output;
}
function iid_ad_column_headers( $columns ) {
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Title'),
		'url'=>__('Link'),	
	);
	return $columns;
}
function iid_ad_column_data( $column, $post_id ) {
	$output = '';
	switch( $column ) {
		case 'url':
			$email = get_field('url', $post_id );
			$output .= $email;
			break;
	}
	echo $output;
}

function iid_product_column_headers( $columns ) {
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Title'),
		'category'=>__('Category'),	
		'brand'=>__('Brand'),	
		'showroom'=>__('Showroom'),	
		'promoted'=>__('Promoted?')
	);
	return $columns;
}
function iid_product_sortable_column( $columns ) {
	 $columns['promoted'] = 'promoted';
	 return $columns;
}
function iid_product_column_data( $column, $post_id ) {
	$output = '';
	switch( $column ) {
		case 'category':
			$output .= get_field('category', $post_id )->post_title;
			break;
		case 'brand':
			$output .= get_field('brand', $post_id )->post_title;
			break;
		case 'showroom':
			$output .= get_field('showroom', $post_id )->post_title;
			break;
		case 'promoted':
			if(get_field('promoted', $post_id )){
				$output .= "Yes";
			} else {
				$output .= "No";
			}
			break;
	}
	echo $output;
}


///////////////////////////////////////////////////////////////
// Admin Bar
///////////////////////////////////////////////////////////////
function iid_modify_admin_bar( $wp_admin_bar ){
	if(!current_user_can('administrator')){
		$wp_admin_bar->add_menu( array(
			'id' => 'iid_site_bar_item',
			'title' => __('<img src="'.get_bloginfo('wpurl').'/wp-content/plugins/iid-plugin/logo.png" class="admin-logo" alt="Visit Site" title="Visit Site" />' ),
			'href' => get_bloginfo('wpurl')
		));
	}

	$wp_admin_bar->add_menu( array(
		'id' => 'iid_dashboard_bar_item', 
		'title' => 'Dashboard',
		'href' => 'index.php'
	));

	// Website data menu...
	$wp_admin_bar->add_menu( array(
		'id' => 'iid_website_data_bar_item', 
		'title' => 'Website Data'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_producttype_bar_item', 
		'title' => 'Categories',
		'href' => 'edit.php?post_type=producttype'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_product_bar_item', 
		'title' => 'Products',
		'href' => 'edit.php?post_type=product'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_showroom_bar_item', 
		'title' => 'Showrooms',
		'href' => 'edit.php?post_type=showroom'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_brand_bar_item', 
		'title' => 'Brands',
		'href' => 'edit.php?post_type=brand'
	));


	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_catalog_bar_item', 
		'title' => 'Catalogs',
		'href' => 'edit.php?post_type=catalog'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_house_bar_item', 
		'title' => 'Houses',
		'href' => 'edit.php?post_type=house'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_envogue_bar_item', 
		'title' => 'En Vogue',
		'href' => 'edit.php?post_type=envogue'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_designer_bar_item', 
		'title' => 'Designers',
		'href' => 'edit.php?post_type=designer'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_website_data_bar_item',
		'id' => 'iid_users_bar_item', 
		'title' => 'Users',
		'href' => 'users.php'
	));


	// Campaigns...
	$wp_admin_bar->add_menu( array(
		'id' => 'iid_campaigns_bar_item', 
		'title' => 'Campaigns'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_campaigns_bar_item',
		'id' => 'iid_ad_bar_item', 
		'title' => 'Advertisements',
		'href' => 'edit.php?post_type=ad'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_campaigns_bar_item',
		'id' => 'iid_communication_bar_item', 
		'title' => 'Logs',
		'href' => 'edit.php?post_type=communication'
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'iid_campaigns_bar_item',
		'id' => 'iid_notification_bar_item', 
		'title' => 'Notification',
		'href' => 'edit.php?post_type=notification'
	));
}

///////////////////////////////////////////////////////////////
// Short codes
///////////////////////////////////////////////////////////////
function iid_register_shortcodes(){
	add_shortcode('iid_favorites', 'iid_favorites_shortcode');
	add_shortcode('iid_reserve', 'iid_reserve_shortcode');
	add_shortcode('iid_rating', 'iid_rating_shortcode');
	add_action('wp_ajax_nopriv_iid_unlike', 'iid_ajax_unlike'); // regular website visitor
	add_action('wp_ajax_iid_unlike', 'iid_ajax_unlike'); // admin user
	add_action('wp_ajax_nopriv_iid_like', 'iid_ajax_like'); // regular website visitor
	add_action('wp_ajax_iid_like', 'iid_ajax_like'); // admin user
}



function iid_reserve_shortcode( $args ) {
	$user_ID = get_current_user_id();
	$post_id = get_the_ID();

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$reserveStatus = $wpdb->get_var( "SELECT reseve FROM $table_name where post_id = $post_id and user_id = $user_ID" );
	
	$reserveOutput="";
	if($user_ID < 1){	// Not logged in, will show you nothing
		return $reserveOutput;
	} else {
		// Check if the current user reserved it or not
		if($reserveStatus == 1){
			// User already reserve it, display option to unlike
			$reserveOutput .= '<div class="reserve" style="margin-right: 5px;" data-reserve="'.$reserveStatus.'"> | Reserved </a></div>';
		} else {
			// User didn't like it, display count & option to like
			$reserveStatus = 0;
			$reserveOutput .= '<div class="reserve" style="margin-right: 5px;" data-reserve="'.$reserveStatus.'"> | <a class="reserve_btn" onclick="do_reserve_post(' . $post_id .','. $user_ID.');" style="margin-left: 5px;">Reserve <i class="icon-plus"></i></a></div>';
		}
	}

	$finalOutput = "<div class='likeBox' style='display:inline-flex; position: absolute; left: 274px ; top: 28px;'>".$reserveOutput."</div>";
	
	return $finalOutput;
}

function iid_favorites_shortcode( $args ) {
	$user_ID = get_current_user_id();
	$post_id = get_the_ID();

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$likes_count = $wpdb->get_var( "SELECT count(*) FROM $table_name where post_id = $post_id and is_like = 1" );
	
	$output="";
	if($user_ID < 1){	// Not logged in, will just display the count
		$output .= '<div class="likes" style="margin-right: 5px;" data-likes="'.$likes_count.'">'.$likes_count . ' people added this to favorites</div>';
	} else {
		// Check if the current user liked it or not
		$did_id_liked_it = $wpdb->get_var( "SELECT count(*) FROM $table_name where post_id = $post_id and is_like = 1 and user_id = $user_ID" );
		if($did_id_liked_it > 0){
			// User already liked it, display count & option to unlike
			$output .= '<div class="likes" style="margin-right: 5px;" data-likes="'.$likes_count.'"></div> | <a class="like_btn liked" style="margin-left: 5px;" data-postid="' . $post_id . '">Unfavorite <i class="icon-heart-fa"></i> </a>';
		} else {
			// User didn't like it, display count & option to like
			$output .= '<div class="likes" style="margin-right: 5px;" data-likes="'.$likes_count.'"></div> | <a class="like_btn unliked" style="margin-left: 5px;" data-postid="' . $post_id . '">Favorite <i class="icon-heart-line"></i></a>';
		}
	}

	$finalOutput = "<div class='likeBox' style='display:inline-flex; position: absolute; left: 0px; top: 28px;'>".$output."</div>";
	
	return $finalOutput;
}


function iid_rating_shortcode( $args ) {
	$user_ID = get_current_user_id();
	$post_id = get_the_ID();

	global $wpdb;
	$table_name = $wpdb->prefix . 'user_post';
	$product_rating = $wpdb->get_var( "SELECT rating FROM $table_name where post_id = $post_id and user_id = $user_ID" );
	$output="";
	if($user_ID < 1){	// Not logged in, will not display stars rating
		$output .= '';
	} else {
		// Check if the current user rate it or not
		if(is_null($product_rating)){
			// User didn't rate it display empty stars
			$output .= '<div id="rating" data-rating="0" data-post="'.$post_id.'" data-user="'.$user_ID.'"></div>';
		} else {
			// User rate it, display stars rating
			$output .= '<div id="rating" data-rating="'.$product_rating.'" data-post="'.$post_id.'" data-user="'.$user_ID.'"></div>';
		}
	}

	
	return $output;
}



function iid_ajax_unlike(){
	$user_ID = get_current_user_id();
	$post_id = esc_attr( $_POST['post_id'] );
	$result = iid_update_field($post_id, $user_ID, 'is_like', 0);

	$json_result = json_encode( $result );
	die( $json_result );
	exit;
}

function iid_ajax_like(){
	$user_ID = get_current_user_id();
	$post_id = esc_attr( $_POST['post_id'] );
	$result = iid_update_field($post_id, $user_ID, 'is_like', 1);

	$json_result = json_encode( $result );
	die( $json_result );
	exit;
}

function iid_loadWebScripts(){
	wp_register_script('iid-web-js', plugins_url('/js/iid_web.js',__FILE__), array('jquery'),'',true);
	wp_enqueue_script('iid-web-js');
}


/////////////////////////////////////////////////////////////////////////////////
// Fix Admin UI for non-admins
/////////////////////////////////////////////////////////////////////////////////
function iid_adminFixForNonAdmins(){
    if(!current_user_can('administrator')){
    	add_action('wp_dashboard_setup', 'iid_dashboard_setup');

		remove_action('welcome_panel', 'wp_welcome_panel');
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');

		// Adding custom HTML to create post page
		add_action( 'acf/render_field/type=post_object', 'iid_action_function_name', 10, 1 );

		// Making create post page 1 column
		add_filter( 'get_user_option_screen_layout_ad', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_producttype', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_brand', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_showroom', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_product', 'iid_screen_layout_post' );

		add_filter( 'get_user_option_screen_layout_catalog', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_house', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_envouge', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_designer', 'iid_screen_layout_post' );

		add_filter( 'get_user_option_screen_layout_log', 'iid_screen_layout_post' );
		add_filter( 'get_user_option_screen_layout_communication', 'iid_screen_layout_post' );

		iid_loadAdminScripts();
	}
}

function iid_dashboard_setup() { 
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');  
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');  
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'side');
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');

	add_filter( 'screen_layout_columns', 'iid_layout_columns' );
	add_filter( 'get_user_option_screen_layout_dashboard', 'iid_screen_layout_dashboard' );

	global $wp_meta_boxes;
	wp_add_dashboard_widget(
		'example_dashboard_widget',
		'Image Interiors',
		'iid_dashboard_widget1'
	);
}

function iid_dashboard_widget1(){
	echo '
	<p>Welcome to Image Interiors</p>
	<div>Websiet data</div>
	<ul>
		<li><a href="edit.php?post_type=producttype">Categories</a></li>
		<li><a href="edit.php?post_type=showroom">Showrooms</a></li>
		<li><a href="edit.php?post_type=brand">Brands</a></li>
		<li><a href="edit.php?post_type=product">Products</a></li>
		<li><a href="edit.php?post_type=catalog">Catalogs</a></li>
		<li><a href="edit.php?post_type=house">Houses</a></li>
		<li><a href="edit.php?post_type=envogue">En Vogue</a></li>
		<li><a href="edit.php?post_type=designer">Designers</a></li>
	</ul>

	<hr/>
	<div>Campaigns</div>
	<ul>
		<li><a href="edit.php?post_type=ad">Advertisements</a></li>
		<li><a href="edit.php?post_type=communication">Communications</a></li>
		<li><a href="edit.php?post_type=notification">Notifications</a></li>
	</ul>
	';
}

function iid_layout_columns( $columns ){
	$columns['dashboard'] = 1;
	return $columns;
}

function iid_screen_layout_dashboard(){
	return 1;
}

function iid_action_function_name( $field ) {
	if($field["_name"] == "brand") {
		echo '<p>Add new Brand <a href="post-new.php?post_type=brand" target="_blank">here</a></p>';
	} else if($field["_name"] == "showroom") {
		echo '<p>Add new Showroom <a href="post-new.php?post_type=showroom" target="_blank">here</a></p>';
	} else if($field["_name"] == "category") {
		echo '<p>Add new Category <a href="post-new.php?post_type=producttype" target="_blank">here</a></p>';
	}
	
	//var_dump($field);
}  

function iid_screen_layout_post() {
    return 1;
}

function iid_loadAdminScripts(){
	wp_register_style('iid-admin-css', plugins_url('/css/iid_admin.css',__FILE__));
	wp_enqueue_style('iid-admin-css');
}
?>