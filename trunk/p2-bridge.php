<?php

$p2_custom_post_type = 'aside';
$p2_custom_post_type_template = '/' . $p2_custom_post_type . '.php';
//$p2_custom_post_type_template = '/p2/single.php';
$p2_custom_post_type_name = 'Asides';
$p2_custom_post_type_singular_name = 'Aside';
$p2_custom_post_type_page_slug = 'asides';

add_action( 'init', 'create_post_type' );
add_action( 'init', 'aside_add_default_boxes' );
add_action( 'hybrid_head', 'p2_enqueue_css', 100 );
add_action( 'wp_head', 'p2_remove_actions' );
add_action( 'wp_head', 'p2_add_actions' );
add_filter( 'comments_template', 'p2_comments_template' );
add_action( 'hybrid_head', 'p2_set_variables', 1);
add_filter( 'pre_get_posts', 'p2_get_posts' );


$is_page_template_page = 0;
$is_template_for_custom_post_type = 0;
$is_page_or_template_for_custom_post_type = 0;

function p2_set_variables() {
	global $is_page_template_page;
	global $is_template_for_custom_post_type;
	global $is_page_or_template_for_custom_post_type;
	global $p2_custom_post_type_template;
	global $p2_custom_post_type_page_slug;
	if ( is_page("$p2_custom_post_type_page_slug") ) 
		$is_page_template_page = 1;

	$custom_post_type_page_template = get_page_template();
	if ( file_exists( STYLESHEETPATH . $p2_custom_post_type_template ) )
		$derived_custom_post_type_page_template = STYLESHEETPATH . $p2_custom_post_type_template;
    else if ( file_exists( TEMPLATEPATH . $p2_custom_post_type_template ) )
		$derived_custom_post_type_page_template = TEMPLATEPATH . $p2_custom_post_type_template;

	//$derived_custom_post_type_page_template = BIRDBRAIN_DIR . '/aside.php';
	
	if ( ($custom_post_type_page_template == $derived_custom_post_type_page_template) && is_single() ) 
		$is_template_for_custom_post_type = 1;
	
	if ( $is_page_template_page || is_p2_custom_post_type() ) 
		$is_page_or_template_for_custom_post_type = 1;
	
}

function create_post_type() {
	global $p2_custom_post_type;
	global $p2_custom_post_type_name;
	global $p2_custom_post_type_singular_name;
	register_post_type( "$p2_custom_post_type",
		array(
			'labels' => array(
			'name' => __( "$p2_custom_post_type_name" ),
			'singular_name' => __( "$p2_custom_post_type_singular_name" )
			),
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'trackbacks', 'comments' ),			
			'capability_type' => 'post',
		)
	);
}

function is_p2_custom_post_type() {
	global $p2_custom_post_type;
	$post_type = get_query_var('post_type');
	// short had for if / else;
	return $post_type == $p2_custom_post_type ? true : false;
}


function aside_add_default_boxes() {
    register_taxonomy_for_object_type('category', 'aside');
    register_taxonomy_for_object_type('post_tag', 'aside');
}

function p2_enqueue_css() {
	global $wp_query;
	global $is_page_or_template_for_custom_post_type;
	if ($is_page_or_template_for_custom_post_type) {
		wp_enqueue_style('aside', BIRDBRAIN_DIR_URL . '/p2/style.css', false, '0.1', 'screen');
	}
}

function p2_remove_actions() {
	global $is_page_template_page;
	global $is_template_for_custom_post_type;
	global $is_page_or_template_for_custom_post_type;
	if ($is_page_template_page) {
		remove_action('hybrid_before_entry', 'hybrid_entry_title');
	}
//	if ($is_template_for_custom_post_type) {
	if (is_p2_custom_post_type()) {
		remove_action('hybrid_before_entry', 'hybrid_entry_title');
		remove_action('hybrid_before_entry', 'social_bookmarks_toparea');
		remove_all_filters('the_content', 90);
		remove_all_filters('the_excerpt', 90);
		remove_all_filters('comment_text', 90);
	}
}

function p2_remove_filters() {
}

function p2_add_actions() {
	global $is_page_or_template_for_custom_post_type;
	if ($is_page_or_template_for_custom_post_type) {
		add_action('wp_footer','p2_add_to_footer');
	}
}

function p2_comments_template ($template) {
	global $is_page_or_template_for_custom_post_type;
	$templates = array();
	if ($is_page_or_template_for_custom_post_type) {
		$templates[] = "p2/comments.php";
		return locate_template( $templates );
	} 
	return locate_template( $templates );
}

function p2_get_posts( $query ) {
	global $p2_custom_post_type;
	if ( (is_tag() || is_category() || is_author()) && false == $query->query_vars['suppress_filters'] ) {
		$query->set( 'post_type', array( 'post', $p2_custom_post_type ) );
	}
	return $query;
}

function p2_add_to_footer() {
	global $is_page_or_template_for_custom_post_type;
	if ($is_page_or_template_for_custom_post_type) {
?>
<div id="notify"></div>

<div id="help">
    <dl class="directions">
        <dt>c</dt><dd><?php _e('compose new post', 'p2'); ?></dd>
        <dt>j</dt><dd><?php _e('next post/next comment', 'p2'); ?></dd>
        <dt>k</dt> <dd><?php _e('previous post/previous comment', 'p2'); ?></dd>
        <dt>r</dt> <dd><?php _e('reply', 'p2'); ?></dd>
        <dt>e</dt> <dd><?php _e('edit', 'p2'); ?></dd>
        <dt>o</dt> <dd><?php _e('show/hide comments', 'p2'); ?></dd>
        <dt>t</dt> <dd><?php _e('go to top', 'p2'); ?></dd>
        <dt>l</dt> <dd><?php _e('go to login', 'p2'); ?></dd>
        <dt>h</dt> <dd><?php _e('show/hide help', 'p2'); ?></dd>
        <dt>esc</dt> <dd><?php _e('cancel', 'p2'); ?></dd>
    </dl>
</div>
<?php
	}
}

/*function p2_template_redirect()
{
	global $wp;
	global $p2_custom_post_type;
	global $p2_custom_post_type_template;
	$derived_custom_post_type_page_template = null;
	if ($wp->query_vars["post_type"] == $p2_custom_post_type) {
		if ( file_exists( STYLESHEETPATH . $p2_custom_post_type_template ) )
			$derived_custom_post_type_page_template = STYLESHEETPATH . $p2_custom_post_type_template;
		else if ( file_exists( TEMPLATEPATH . $p2_custom_post_type_template ) )
			$derived_custom_post_type_page_template = TEMPLATEPATH . $p2_custom_post_type_template;
		debug_wp("template_redirect");
		debug_wp($derived_custom_post_type_page_template);
		include($derived_custom_post_type_page_template);
		exit();
	}
}

function set_p2_single_template ($template) {
	if ( is_p2_custom_post_type() ) {
		debug_wp("setting template");
		$template = get_p2_single_template();
		return $template;
	} 
	return $template;
}

function get_p2_single_template () {
	global $p2_custom_post_type_template;
	$templates = array($p2_custom_post_type_template);	
	debug_wp("locating templates");
	debug_wp(locate_template($templates));
	return locate_template( $templates );
}*/
require_once( BIRDBRAIN_DIR . '/p2/functions.php' );

?>
