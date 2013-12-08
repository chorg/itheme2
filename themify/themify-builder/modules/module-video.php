<?php
/**
 * Module Name: Video
 * Description: Display Video content
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$this->modules['video'] = apply_filters( 'themify_builder_module_video', array(
	'name' => __('Video', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_video',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'style_video',
			'type' => 'layout',
			'label' => __('Video Style', 'themify'),
			'options' => array(
				array('img' => 'video-top.png', 'value' => 'video-top', 'label' => __('Video Top', 'themify')),
				array('img' => 'video-left.png', 'value' => 'video-left', 'label' => __('Video Left', 'themify')),
				array('img' => 'video-right.png', 'value' => 'video-right', 'label' => __('Video Right', 'themify')),
				array('img' => 'video-overlay.png', 'value' => 'video-overlay', 'label' => __('Video Overlay', 'themify')),
			)
		),
		array(
			'id' => 'url_video',
			'type' => 'text',
			'label' => __('Video URL', 'themify'),
			'class' => 'fullwidth',
			'help' => __('YouTube, Vimeo, etc. video <a href="http://themify.me/docs/video-embeds" target="_blank">embed link</a>', 'themify')
		),
		array(
			'id' => 'width_video',
			'type' => 'text',
			'label' => __('Video Width', 'themify'),
			'class' => 'xsmall',
			'help' => __('Enter fixed witdth (eg. 200px) or relative (eg. 100%). Video height is auto adjusted.', 'themify'),
			'break' => true,
			'unit' => array(
				'id' => 'unit_video',
				'options' => array(
					array( 'id' => 'pixel_unit', 'value' => 'px'),
					array( 'id' => 'percent_unit', 'value' => '%')
				)
			)
		),
		array(
			'id' => 'title_video',
			'type' => 'text',
			'label' => __('Video Title', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'title_link_video',
			'type' => 'text',
			'label' => __('Video Title Link', 'themify'),
			'class' => 'xlarge'
		),
		array(
			'id' => 'caption_video',
			'type' => 'textarea',
			'label' => __('Video Caption', 'themify'),
			'class' => 'fullwidth'
		),
		array(
			'id' => 'css_video',
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