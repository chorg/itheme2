<?php
/**
 * Template Menu
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_menu' => '',
	'layout_menu' => '',
	'custom_menu' => '',
	'color_menu' => '',
	'according_style_menu' => '',
	'css_menu' => ''
);

if ( isset( $mod_settings['according_style_menu'] ) ) 
	$mod_settings['according_style_menu'] = $this->get_checkbox_data( $mod_settings['according_style_menu'] );

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $css_menu . ' module-' . $mod_name;
?>

<!-- module menu -->
<div id="<?php echo $module_ID; ?>" class="module <?php echo $class; ?>">
	<?php if ( $mod_title_menu != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_menu; ?></h3>
	<?php endif; ?>
	
	<?php 
	$args = array(
		'menu' => $custom_menu,
		'menu_class' => 'ui nav ' . $layout_menu . ' ' . $color_menu . ' ' . $according_style_menu
	);
	wp_nav_menu( $args );
	?>
</div>
<!-- /module menu -->