<?php
/**
 * Template Slider Slider
 * 
 * Access original fields: $settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_slider' => '',
	'layout_display_slider' => '',
	'slider_category_slider' => '',
	'posts_per_page_slider' => '',
	'offset_slider' => '',
	'display_slider' => 'content',
	'hide_post_title_slider' => 'no',
	'unlink_post_title_slider' => 'no',
	'hide_feat_img_slider' => '',
	'unlink_feat_img_slider' => '',
	'layout_slider' => '',
	'image_size_slider' => '',
	'img_w_slider' => '',
	'img_h_slider' => '',
	'visible_opt_slider' => '',
	'auto_scroll_opt_slider' => 0,
	'scroll_opt_slider' => '',
	'speed_opt_slider' => '',
	'effect_slider' => 'scroll',
	'wrap_slider' => 'yes',
	'show_nav_slider' => 'yes',
	'show_arrow_slider' => 'yes',
	'left_margin_slider' => '',
	'right_margin_slider' => '',
	'css_slider' => ''
);

if ( isset( $settings['slider_category_slider'] ) )	
	$settings['slider_category_slider'] = $this->get_param_value( $settings['slider_category_slider'] );

if ( isset( $settings['auto_scroll_opt_slider'] ) )	
	$settings['auto_scroll_opt_slider'] = $settings['auto_scroll_opt_slider'];

$fields_args = wp_parse_args( $settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $css_slider . ' ' . $layout_slider . ' module-' . $mod_name;
$visible = $visible_opt_slider;
$scroll = $scroll_opt_slider;
$auto_scroll = $auto_scroll_opt_slider;
$arrow = $show_arrow_slider;
$pagination = $show_nav_slider;
$left_margin = ! empty( $left_margin_slider ) ? $left_margin_slider .'px' : '';
$right_margin = ! empty( $right_margin_slider ) ? $right_margin_slider .'px' : '';
$wrapper = $wrap_slider;
$effect = $effect_slider;

switch ( $speed_opt_slider ) {
	case 'slow':
		$speed = 4;
	break;
	
	case 'fast':
		$speed = '.5';
	break;

	default:
	 $speed = 1;
	break;
}
?>
<!-- module slider -->
<div id="<?php echo $module_ID; ?>" class="module themify_builder_slider_wrap <?php echo $class; ?> clearfix">

	<?php if ( $mod_title_slider != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_slider; ?></h3>
	<?php endif; ?>
	
	<ul class="themify_builder_slider" 
		data-id="<?php echo $module_ID; ?>" 
		data-visible="<?php echo $visible; ?>" 
		data-scroll="<?php echo $scroll; ?>" 
		data-auto-scroll="<?php echo $auto_scroll; ?>"
		data-speed="<?php echo $speed; ?>"
		data-wrapper="<?php echo $wrapper; ?>"
		data-arrow="<?php echo $arrow; ?>"
		data-pagination="<?php echo $pagination; ?>" 
		data-effect="<?php echo $effect; ?>" >
		
		<?php
		do_action( 'themify_builder_before_template_content_render' );

		$terms = $slider_category_slider;
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
		
		// The Query
		$args = array(
			'post_type' => 'slider',
			'post_status' => 'publish',
			'order' => 'DESC',
			'orderby' => 'date',
			'suppress_filters' => false
		);

		if ( $posts_per_page_slider != '' ) 
			$args['posts_per_page'] = $posts_per_page_slider;

		// tax query
		if ( count( $new_terms ) > 0 && ! in_array( '0', $new_terms ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'slider-category',
					'field' => $tax_field,
					'terms' => $new_terms
				)
			);
		}

		// add offset posts
		if ( $offset_slider != '' ) 
			$args['offset'] = $offset_slider;

		$args = apply_filters( 'themify_builder_slider_query_args', $args );
		$the_query = new WP_Query( $args );
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
		?>

		<li style="<?php echo !empty($left_margin) ? 'margin-left:'.$left_margin.';' : ''; ?> <?php echo !empty($right_margin) ? 'margin-right:'.$right_margin.';' : ''; ?>">
			<?php
				$width = $img_w_slider;
				$height = $img_h_slider;
				$unlink_feat = $unlink_feat_img_slider == 'yes' ? true : false;
				$param_image = 'w='.$width .'&h='.$height.'&ignore=true';
				if ( $this->is_img_php_disabled() ) 
					$param_image .= $image_size_slider != '' ? '&image_size=' . $image_size_slider : '';

				if ( themify_get('external_link') != '' ):
					$ext_link = themify_get("external_link");
				elseif ( themify_get('lightbox_link') != '' ):
					$ext_link = themify_get("lightbox_link").'" class="lightbox" rel="prettyPhoto[slider]';
				else:
					$ext_link = get_permalink();
				endif;

			if ( $hide_feat_img_slider == '' || $hide_feat_img_slider == 'no' ) {   
				$post_image = themify_get_image($param_image);  
				if ( $post_image || themify_check('video_url') == 1 ){ ?>
					<?php
					if ( themify_check('video_url') ) {
						global $wp_embed;
						$post_image = $wp_embed->run_shortcode('[embed]' . themify_get('video_url') . '[/embed]');
					}
					?>
					<?php themify_before_post_image(); // Hook ?>
					<figure class="slide-image">
						<?php if ( $unlink_feat ): ?>
							<?php echo $post_image; ?>
						<?php else: ?>
							<a href="<?php echo $ext_link; ?>" title="<?php echo the_title_attribute('echo=0'); ?>">
								<?php echo $post_image; ?>
							</a>
						<?php endif; ?>
					</figure>
					<?php themify_after_post_image(); // Hook ?>
				<?php } ?>
			<?php } ?>

			<?php if ( $hide_post_title_slider != 'yes' || $display_slider != 'none' ): ?>
			<div class="slide-content">
				<?php if ( $hide_post_title_slider == '' || $hide_post_title_slider == 'no' ): ?>
					<?php if ( $unlink_post_title_slider == 'yes' ): ?>
						<h3 class="slide-title"><?php the_title(); ?></h3>
					<?php else: ?>
						<h3 class="slide-title"><a href="<?php echo $ext_link; ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<?php endif; //unlink post title ?>
				<?php endif; // hide post title ?>
				
				<?php
				// fix the issue more link doesn't output
				global $more;
				$more = 0;
				?>

				<?php
				if ( $display_slider == 'content' ) {
					the_content();
				} elseif( $display_slider == 'excerpt' ) {
					the_excerpt();
				}
				?>
			</div>
			<!-- /slide-content -->
			<?php endif; ?>
		</li>
		<?php endwhile; wp_reset_postdata(); ?>

		<?php do_action( 'themify_builder_after_template_content_render' ); ?>

	</ul>
	<!-- /themify_builder_slider -->

</div>
<!-- /module slider -->