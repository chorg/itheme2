<?php
/**
 * Module Name: Portfolio
 * Description: Display portfolio custom post type
 */

///////////////////////////////////////
// Load Post Type
///////////////////////////////////////
add_action( 'wp_loaded', 'themify_builder_portfolio_loaded', 15 );
function themify_builder_portfolio_loaded() {
	global $ThemifyBuilder;
	
	$cpt = array(
		'plural' => __('Portfolios', 'themify'),
		'singular' => __('Portfolio', 'themify'),
		'rewrite' => apply_filters('themify_portfolio_rewrite', 'project')
	);
	
	if ( post_type_exists( 'portfolio' ) ) {
		// check taxonomy register
		if ( ! taxonomy_exists( 'portfolio-category' ) ) 
			themify_builder_portfolio_register_taxonomy( $cpt );
	} else {
		themify_builder_portfolio_register_cpt( $cpt );
		themify_builder_portfolio_register_taxonomy( $cpt );
		add_filter( 'themify_do_metaboxes', 'themify_builder_portfolio_meta_boxes' );
		
		// push to themify builder class
		$ThemifyBuilder->push_post_types( 'portfolio' );
	}
}

///////////////////////////////////////
// Register Post Type
///////////////////////////////////////
function themify_builder_portfolio_register_cpt($cpt){
	global $ThemifyBuilder;

	register_post_type( 'portfolio', array(
		'labels' => array(
			'name' => $cpt['plural'],
			'singular_name' => $cpt['singular'],
			'add_new' => __( 'Add New', 'background' ),
			'add_new_item' => sprintf(__( 'Add New %s', 'background' ), $cpt['singular']),
			'edit_item' => sprintf(__( 'Edit %s', 'background' ), $cpt['singular']),
			'new_item' => sprintf(__( 'New %s', 'background' ), $cpt['singular']),
			'view_item' => sprintf(__( 'View %s', 'background' ), $cpt['singular']),
			'search_items' => sprintf(__( 'Search %s', 'background' ), $cpt['plural']),
			'not_found' => sprintf(__( 'No %s found', 'background' ), $cpt['plural']),
			'not_found_in_trash' => sprintf(__( 'No %s found in Trash', 'background' ), $cpt['plural']),
			'menu_name' => $cpt['plural']
		),
		'supports' => isset($cpt['supports'])? $cpt['supports'] : array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
		//'menu_position' => $position++,
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'rewrite' => array( 'slug' => isset($cpt['rewrite'])? $cpt['rewrite']: strtolower($cpt['singular']) ),
		'query_var' => true,
		'can_export' => true,
		'capability_type' => 'post'
	));
}

///////////////////////////////////////
// Register Taxonomy
///////////////////////////////////////
function themify_builder_portfolio_register_taxonomy($cpt) {
	global $ThemifyBuilder;

	register_taxonomy( 'portfolio-category', array('portfolio'), array(
		'labels' => array(
			'name' => sprintf(__( '%s Categories', 'themify' ), $cpt['singular']),
			'singular_name' => sprintf(__( '%s Category', 'themify' ), $cpt['singular']),
			'search_items' => sprintf(__( 'Search %s Categories', 'themify' ), $cpt['singular']),
			'popular_items' => sprintf(__( 'Popular %s Categories', 'themify' ), $cpt['singular']),
			'all_items' => sprintf(__( 'All Categories', 'themify' ), $cpt['singular']),
			'parent_item' => sprintf(__( 'Parent %s Category', 'themify' ), $cpt['singular']),
			'parent_item_colon' => sprintf(__( 'Parent %s Category:', 'themify' ), $cpt['singular']),
			'edit_item' => sprintf(__( 'Edit %s Category', 'themify' ), $cpt['singular']),
			'update_item' => sprintf(__( 'Update %s Category', 'themify' ), $cpt['singular']),
			'add_new_item' => sprintf(__( 'Add New %s Category', 'themify' ), $cpt['singular']),
			'new_item_name' => sprintf(__( 'New %s Category', 'themify' ), $cpt['singular']),
			'separate_items_with_commas' => sprintf(__( 'Separate %s Category with commas', 'themify' ), $cpt['singular']),
			'add_or_remove_items' => sprintf(__( 'Add or remove %s Category', 'themify' ), $cpt['singular']),
			'choose_from_most_used' => sprintf(__( 'Choose from the most used %s Category', 'themify' ), $cpt['singular']),
			'menu_name' => sprintf(__( '%s Category', 'themify' ), $cpt['singular']),
		),
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => true,
		'query_var' => true
	));

	add_filter( 'manage_edit-portfolio-category_columns', array($ThemifyBuilder, 'taxonomy_header'), 10, 2 );
	add_filter( 'manage_portfolio-category_custom_column', array($ThemifyBuilder, 'taxonomy_column_id'), 10, 3 );

	// admin column custom taxonomy
	add_filter( 'manage_taxonomies_for_portfolio_columns', 'themify_builder_portfolio_category_columns' );
	function themify_builder_portfolio_category_columns( $taxonomies ) {
		$taxonomies[] = 'portfolio-category';
		return $taxonomies;
	}
}

