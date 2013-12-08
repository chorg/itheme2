<?php
/**
 * Module Name: Gallery
 * Description: Display WP Gallery Images
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['gallery'] = apply_filters( 'themify_builder_module_gallery', array(
	'name' => __('Gallery', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_gallery',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'shortcode_gallery',
			'type' => 'textarea',
			//'type' => 'wp_editor_shortcode',
			'class' => 'fullwidth tf-shortcode-input',
			'label' => __('Insert Gallery Shortcode', 'themify'),
			'help' => sprintf('<a href="#" class="builder_button tf-gallery-btn">%s</a>', __('Insert Gallery', 'themify'))
		),
		/*array(
			'id' => 'mode_gallery',
			'type' => 'select',
			'label' => __('Gallery Mode', 'themify'),
			'options' => array(
				'lightbox' => __('Lightbox', 'themify'),
				'photoswipe' => __('Photoswipe', 'themify')
			)
		),*/
		array(
			'id' => 'thumb_w_gallery',
			'type' => 'text',
			'label' => __('Thumbnail Width', 'themify'),
			'class' => 'xsmall',
			'help' => 'px'
		),
		array(
			'id' => 'thumb_h_gallery',
			'type' => 'text',
			'label' => __('Thumbnail Height', 'themify'),
			'class' => 'xsmall',
			'help' => 'px'
		),
		array(
			'id' => 'appearance_gallery',
			'type' => 'checkbox',
			'label' => __('Image Appearance', 'themify'),
			'default' => 'rounded',
			'options' => array(
				array( 'name' => 'rounded', 'value' => __('Rounded', 'themify')),
				array( 'name' => 'drop-shadow', 'value' => __('Drop Shadow', 'themify')),
				array( 'name' => 'bordered', 'value' => __('Bordered', 'themify')),
				array( 'name' => 'circle', 'value' => __('Circle', 'themify'), 'help' => __('(square format image only)', 'themify'))
			)
		),
		array(
			'id' => 'css_gallery',
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