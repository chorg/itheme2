<?php
/**
 * Template Testimonial
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$BuilderTestimonial = new Builder_Testimonial;

$fields_default = array(
	'mod_title_testimonial' => '',
	'layout_testimonial' => '',
	'category_testimonial' => '',
	'post_per_page_testimonial' => '',
	'offset_testimonial' => '',
	'order_testimonial' => 'desc',
	'orderby_testimonial' => 'date',
	'display_testimonial' => 'content',
	'hide_feat_img_testimonial' => '',
	'image_size_testimonial' => '',
	'img_width_testimonial' => '',
	'img_height_testimonial' => '',
	'unlink_feat_img_testimonial' => 'no',
	'hide_post_title_testimonial' => 'no',
	'unlink_post_title_testimonial' => 'no',
	'hide_post_date_testimonial' => 'no',
	'hide_post_meta_testimonial' => 'no',
	'hide_page_nav_testimonial' => 'yes',
	'css_testimonial' => ''
);

if ( isset( $mod_settings['category_testimonial'] ) )	
	$mod_settings['category_testimonial'] = $this->get_param_value( $mod_settings['category_testimonial'] );

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $css_testimonial . ' ' . $layout_testimonial . ' module-' . $mod_name;
?>
<!-- module testimonial -->
<div id="<?php echo $module_ID; ?>" class="loops-wrapper module clearfix <?php echo $class; ?>">
	<?php if ( $mod_title_testimonial != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_testimonial; ?></h3>
	<?php endif; ?>
	
	<?php
	do_action( 'themify_builder_before_template_content_render' );
	
	// The Query
	global $paged;
	$order = $order_testimonial;
	$orderby = $orderby_testimonial;
	$paged = $this->get_paged_query();
	$limit = $post_per_page_testimonial;
	$terms = $category_testimonial;
	$temp_terms = explode(',', $terms);
	$new_terms = array();
	$is_string = false;
	foreach ( $temp_terms as $t ) {
		if ( ! is_numeric( $t ) )
			$is_string = true;
		if ( '' != $t ) {
			array_push( $new_terms, trim( $t ) );
		}
	}
	$tax_field = ( $is_string ) ? 'slug' : 'id';
	
	$args = array(
		'post_type' => 'testimonial',
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'order' => $order,
		'orderby' => $orderby,
		'suppress_filters' => false,
		'paged' => $paged
	);

	if ( count($new_terms) > 0 && ! in_array('0', $new_terms) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-category',
				'field' => $tax_field,
				'terms' => $new_terms
			)
		);
	}

	// add offset posts
	if ( $offset_testimonial != '' ) {
		if ( empty( $limit ) ) 
			$limit = get_option('posts_per_page');

		$args['offset'] = ( ( $paged - 1 ) * $limit ) + $offset_testimonial;
	}
	
	$the_query = new WP_Query(); 
	$posts = $the_query->query( $args );

	// check if theme loop template exists
	$is_theme_template = $this->is_loop_template_exist('loop-testimonial.php', 'includes');
	
	// use theme template loop
	if ( $is_theme_template ) {
		// save a copy
		global $themify;
		$themify_save = clone $themify;

		// override $themify object
		$themify->hide_image = $hide_feat_img_testimonial;
		$themify->unlink_image = $unlink_feat_img_testimonial;
		$themify->hide_title = $hide_post_title_testimonial;
		$themify->width = $img_width_testimonial;
		$themify->height = $img_height_testimonial;
		$themify->image_setting = 'ignore=true&';
		if ( $this->is_img_php_disabled() ) 
			$themify->image_setting .= $image_size_testimonial != '' ? 'image_size=' . $image_size_testimonial . '&' : '';
		$themify->unlink_title = $unlink_post_title_testimonial;
		$themify->display_content = $display_testimonial;
		$themify->hide_date = $hide_post_date_testimonial;
		$themify->hide_meta = $hide_post_meta_testimonial;
		$themify->post_layout = $layout_testimonial;

		// hooks action
		do_action_ref_array('themify_builder_override_loop_themify_vars', array( $themify, $mod_name ) );

		$out = '';
		if ($posts) {
			$out .= themify_get_shortcode_template($posts, 'includes/loop', 'testimonial');
		}
		
		// revert to original $themify state
		$themify = clone $themify_save;
		echo $out;
	} else {
		// use builder template
		global $post;
		foreach($posts as $post): setup_postdata( $post ); ?>

		<?php themify_post_before(); // hook ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class("post testimonial-post clearfix"); ?>>
			
			<?php themify_post_start(); // hook ?>
			
			<?php
			if ( $hide_feat_img_testimonial != 'yes' ) {
				$width = $img_width_testimonial;
				$height = $img_height_testimonial;
				$param_image = 'w='.$width .'&h='.$height.'&ignore=true';
				if ( $this->is_img_php_disabled() ) 
					$param_image .= $image_size_testimonial != '' ? '&image_size=' . $image_size_testimonial : '';

				if ( $post_image = themify_get_image($param_image) ) {
					themify_before_post_image(); // Hook ?>
					<figure class="post-image">
						<?php echo $post_image; ?>
					</figure>
					<?php themify_after_post_image(); // Hook
				} 
			}
			?>

			<div class="post-content">
			
				<?php if ( $hide_post_title_testimonial != 'yes' ): ?>
					<?php themify_before_post_title(); // Hook ?>
					<h1 class="post-title"><?php the_title(); ?></h1>
					<?php themify_after_post_title(); // Hook ?> 
				<?php endif; //post title ?>    
				
				<?php
				// fix the issue more link doesn't output
				global $more;
				$more = 0;
				?>

				<?php if ( $display_testimonial == 'excerpt' ): ?>
			
					<?php the_excerpt(); ?>
			
				<?php elseif ( $display_testimonial == 'none' ): ?>
			
				<?php else: ?>

					<?php the_content(themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify')); ?>
				
				<?php endif; //display content ?>
				
				<?php edit_post_link(__('Edit', 'themify'), '[', ']'); ?>

				<p class="testimonial-author">
					<?php
						echo $BuilderTestimonial->author_name($post, 'yes');
					?>
				</p>
				
			</div>
			<!-- /.post-content -->
			<?php themify_post_end(); // hook ?>
			
		</article>
		<?php themify_post_after(); // hook ?>

		<?php endforeach; wp_reset_postdata(); ?>
	<?php
	} // endif $is_theme_template
	
	if ( $hide_page_nav_testimonial != 'yes' ) {
		echo $this->get_pagenav('', '', $the_query);
	}
	?>

	<?php do_action( 'themify_builder_after_template_content_render' ); ?>
</div>
<!-- /module testimonial -->