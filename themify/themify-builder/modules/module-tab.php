<?php
/**
 * Module Name: Tab
 * Description: Display Tab content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['tab'] = apply_filters( 'themify_builder_module_tab', array(
	'name' => __('Tab', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_tab',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'layout_tab',
			'type' => 'layout',
			'label' => __('Tab Layout', 'themify'),
			'options' => array(
				array('img' => 'tab-frame.png', 'value' => 'tab-frame', 'label' => __('Tab Frame', 'themify')),
				array('img' => 'tab-window.png', 'value' => 'panel', 'label' => __('Tab Window', 'themify')),
				array('img' => 'tab-vertical.png', 'value' => 'vertical', 'label' => __('Tab Vertical', 'themify')),
				array('img' => 'tab-top.png', 'value' => 'minimal', 'label' => __('Tab Top', 'themify'))
			)
		),
		array(
			'id' => 'color_tab',
			'type' => 'layout',
			'label' => __('Tab Color', 'themify'),
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
			'id' => 'tab_appearance_tab',
			'type' => 'checkbox',
			'label' => __('Tab Appearance', 'themify'),
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
			'id' => 'tab_content_tab',
			'type' => 'builder',
			'options' => array(
				array(
					'id' => 'title_tab',
					'type' => 'text',
					'label' => __('Tab Title', 'themify'),
					'class' => 'large'
				),
				array(
					'id' => 'text_tab',
					'type' => 'wp_editor',
					'label' => false,
					'class' => 'fullwidth',
					'rows' => 6
				)
			)
		),
		array(
			'id' => 'css_tab',
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