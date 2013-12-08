<?php
/**
 * Module Name: Widgetized
 * Description: Display any registered sidebar
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['widgetized'] = apply_filters( 'themify_builder_module_widget', array(
	'name' => __('Widgetized', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_widgetized',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'sidebar_widgetized',
			'type' => 'widgetized_select',
			'label' => __('Widgetized Area', 'themify'),
			'class' => 'large',
		),
		array(
			'id' => 'custom_css_widgetized',
			'type' => 'text',
			'label' => __('Additional CSS Class', 'themify'),
			'help' => __('Add additional CSS class(es) for custom styling', 'themify'),
			'class' => 'large',
			'separated' => 'top',
			'break' => true
		)
	)
) );

add_action( 'themify_builder_lightbox_fields', 'themify_builder_module_widgetized_fields', 10, 2 );
function themify_builder_module_widgetized_fields($field, $mod_name) {
	global $wp_registered_sidebars;
	$output = '';

	if ( $mod_name != 'widgetized' ) return;

	switch ( $field['type'] ) {
		case 'widgetized_select':
			$output .= '<select name="'.$field['id'].'" id="'.$field['id'].'" class="tfb_lb_option">';
			foreach ( $wp_registered_sidebars as $k => $v ) {
				$output .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
			}
			$output .= '</select>';
		break;	
	}
	echo $output;
}
?>