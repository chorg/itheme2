<?php
/**
 * Module Name: Map
 * Description: Display Map
 */

///////////////////////////////////////
// Enqueue Script
///////////////////////////////////////
add_action( 'wp_enqueue_scripts', 'themify_builder_map_scripts' );
function themify_builder_map_scripts() {
	global $version;
	//Register map scripts
	wp_register_script('themify-builder-map-script', 'http://maps.google.com/maps/api/js?sensor=false', array(), $version, true);
}

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$zoom_opt = array();
for ( $i=1; $i < 17 ; $i++ ) { 
 array_push( $zoom_opt, $i );
}
$this->modules['map'] = apply_filters( 'themify_builder_module_map', array(
	'name' => __('Map', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_map',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'address_map',
			'type' => 'textarea',
			'value' => '',
			'class' => 'fullwidth',
			'label' => __('Address', 'themify')
		),
		array(
			'id' => 'zoom_map',
			'type' => 'selectbasic',
			'label' => __('Zoom', 'themify'),
			'default' => 8,
			'options' => $zoom_opt
		),
		array(
			'id' => 'w_map',
			'type' => 'text',
			'class' => 'xsmall',
			'label' => __('Width', 'themify'),
			'unit' => array(
				'id' => 'unit_w',
				'selected' => '%',
				'options' => array(
					array( 'id' => 'pixel_unit_w', 'value' => 'px'),
					array( 'id' => 'percent_unit_w', 'value' => '%')
				)
			),
			'value' => 100
		),
		array(
			'id' => 'h_map',
			'type' => 'text',
			'label' => __('Height', 'themify'),
			'class' => 'xsmall',
			'unit' => array(
				'id' => 'unit_h',
				'options' => array(
					array( 'id' => 'pixel_unit_h', 'value' => 'px')
				)
			),
			'value' => 300
		),
		array(
			'id' => 'multifield',
			'type' => 'multifield',
			'label' => __('Border', 'themify'),
			'options' => array(
				'select' => array(
					'id' => 'b_style_map',
					'options' => array('solid', 'dotted', 'dashed')
				),
				'text' => array(
					'id' => 'b_width_map',
					'help' => 'px'
				),
				'colorpicker' => array(
					'id' => 'b_color_map',
					'class' => 'small'
				)
			)
		),
		array(
			'id' => 'css_map',
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