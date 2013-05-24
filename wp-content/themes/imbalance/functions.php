<?php

define("PATH_TO_INC",get_bloginfo('wpurl').'/wp-content/themes/_inc');

$authors;

function authors() {
	global $wpdb,$authors;
	$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");
	}

add_action('init', 'authors');

// ===========
// = Sidebar =
// ===========
if ( function_exists('register_sidebar') )
    register_sidebar();

// ====================================
// = WordPress 2.9+ Thumbnail Support =
// ====================================
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 305, 9999 ); // 305 pixels wide by 380 pixels tall, set last parameter to true for hard crop mode
add_image_size( 'background', 305, 9999 ); // Set thumbnail size
add_image_size( 'portrait', 305, 180 ); // Set thumbnail size


// ==================================
// = WP 3.0 Custom Background Setup =
// ==================================
if ( function_exists( 'add_custom_background' ) )
    { add_custom_background(); }


// =========================
// = Change excerpt lenght =
// =========================
add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
return get_option('imbalance_excln'); }

// =================================
// = Change default excerpt symbol =
// =================================
function imbalance_excerpt($text) { return str_replace('[...]', '...', $text); } add_filter('the_excerpt', 'imbalance_excerpt');


// =================================
// = Add comment callback function =
// =================================
function imbalance_comments($comment, $args, $depth) {
	$default = urlencode(get_bloginfo('template_directory') . '/images/default-avatar.png');
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	 <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
		<?php echo get_avatar($comment,$size='55', $default ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">wrote:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
 
      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
 
      <?php comment_text() ?>

	<div class="reply">
	         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
     </div>
<?php
}


// ==========================
// = Include Twitter widget =
// ==========================
include TEMPLATEPATH . '/js/twitter/twitter.php';



// ====================
// = Add options page =
// ====================
function themeoptions_admin_menu()
{
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'themeoptions_page');
}

function themeoptions_page()
{
	if ( $_POST['update_themeoptions'] == 'true' ) { themeoptions_update(); }  //check options update
	// here's the main function that will generate our options page
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2>IMBALANCE Theme Options</h2>

		<form method="POST" action="">
			<input type="hidden" name="update_themeoptions" value="true" />

			<h3>Your social links</h3>
			
			
<table width="90%" border="0">
  <tr>
    <td valign="top" width="50%"><p><label for="fbkurl"><strong>Facebook URL</strong></label><br /><input type="text" name="fbkurl" id="fbkurl" size="32" value="<?php echo get_option('imbalance_fbkurl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://www.facebook.com/wpshower</em></small></p></td>
    <td valign="top"width="50%"><p><label for="twturl"><strong>Twitter URL</strong></label><br /><input type="text" name="twturl" id="twturl" size="32" value="<?php echo get_option('imbalance_twturl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://twitter.com/wpshower</em></small></p>
</td>
  </tr>
</table>

			<h3>Custom logo</h3>
			
			
<table width="90%" border="0">
  <tr>
    <td valign="top" width="50%"><p><label for="custom_logo"><strong>URL to your custom logo</strong></label><br /><input type="text" name="custom_logo" id="custom_logo" size="32" value="<?php echo get_option('imbalance_custom_logo'); ?>"/></p><p><small><strong>Usage:</strong><br /><em><a href="<?php bloginfo("url"); ?>/wp-admin/media-new.php">Upload your logo</a> (461 x 70px) using WordPress Media Library and insert its URL here</em></small></p></td>
    <td valign="top"width="50%"><p>
    	        <?php         		
	        	ob_start();
				ob_implicit_flush(0);
				echo get_option('imbalance_custom_logo'); 
				$my_logo = ob_get_contents();
				ob_end_clean();
        		if (
		        $my_logo == ''
        		): ?>
        		<a href="<?php bloginfo("url"); ?>/">
				<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a>
        		<?php else: ?>
        		<a href="<?php bloginfo("url"); ?>/"><img src="<?php echo get_option('imbalance_custom_logo'); ?>"></a>       		
        		<?php endif ?>
    </p>
</td>
  </tr>
</table>

			<h3>Advanced options</h3>
			
			
<table width="90%" border="0">
<tr>
    <td valign="top" width="50%"><p><label for="excln"><strong>Excerpt lenght (in words)</strong></label><br /><input type="text" name="excln" id="excln" size="32" value="<?php echo get_option('imbalance_excln'); ?>"/><p><small><strong>Dafault value:</strong><em>35<br />- clean the field to disable excerpt completely<br />- automatically disabled if advanced-excerpt plugin is installed</em></small></p>
    </td>
	<p><input type="checkbox" name="sidebar_off" id="sidebar_off" <?php echo get_option('imbalance_sidebar_off'); ?> />
	<label for="sidebar_off"><strong>Disable Featured Posts on top of Sidebar?</strong><br /></label></p>
	<p><small><em>Select the checkbox to disable featured posts display on top of your sidebar</em></small></p>	
	</td>

  </tr>
</table>
			
			
			
			<p><input type="submit" name="search" value="Update Options" class="button button-primary" /></p>
		</form>

	</div>
	<?php
}

