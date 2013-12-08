<?php
/**
 * Module Name: Text
 * Description: Display text content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['text'] = apply_filters( 'themify_builder_module_text', array(
	'name' => __('Text', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_text',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'content_text',
			'type' => 'wp_editor',
			'class' => 'fullwidth'
		),
		array(
			'id' => 'add_css_text',
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