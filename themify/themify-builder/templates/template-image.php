<?php
/**
 * Template Image
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_image' => '',
	'url_image' => '',
	'appearance_image' => '',
	'image_size_image' => '',
	'width_image' => '',
	'height_image' => '',
	'title_image' => '',
	'link_image' => '',
	'param_image' => array(),
	'caption_image' => '',
	'css_image' => ''
);

if ( isset( $mod_settings['appearance_image'] ) ) 
	$mod_settings['appearance_image'] = $this->get_checkbox_data( $mod_settings['appearance_image'] );

if ( isset( $mod_settings['param_image'] ) ) 
	$mod_settings['param_image'] = explode( '|', $mod_settings['param_image'] );

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $style_image . ' ' . $appearance_image . ' ' . $css_image . ' module-' . $mod_name;
$lightbox = in_array( 'lightbox', $param_image ) ? true : false;
$zoom = in_array( 'zoom', $param_image ) ? true : false;
$link_attr = $lightbox ? 'class="lightbox-builder lightbox"' : '';

$param_image_src = 'src='.$url_image.'&w='.$width_image .'&h='.$height_image.'&alt='.$title_image.'&ignore=true';
if ( $this->is_img_php_disabled() ) {
	// get image preset
	$preset = $image_size_image != '' ? $image_size_image : themify_get('setting-global_feature_size');
	if ( isset( $_wp_additional_image_sizes[ $preset ]) && $image_size_image != '') {
		$width_image = intval( $_wp_additional_image_sizes[ $preset ]['width'] );
		$height_image = intval( $_wp_additional_image_sizes[ $preset ]['height'] );
	} else {
		$width_image = $width_image != '' ? $width_image : get_option($preset.'_size_w');
		$height_image = $height_image != '' ? $height_image : get_option($preset.'_size_h');
	}
	$image = '<img src="'.$url_image.'" alt="'.$title_image.'" width="'.$width_image.'" height="'.$height_image.'">';
} else {
	$image = themify_get_image($param_image_src);
}

// check whether link is image or url
if ( ! empty( $link_image ) ) {
	$check_img = $this->is_img_link( $link_image );
	if ( ! $check_img && $lightbox ) {
		$link_image = $link_image . '?iframe=true&width=100%&height=100%';
	}
}

?>
<!-- module image -->
<div id="<?php echo $module_ID; ?>" class="module <?php echo $class; ?>">
	
	<?php if ( $mod_title_image != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_image; ?></h3>
	<?php endif; ?>

	<div class="image-wrap<?php echo $lightbox ? ' lightbox' : ''; ?>">
		<?php if ( ! empty( $link_image ) ): ?>
		<a href="<?php echo $link_image; ?>" <?php echo $link_attr; ?>>
			<?php if ( $zoom ): ?>
			<span class="zoom"></span>
			<?php endif; ?>
			<?php echo $image; ?>
		</a>
		<?php else: ?>
			<?php echo $image; ?>
		<?php endif; ?>
	</div>
	<!-- /image-wrap -->
	<div class="image-content">
		<h3 class="image-title">
			<?php if ( ! empty( $link_image ) ): ?>
			<a href="<?php echo $link_image; ?>" <?php echo $link_attr; ?>>
				<?php echo $title_image; ?>
			</a>
			<?php else: ?>
			<?php echo $title_image; ?>
			<?php endif; ?>
		</h3>

		<div class="image-caption">
			<?php echo apply_filters( 'themify_builder_tmpl_shortcode', $caption_image ); ?>
		</div>
		<!-- /image-caption -->
	</div>
	<!-- /image-content -->
</div>
<!-- /module image -->