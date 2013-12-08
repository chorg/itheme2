<?php
/**
 * Template Text
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_text' => '',
	'content_text' => '',
	'add_css_text' => ''
);

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $add_css_text . ' module-' . $mod_name;
?>
<!-- module text -->
<div id="<?php echo $module_ID; ?>" class="module <?php echo $class; ?>">
	<?php if ( $mod_title_text != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_text; ?></h3>
	<?php endif; ?>
	<?php echo apply_filters( 'themify_builder_tmpl_shortcode', $content_text ); ?>
</div>
<!-- /module text -->