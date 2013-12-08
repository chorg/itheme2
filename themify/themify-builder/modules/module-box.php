<?php
/**
 * Module Name: Box
 * Description: Display box content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['box'] = apply_filters( 'themify_builder_module_box', array(
	'name' => __('Box', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_box',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'content_box',
			'type' => 'wp_editor',
			'class' => 'fullwidth'
		),
		array(
			'id' => 'color_box',
			'type' => 'layout',
			'label' => __('Box Color', 'themify'),
			'options' => array(
				array('img' => 'color-default.png', 'value' => 'default', 'label' => __('default', 'themify')),
				array('img' => 'color-black.png', 'value' => 'black', 'label' => __('black', 'themify')),
				array('img' => 'color-grey.png', 'value' => 'gray', 'label' => __('gray', 'themify')),
				array('img' => 'color-blue.png', 'value' => 'blue', 'label' => __('blue', 'themify')),
				array('img' => 'color-light-blue.png', 'value' => 'light-blue', 'label' => __('light-blue', 'themify')),
				array('img' => 'color-green.png', 'value' => 'green', 'label' => __('green', 'themify')),
				array('img' => 'color-light-green.png', 'value' => 'light-green', 'label' => __('light-green', 'themify')),
				array('img' => 'color-purple.png', 'value' => 'purple', 'label' => __('purple', 'themify')),
				array('img' => 'color-light-purple.png', 'value' => 'light-purple', 'label' => __('light-purple', 'themify')),
				array('img' => 'color-brown.png', 'value' => 'brown', 'label' => __('brown', 'themify')),
				array('img' => 'color-orange.png', 'value' => 'orange', 'label' => __('orange', 'themify')),
				array('img' => 'color-yellow.png', 'value' => 'yellow', 'label' => __('yellow', 'themify')),
				array('img' => 'color-red.png', 'value' => 'red', 'label' => __('red', 'themify')),
				array('img' => 'color-pink.png', 'value' => 'pink', 'label' => __('pink', 'themify'))
			),
			'bottom' => true
		),
		array(
			'id' => 'appearance_box',
			'type' => 'checkbox',
			'label' => __('Appearance', 'themify'),
			'default' => array(
				'rounded', 
				'gradient'
			),
			'options' => array(
				array( 'name' => 'rounded', 'value' => __('Rounded', 'themify')),
				array( 'name' => 'gradient', 'value' => __('Gradient', 'themify')),
				array( 'name' => 'glossy', 'value' => __('Glossy', 'themify')),
				array( 'name' => 'embossed', 'value' => __('Embossed', 'themify')),
				array( 'name' => 'shadow', 'value' => __('Shadow', 'themify'))
			)
		),
		array(
			'id' => 'add_css_box',
			'type' => 'text',
			'label' => __('Additional CSS Class', 'themify'),
			'help' => __('Add additional CSS class(es) for custom styling', 'themify'),
			'class' => 'large',
			'separated' => 'top',
			'break' => true
		)
	)
) );

?>