///////////////////////////////////////
// Register Metaboxes
///////////////////////////////////////
function themify_builder_portfolio_meta_boxes( $meta_boxes ) {
	global $ThemifyBuilder;

	/** Portfolio Meta Box Options */
	$portfolio_meta_box = array(
		// Feature Image
		$ThemifyBuilder->post_image,
		// Featured Image Size
		$ThemifyBuilder->featured_image_size,
		// Image Width
		$ThemifyBuilder->image_width,
		// Image Height
		$ThemifyBuilder->image_height,
		// Hide Title
		array(
			"name" 		=> "hide_post_title",
			"title"		=> __('Hide Post Title', 'themify'),
			"description"	=> "",
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)
		),
		// Unlink Post Title
		array(
			"name" 		=> "unlink_post_title",
			"title" 		=> __('Unlink Post Title', 'themify'), 	
			"description" => __('Unlink post title (it will display the post title without link)', 'themify'), 				
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)
		),
		// Hide Post Date
		array(
			"name" 		=> "hide_post_date",
			"title"		=> __('Hide Post Date', 'themify'),
			"description"	=> "",
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)
		),
		// Hide Post Meta
		array(
			"name" 		=> "hide_post_meta",
			"title"		=> __('Hide Post Meta', 'themify'),
			"description"	=> "",
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)
		),
		// Hide Post Image
		array(
			"name" 		=> "hide_post_image",
			"title" 		=> __('Hide Featured Image', 'themify'), 	
			"description" => "", 				
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)			
		),
		// Unlink Post Image
		array(
			"name" 		=> "unlink_post_image",
			"title" 		=> __('Unlink Featured Image', 'themify'), 	
			"description" => __('Display the Featured Image without link)', 'themify'), 				
			"type" 		=> "dropdown",			
			"meta"		=> array(
				array("value" => "default", "name" => "", "selected" => true),
				array("value" => "yes", 'name' => __('Yes', 'themify')),
				array("value" => "no",	'name' => __('No', 'themify'))
			)
		),
		// External Link
		$ThemifyBuilder->external_link,
		// Lightbox Link
		$ThemifyBuilder->lightbox_link
	);

	return array_merge($meta_boxes, array(
		array(
			'name'	=> __('Portfolio Options', 'themify'),
			'id' 		=> 'portfolio-options',
			'options' => $portfolio_meta_box,
			'pages'	=> 'portfolio'
		)
	));
}

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$reg_image_sizes = get_intermediate_image_sizes();
$image_sizes = array();
foreach ( $reg_image_sizes as $v ) {
	$image_sizes[ $v ] = ucfirst( $v );
}
$this->modules['portfolio'] = apply_filters( 'themify_builder_module_portfolio', array(
	'name' => __('Portfolio', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_portfolio',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'layout_portfolio',
			'type' => 'layout',
			'label' => __('Portfolio Layout', 'themify'),
			'options' => array(
				array('img' => 'grid4.png', 'value' => 'grid4', 'label' => __('Grid 4', 'themify')),
				array('img' => 'grid3.png', 'value' => 'grid3', 'label' => __('Grid 3', 'themify')),
				array('img' => 'grid2.png', 'value' => 'grid2', 'label' => __('Grid 2', 'themify')),
				array('img' => 'fullwidth.png', 'value' => 'fullwidth', 'label' => __('fullwidth', 'themify'))
			)
		),
		array(
			'id' => 'category_portfolio',
			'type' => 'query_category',
			'label' => __('Category', 'themify'),
			'options' => array(
				'taxonomy' => 'portfolio-category'
			),
			'help' => sprintf(__('Add more <a href="%s" target="_blank">portfolio posts</a>', 'themify'), admin_url('post-new.php?post_type=portfolio'))
		),
		array(
			'id' => 'post_per_page_portfolio',
			'type' => 'text',
			'label' => __('Limit', 'themify'),
			'class' => 'xsmall',
			'help' => __('number of posts to show', 'themify')
		),
		array(
			'id' => 'offset_portfolio',
			'type' => 'text',
			'label' => __('Offset', 'themify'),
			'class' => 'xsmall',
			'help' => __('number of post to displace or pass over', 'themify')
		),
		array(
			'id' => 'order_portfolio',
			'type' => 'select',
			'label' => __('Order', 'themify'),
			'help' => __('Descending = show newer posts first', 'themify'),
			'options' => array(
				'desc' => __('Descending', 'themify'),
				'asc' => __('Ascending', 'themify')
			)
		),
		array(
			'id' => 'orderby_portfolio',
			'type' => 'select',
			'label' => __('Order By', 'themify'),
			'options' => array(
				'date' => __('Date', 'themify'),
				'id' => __('Id', 'themify'),
				'author' => __('Author', 'themify'),
				'title' => __('Title', 'themify'),
				'name' => __('Name', 'themify'),
				'modified' => __('Modified', 'themify'),
				'rand' => __('Rand', 'themify'),
				'comment_count' => __('Comment Count', 'themify')
			)
		),
		array(
			'id' => 'display_portfolio',
			'type' => 'select',
			'label' => __('Display', 'themify'),
			'options' => array(
				'content' => __('Content', 'themify'),
				'excerpt' => __('Excerpt', 'themify'),
				'none' => __('None', 'themify')
			)
		),
		array(
			'id' => 'hide_feat_img_portfolio',
			'type' => 'select',
			'label' => __('Hide Featured Image', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'image_size_portfolio',
			'type' => 'select',
			'label' => $this->is_img_php_disabled() ? __('Image Size', 'themify') : false,
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'hide' => $this->is_img_php_disabled() ? false : true,
			'options' => $image_sizes
		),
		array(
			'id' => 'img_width_portfolio',
			'type' => 'text',
			'label' => __('Image Width', 'themify'),
			'class' => 'xsmall'
		),
		array(
			'id' => 'img_height_portfolio',
			'type' => 'text',
			'label' => __('Image Height', 'themify'),
			'class' => 'xsmall'
		),
		array(
			'id' => 'unlink_feat_img_portfolio',
			'type' => 'select',
			'label' => __('Unlink Featured Image', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'hide_post_title_portfolio',
			'type' => 'select',
			'label' => __('Hide Post Title', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'unlink_post_title_portfolio',
			'type' => 'select',
			'label' => __('Unlink Post Title', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'hide_post_date_portfolio',
			'type' => 'select',
			'label' => __('Hide Post Date', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'hide_post_meta_portfolio',
			'type' => 'select',
			'label' => __('Hide Post Meta', 'themify'),
			'empty' => array(
				'val' => '',
				'label' => ''
			),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'hide_page_nav_portfolio',
			'type' => 'select',
			'label' => __('Hide Page Navigation', 'themify'),
			'options' => array(
				'yes' => __('Yes', 'themify'),
				'no' => __('No', 'themify')
			)
		),
		array(
			'id' => 'css_portfolio',
			'type' => 'text',
			'label' => __('Additional CSS Class', 'themify'),
			'class' => 'large',
			'help' => __('Add additional CSS class(es) for custom styling', 'themify'),
			'separated' => 'top',
			'break' => true
		)
	)
) );

?>