<?php
/**
 * Module Name: Accordion
 * Description: Display Accordion content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['accordion'] = apply_filters( 'themify_builder_module_accordion', array(
	'name' => __('Accordion', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_accordion',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'layout_accordion',
			'type' => 'layout',
			'label' => __('Accordion layout', 'themify'),
			'options' => array(
				array('img' => 'accordion-default.png', 'value' => 'default', 'label' => __('Plus Icon Button', 'themify')),
				array('img' => 'accordion-separate.png', 'value' => 'separate', 'label' => __('Pipe', 'themify'))
			)
		),
		array(
			'id' => 'expand_collapse_accordion',
			'type' => 'radio',
			'label' => __('Expand / Collapse', 'themify'),
			'default' => 'toggle',
			'options' => array(
				'toggle' => __('Toggle <small>(only clicked item is toggled)</small>', 'themify'),
				'accordion' => __('Accordion <small>(collapse all, but keep clicked item expanded)</small>', 'themify')
			),
			'break' => true
		),
		array(
			'id' => 'color_accordion',
			'type' => 'layout',
			'label' => __('Accordion Color', 'themify'),
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
			'id' => 'accordion_appearance_accordion',
			'type' => 'checkbox',
			'label' => __('Accordion Appearance', 'themify'),
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
			'id' => 'content_accordion',
			'type' => 'builder',
			'options' => array(
				array(
					'id' => 'title_accordion',
					'type' => 'text',
					'label' => __('Accordion Title', 'themify'),
					'class' => 'large'
				),
				array(
					'id' => 'text_accordion',
					'type' => 'wp_editor',
					'label' => false,
					'class' => 'fullwidth',
					'rows' => 6
				),
				array(
					'id' => 'default_accordion',
					'type' => 'radio',
					'label' => __('Default', 'themify'),
					'default' => 'toggle',
					'options' => array(
						'closed' => __('closed', 'themify'),
						'open' => __('open', 'themify')
					)
				),
			)
		),
		array(
			'id' => 'css_accordion',
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