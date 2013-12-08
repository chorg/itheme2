<?php
/**
 * Template Widgetized
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */
$fields_default = array(
	'mod_title_widgetized' => '',
	'sidebar_widgetized' => '',
	'custom_css_widgetized' => ''
);
$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = 'module module-'. $mod_name;
$class .= $custom_css_widgetized != '' ? ' ' . $custom_css_widgetized : '';
?>

<!-- module widgetized -->
<div id="<?php echo $module_ID; ?>" class="<?php echo $class; ?>">
	<?php
	if ( $mod_title_widgetized != '' )
		echo '<h3 class="module-title">'.$mod_title_widgetized.'</h3>';

	do_action( 'themify_builder_before_template_content_render' );

	if ( $sidebar_widgetized != '' ) {
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $sidebar_widgetized ) );
	}

	do_action( 'themify_builder_after_template_content_render' );
	?>
</div>
<!-- /module widgetized -->