add_action('admin_menu', 'themeoptions_admin_menu');



// Update options function

function themeoptions_update()
{
	// this is where validation would go
	update_option('imbalance_fbkurl', 	$_POST['fbkurl']);
	update_option('imbalance_twturl', 	$_POST['twturl']);
	update_option('imbalance_excln', 	$_POST['excln']);
	update_option('imbalance_custom_logo', 	$_POST['custom_logo']);
	if ($_POST['gallery_off']=='on') { $display = 'checked'; } else { $display = ''; }
	update_option('imbalance_gallery_off', 	$display);
	if ($_POST['sidebar_off']=='on') { $display = 'checked'; } else { $display = ''; }
	update_option('imbalance_sidebar_off', 	$display);

}

function assign_status($status) {
	switch($status){
		case "New":
		$source = "new.png" ;
		break;
		case "Updated":
		$source = "updated.png" ;
		break;
		case "In Dev":
		$source = "indev.png" ;
		break;
		case "Prototype":
		$source = "prototype.png" ;
		break;
		case "Released":
		$source = "released.png" ;
		break;
		default:
		$source = "angolo.png" ;
		break;
	}
	
	return $source;
}

function the_contributors(){
	echo get_contributors();
}

function get_contributors() {
global $authors;
	$author_list = "";
	foreach( $authors as $author) {
	$author_list .= '<li class="team_member"><div class="member"><a href="'.get_the_author_meta("user_url", $author->ID).'">'.get_avatar($author->ID).'</a><div><a href="'.get_the_author_meta("user_url", $author->ID).'">'.get_the_author_meta("first_name", $author->ID).' '.get_the_author_meta("last_name", $author->ID).'</a><p>'.get_the_author_meta("description", $author->ID).'</p></div></div><div class="member-over"><a class="link_block" href="'.get_the_author_meta("user_url", $author->ID).'"></a><p>Personal<br />Info</p></div></li>';
	}
	return $author_list;
	}

function excludePages($query) {
 
if ($query->is_search) {
 
	$query->set('post_type', 'post');
 
}
	return $query;
 
}
 
add_filter('pre_get_posts','excludePages');

add_action( 'init', 'codex_custom_init' );
function codex_custom_init() {
  $labels = array(
    'name' => _x('Projects', 'post type general name'),
    'singular_name' => _x('Project', 'post type singular name'),
    'add_new' => _x('Add New', 'project'),
    'add_new_item' => __('Add New Project'),
    'edit_item' => __('Edit Project'),
    'new_item' => __('New Project'),
    'all_items' => __('All Projects'),
    'view_item' => __('View Project'),
    'search_items' => __('Search Projects'),
    'not_found' =>  __('No projects found'),
    'not_found_in_trash' => __('No projects found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Projects'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'page',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
  ); 
  register_post_type('project',$args);
  
  $labels = array(
    'name' => _x('Designers', 'post type general name'),
    'singular_name' => _x('Designer', 'post type singular name'),
    'add_new' => _x('Add New', 'designer'),
    'add_new_item' => __('Add New Designer'),
    'edit_item' => __('Edit Designer'),
    'new_item' => __('New Designer'),
    'all_items' => __('All Designers'),
    'view_item' => __('View Designer'),
    'search_items' => __('Search Designers'),
    'not_found' =>  __('No designers found'),
    'not_found_in_trash' => __('No designers found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Designers'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'page',
    'has_archive' => true, 
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'thumbnail' )
  ); 
  register_post_type('designer',$args);
}

//Making jQuery Google API
function modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false);
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');


