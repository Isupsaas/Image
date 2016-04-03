jQuery(function($) {
	
	var data = {
    action: 'is_user_logged_in'
};

jQuery.post('http://inerdeg.com/imageID/wp-admin/admin-ajax.php', data, function(response) {

    if(response == 'yes') {
$('.top_bar_right_wrapper').append('<a id="search_button" href="http://inerdeg.com/imageID/your-profile/"><i class="icon-user"></i> My Profile</a>');
       $('.top_bar_right_wrapper').append('<a id="search_button" href="http://inerdeg.com/imageID/logout/?_wpnonce=2db104998f"><i class="icon-lock"></i> Logout</a>');

    } else {
       $('.top_bar_right_wrapper').append('<a id="search_button" href="http://inerdeg.com/imageID/login/"><i class="icon-lock-open"></i> Login</a>');
    }
});

});

function do_like_post (post_id) {
	console.log("I'll like post.." + post_id);
	var data = {
		post_id: post_id
	}
	jQuery.post('/imageID/wp-admin/admin-ajax.php?action=iid_like',data).done(function(response) { 
		console.log(response);
	});

	jQuery(function($) {
		$('.like_btn i').removeClass('icon-heart-linez').addClass('icon-heart-fa');
		$('.like_btn').text("Unfavorite");
		$('.like_btn').append('<i class="icon-heart-fa"></i> ');


		var likesCount = jQuery( '.likes' ).data( 'likes' );
		likesCount = likesCount + 1;
		$('.likes').text(likesCount + " people added this to favorites");
		$('.likes').attr('data-likes', likesCount);
		console.log("new likes count = " + likesCount);
	});
}

function do_unlike_post (post_id) {
	var data = {
		post_id: post_id
	}
	jQuery.post('/imageID/wp-admin/admin-ajax.php?action=iid_unlike',data).done(function(response) {
		console.log(response);
	});
	
	jQuery(function($) {
		$('.like_btn i').removeClass('icon-heart-fa').addClass('icon-heart-line');
		$('.like_btn').text("Favorite");
		$('.like_btn').append('<i class="icon-heart-line"></i>');


		var likesCount = jQuery( '.likes' ).data( 'likes' );
		likesCount = likesCount - 1;
		$('.likes').text(likesCount + " people added this to favorites");
		$('.likes').attr('data-likes', likesCount);
		console.log("new likes count = " + likesCount);
	});
}

function do_reserve_post (post_id, user_ID) {
	console.log("I'll reserve post.." + post_id);
	var data = {
		post_id: post_id,
		user_ID: user_ID
	}
	jQuery.get('/imageID/wp-json/wp/v2/imageid/user/'+user_ID+'/reserve/'+post_id).done(function(response) {
		console.log(response);
	});
	
	jQuery(function($) {
		$('.reserve_btn').remove();
		$('.reserve').append(" Reserved");
	});
}


function do_rate_post (user_ID, post_id, rating) {
	console.log("I'll rate post.." + post_id);
	var data = {
		post_id: post_id,
		user_ID: user_ID,
		rating: rating
	}
	jQuery.get('/imageID/wp-json/wp/v2/imageid/user/'+user_ID+'/rate/'+post_id+'/'+rating).done(function(response) {
		console.log(response);
	});
}
