<?php
/**
 * Module Name: Widget
 * Description: Display any available widgets
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['widget'] = apply_filters( 'themify_builder_module_widget', array(
	'name' => __('Widget', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_widget',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'class_widget',
			'type' => 'widget_select',
			'label' => __('Select Widget', 'themify'),
			'class' => 'large',
			'help' => __('Select Available Widgets', 'themify'),
			'separated' => 'bottom',
			'break' => true
		),
		array(
			'id' => 'instance_widget',
			'type' => 'widget_form',
			'label' => false
		),
		array(
			'id' => 'custom_css_widget',
			'type' => 'text',
			'label' => __('Additional CSS Class', 'themify'),
			'help' => __('Add additional CSS class(es) for custom styling', 'themify'),
			'class' => 'large',
			'separated' => 'top',
			'break' => true
		)
	)
) );

add_action( 'themify_builder_lightbox_fields', 'themify_builder_module_widget_fields', 10, 2 );
function themify_builder_module_widget_fields($field, $mod_name) {
	global $wp_widget_factory;
	$output = '';

	if ( $mod_name != 'widget' ) return;

	switch ( $field['type'] ) {
		case 'widget_select':
			$output .= '<select name="'.$field['id'].'" id="'.$field['id'].'" class="tfb_lb_option module-widget-select-field">';
			$output .= '<option></option>';
			foreach ($wp_widget_factory->widgets as $class => $widget ) {
				$output .= '<option value="'.$class.'" data-idbase="'.$widget->id_base.'">'.$widget->name.'</option>';
			}
			$output .= '</select>';
		break;
		
		case 'widget_form':
		$output .= '<div id="'.$field['id'].'" class="module-widget-form-container module-widget-form-placeholder tfb_lb_option"></div>';
		break;	
	}
	echo $output;
}

// Ajax Actions
add_action( 'wp_ajax_module_widget_get_form', 'themify_builder_module_widget_get_form', 10 );
function themify_builder_module_widget_get_form() {
	if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);
	
	global $wp_widget_factory;
	require_once ABSPATH . 'wp-admin/includes/widgets.php';

	$class = $_POST['load_class'];
	if ( $class == '') die(-1);

	$get_instance = $_POST['widget_instance'];
	$instance = array();
	if ( is_array( $get_instance ) && count( $get_instance ) > 0 ) {
		foreach ( $get_instance as $k => $s ) {
			$instance = $s;
		}
	}

	$widget = new $class();
	$widget->number = next_widget_id_number( $_POST['id_base'] );

	ob_start();
	$widget->form($instance);
	$form = ob_get_clean();

	$widget->form = $form;

	echo $widget->form;
	echo '<br/>';
	die();
}
?>