function the_title_trim($title)
{
  $pattern[0] = '/Protected:/';
  $pattern[1] = '/Private:/';
  $replacement[0] = ''; // Enter some text to put in place of Protected:
  $replacement[1] = ''; // Enter some text to put in place of Private:

  return preg_replace($pattern, $replacement, $title);
}
add_filter('the_title', 'the_title_trim');


function enque_js() {
    wp_enqueue_script('jquery');
	wp_enqueue_script('team', PATH_TO_INC . '/js/team.min.js' , 'jquery', false);
	wp_enqueue_script('random', PATH_TO_INC . '/js/jquery.random.min.js' , 'jquery', false);
	wp_enqueue_script('slideto', PATH_TO_INC . '/js/jquery.slideto.min.js' , 'jquery', false);
	wp_enqueue_script('columnizer', PATH_TO_INC . '/js/columnizer.min.js' , 'jquery', false);
	wp_enqueue_script('columnize', PATH_TO_INC . '/js/columnize.min.js' , 'jquery', false);
	wp_enqueue_script('animatedcollapse', PATH_TO_INC . '/js/animatedcollapse.min.js' , 'jquery', false);
	wp_enqueue_script('collapse', PATH_TO_INC . '/js/collapse.min.js' , 'jquery', false);
	wp_enqueue_script('bugherd', PATH_TO_INC . '/js/bugherd.js' , 'jquery', true);
			
	if( is_front_page() || is_search() ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('grid', PATH_TO_INC . '/js/grid.min.js', 'jquery', false);
	}       
}    
 
//add_action('wp_enqueue_scripts', 'enque_js'); // For use on the Front end (ie. Theme)

function check_socials ($social) {
	switch ($social) {
		case "behance" :
			$path = PATH_TO_INC.'/social_icon/behance.png';
		break;
		case "blogger" :
			$path = PATH_TO_INC.'/social_icon/blogger.png';
		break;
		case "delicious" :
			$path = PATH_TO_INC.'/social_icon/delicious.png';
		break;
		case "deviantart" :
			$path = PATH_TO_INC.'/social_icon/deviantart.png';
		break;
		case "digg" :
			$path = PATH_TO_INC.'/social_icon/digg.png';
		break;
		case "dropplr" :
			$path = PATH_TO_INC.'/social_icon/dropplr.png';
		break;
		case "dribbble" :
			$path = PATH_TO_INC.'/social_icon/dribbble.png';
		break;
		case "evernote" :
			$path = PATH_TO_INC.'/social_icon/evernote.png';
		break;
		case "facebook" :
			$path = PATH_TO_INC.'/social_icon/facebook.png';
		break;
		case "flickr" :
			$path = PATH_TO_INC.'/social_icon/flickr.png';
		break;
		case "forrst" :
			$path = PATH_TO_INC.'/social_icon/forrst.png';
		break;
		case "foursquare" :
			$path = PATH_TO_INC.'/social_icon/foursquare.png';
		break;
		case "lastfm" :
			$path = PATH_TO_INC.'/social_icon/lastfm.png';
		break;
		case "linkedin" :
			$path = PATH_TO_INC.'/social_icon/linkedin.png';
		break;
		case "posterous" :
			$path = PATH_TO_INC.'/social_icon/posterous.png';
		break;
		case "twitter" :
			$path = PATH_TO_INC.'/social_icon/twitter.png';
		break;
		case "vimeo" :
			$path = PATH_TO_INC.'/social_icon/vimeo.png';
		break;
		case "youtube" :
			$path = PATH_TO_INC.'/social_icon/youtube.png';
		break;
	}
	return $path;
}

?>