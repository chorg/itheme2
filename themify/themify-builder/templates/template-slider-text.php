<?php
/**
 * Template Slider Text
 * 
 * Access original fields: $settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_slider' => '',
	'layout_display_slider' => '',
	'display_slider' => 'content',
	'text_content_slider' => array(),
	'layout_slider' => '',
	'visible_opt_slider' => '',
	'auto_scroll_opt_slider' => 0,
	'scroll_opt_slider' => '',
	'speed_opt_slider' => '',
	'effect_slider' => 'scroll',
	'wrap_slider' => 'yes',
	'show_nav_slider' => 'yes',
	'show_arrow_slider' => 'yes',
	'left_margin_slider' => '',
	'right_margin_slider' => '',
	'css_slider' => ''
);

if ( isset( $settings['auto_scroll_opt_slider'] ) )	
	$settings['auto_scroll_opt_slider'] = $settings['auto_scroll_opt_slider'];

$fields_args = wp_parse_args( $settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $css_slider . ' ' . $layout_slider . ' module-' . $mod_name;
$visible = $visible_opt_slider;
$scroll = $scroll_opt_slider;
$auto_scroll = $auto_scroll_opt_slider;
$arrow = $show_arrow_slider;
$pagination = $show_nav_slider;
$left_margin = ! empty( $left_margin_slider ) ? $left_margin_slider .'px' : '';
$right_margin = ! empty( $right_margin_slider ) ? $right_margin_slider .'px' : '';
$wrapper = $wrap_slider;
$effect = $effect_slider;

switch ( $speed_opt_slider ) {
	case 'slow':
		$speed = 4;
	break;
	
	case 'fast':
		$speed = '.5';
	break;

	default:
	 $speed = 1;
	break;
}
?>
<!-- module slider text -->
<div id="<?php echo $module_ID; ?>" class="module themify_builder_slider_wrap <?php echo $class; ?> clearfix">
	<?php if ( $mod_title_slider != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_slider; ?></h3>
	<?php endif; ?>
	
	<ul class="themify_builder_slider" 
		data-id="<?php echo $module_ID; ?>" 
		data-visible="<?php echo $visible; ?>" 
		data-scroll="<?php echo $scroll; ?>" 
		data-auto-scroll="<?php echo $auto_scroll; ?>"
		data-speed="<?php echo $speed; ?>"
		data-wrapper="<?php echo $wrapper; ?>"
		data-arrow="<?php echo $arrow; ?>"
		data-pagination="<?php echo $pagination; ?>" 
		data-effect="<?php echo $effect; ?>" >
		
		<?php foreach ( $text_content_slider as $content ): ?>
		<li style="<?php echo ! empty( $left_margin ) ? 'margin-left:'.$left_margin.';' : ''; ?> <?php echo ! empty( $right_margin ) ? 'margin-right:'.$right_margin.';' : ''; ?>">
			<div class="slide-content">
				<?php
					if ( isset( $content['text_caption_slider'] ) ) {
						echo apply_filters( 'themify_builder_tmpl_shortcode', $content['text_caption_slider'] );
					}
				?>
			</div>
			<!-- /slide-content -->
		</li>
		<?php endforeach; ?>
	</ul>
	<!-- /themify_builder_slider -->
</div>
<!-- /module slider text -->