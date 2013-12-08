<?php
/**
 * Module Name: Callout
 * Description: Display Callout content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['callout'] = apply_filters( 'themify_builder_module_callout', array(
	'name' => __('Callout', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_callout',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'layout_callout',
			'type' => 'layout',
			'label' => __('Callout Style', 'themify'),
			'options' => array(
				array('img' => 'callout-button-right.png', 'value' => 'button-right', 'label' => __('Button Right', 'themify')),
				array('img' => 'callout-button-left.png', 'value' => 'button-left', 'label' => __('Button Left', 'themify')),
				array('img' => 'callout-button-bottom.png', 'value' => 'button-bottom', 'label' => __('Button Bottom', 'themify')),
				array('img' => 'callout-button-bottom-center.png', 'value' => 'button-bottom-center', 'label' => __('Button Bottom Center', 'themify'))
			)
		),
		array(
			'id' => 'heading_callout',
			'type' => 'text',
			'label' => __('Callout Heading', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'text_callout',
			'type' => 'textarea',
			'label' => __('Callout Text', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'color_callout',
			'type' => 'layout',
			'label' => __('Callout Color', 'themify'),
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
			)
		),
		array(
			'id' => 'appearance_callout',
			'type' => 'checkbox',
			'label' => __('Callout Appearance', 'themify'),
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
			'id' => 'action_btn_link_callout',
			'type' => 'text',
			'label' => __('Action Button Link', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'action_btn_text_callout',
			'type' => 'text',
			'label' => __('Action Button Text', 'themify'),
			'class' => 'medium'
			//'help' => __('If button text is empty = default text: More' ,'themify'),
			//'break' => true
		),
		array(
			'id' => 'action_btn_color_callout',
			'type' => 'layout',
			'label' => __('Action Button Color', 'themify'),
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
			)
		),
		array(
			'id' => 'action_btn_appearance_callout',
			'type' => 'checkbox',
			'label' => __('Action Button Appearance', 'themify'),
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
			'id' => 'css_callout',
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