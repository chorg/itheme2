<?php
/**
 * Module Name: Image
 * Description: Display Image content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$reg_image_sizes = get_intermediate_image_sizes();
$image_sizes = array();
foreach ( $reg_image_sizes as $v ) {
	$image_sizes[ $v ] = ucfirst( $v );
}
$this->modules['image'] = apply_filters( 'themify_builder_module_image', array(
	'name' => __('Image', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_image',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'style_image',
			'type' => 'layout',
			'label' => __('Image Style', 'themify'),
			'options' => array(
				array('img' => 'image-top.png', 'value' => 'image-top', 'label' => __('Image Top', 'themify')),
				array('img' => 'image-left.png', 'value' => 'image-left', 'label' => __('Image Left', 'themify')),
				array('img' => 'image-right.png', 'value' => 'image-right', 'label' => __('Image Right', 'themify')),
				array('img' => 'image-overlay.png', 'value' => 'image-overlay', 'label' => __('Image Overlay', 'themify'))
			)
		),
		array(
			'id' => 'url_image',
			'type' => 'image',
			'label' => __('Image URL', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'appearance_image',
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
			'id' => 'image_size_image',
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
			'id' => 'width_image',
			'type' => 'text',
			'label' => __('Width', 'themify'),
			'class' => 'xsmall',
			'help' => 'px',
			'value' => 300
		),
		array(
			'id' => 'height_image',
			'type' => 'text',
			'label' => __('Height', 'themify'),
			'class' => 'xsmall',
			'help' => 'px',
			'value' => 200
		),
		array(
			'id' => 'title_image',
			'type' => 'text',
			'label' => __('Image Title', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'link_image',
			'type' => 'text',
			'label' => __('Image Link', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'param_image',
			'type' => 'checkbox',
			'label' => false,
			'pushed' => 'pushed',
			'options' => array(
				array( 'name' => 'lightbox', 'value' => __('Open link in lightbox', 'themify')),
				array( 'name' => 'zoom', 'value' => __('Show zoom icon', 'themify'))
			),
			'new_line' => false
		),
		array(
			'id' => 'caption_image',
			'type' => 'textarea',
			'label' => __('Image Caption', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'css_image',
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