<?php
/**
 * Template Map
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_map' => '',
	'address_map' => '',
	'zoom_map' => 15,
	'w_map' => '100%',
	'unit_w' => '',
	'h_map' => '300px',
	'unit_h' => '',
	'b_style_map' => '',
	'b_width_map' => '',
	'b_color_map' => '',
	'css_map' => ''
);

if ( isset( $mod_settings['address_map'] ) ) 
	$mod_settings['address_map'] = preg_replace( '/\s+/', ' ', trim( $mod_settings['address_map'] ) );

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $css_map . ' module-' . $mod_name;
$style = '';

// specify border
if ( isset( $mod_settings['b_width_map'] ) ) {
	$style .= 'border: ';
	$style .= ( isset($mod_settings['b_style_map'] ) ) ? $mod_settings['b_style_map'] : '';
	$style .= ( isset($mod_settings['b_width_map'] ) ) ? ' '.$mod_settings['b_width_map'].'px' : '';
	$style .= ( isset($mod_settings['b_color_map'] ) ) ? ' #'.$mod_settings['b_color_map'] : '';
	$style .= ';';
}

$style .= 'width:';
$style .= ( isset( $mod_settings['w_map'] ) ) ? $mod_settings['w_map'].$mod_settings['unit_w'] : '100%';
$style .= ';';
$style .= 'height:';
$style .= ( isset( $mod_settings['h_map'] ) ) ? $mod_settings['h_map'].$mod_settings['unit_h'] : '300px';
$style .= ';';
?>
<!-- module map -->
<div id="<?php echo $module_ID; ?>" class="module <?php echo $class; ?>">
	<?php if( $mod_title_map != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_map; ?></h3>
	<?php endif; ?>
	<?php 
	if ( ! empty( $address_map ) ) {
		// enqueue map script
		if ( ! wp_script_is( 'themify-builder-map-script' ) ) {
			wp_enqueue_script('themify-builder-map-script');
		}
	?>
	<?php $num = rand(0,10000); ?>
		<script type="text/javascript"> 
			function themify_builder_create_map() {
				ThemifyBuilderModuleJs.initialize("<?php echo $address_map; ?>", <?php echo $num; ?>, <?php echo $zoom_map; ?>);
			}
			jQuery(document).ready(function() {
				if( typeof google === 'undefined' ) {
					var script = document.createElement("script");
					script.type = "text/javascript";
					script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=themify_builder_create_map";
					document.body.appendChild(script);
				} else {
					ThemifyBuilderModuleJs.initialize("<?php echo $address_map; ?>", <?php echo $num; ?>, <?php echo $zoom_map; ?>);
				}
			});
		</script>
		<div id="themify_map_canvas_<?php echo $num; ?>" style="<?php echo $style; ?>" class="map-container">&nbsp;</div>
	<?php
	}
	?>
</div>
<!-- /module map -->