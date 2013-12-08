<?php
/**
 * Template Video
 * 
 * Access original fields: $mod_settings
 * @author Themify
 */

$fields_default = array(
	'mod_title_video' => '',
	'style_video' => 'video-top',
	'url_video' => '',
	'width_video' => '',
	'unit_video' => '',
	'title_video' => '',
	'title_link_video' => false,
	'caption_video' => '',
	'css_video' => ''
);

$fields_args = wp_parse_args( $mod_settings, $fields_default );
extract( $fields_args, EXTR_SKIP );

$class = $style_video . ' ' . $css_video . ' module-' . $mod_name;
$video_maxwidth = ( empty( $width_video ) ) ? '' : $width_video . $unit_video;
?>

<!-- module video -->
<div id="<?php echo $module_ID; ?>" class="module <?php echo $class; ?>">
	
	<?php if ( $mod_title_video != '' ): ?>
	<h3 class="module-title"><?php echo $mod_title_video; ?></h3>
	<?php endif; ?>

	<div class="video-wrap" <?php echo $video_maxwidth != '' ? 'style="max-width:'.$video_maxwidth.';"' : ''; ?>>
		<?php echo themify_parse_video_embed_vars( wp_oembed_get( $url_video ), $url_video ); ?>
	</div>
	<!-- /video-wrap -->
	<div class="video-content">
		<h3 class="video-title">
			<?php if ( $title_link_video ) : ?>
			<a href="<?php echo $title_link_video; ?>"><?php echo $title_video; ?></a>
			<?php else: ?>
			<?php echo $title_video; ?>
			<?php endif; ?>
		</h3>
		<div class="video-caption">
			<?php echo apply_filters( 'themify_builder_tmpl_shortcode', $caption_video); ?>
		</div>
		<!-- /video-caption -->
	</div>
	<!-- /video-content -->
</div>
<!-- /module video -->