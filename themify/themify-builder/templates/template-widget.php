<?php
/**
 * Template Widget
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */
$fields_default = array(
	'mod_title_widget' => '',
	'class_widget' => '',
	'instance_widget' => array(),
	'custom_css_widget' => ''
);
$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = 'module module-'. $mod_name;
$class .= $custom_css_widget != '' ? ' ' . $custom_css_widget : '';
?>

<!-- module widget -->
<div id="<?php echo $module_ID; ?>" class="<?php echo $class; ?>">
	<?php
	if ( $mod_title_widget != '' )
		echo '<h3 class="module-title">'.$mod_title_widget.'</h3>';

	do_action( 'themify_builder_before_template_content_render' );

	if ( is_array( $instance_widget ) && count( $instance_widget ) > 0 ) {
		foreach ( $instance_widget as $key => $instance ) {
			if ( $class_widget != '' && class_exists( $class_widget ) ) 
				the_widget( $class_widget, $instance );
		}
	}

	do_action( 'themify_builder_after_template_content_render' );
	?>
</div>
<!-- /module widget -->