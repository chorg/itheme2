<?php
/**
 * Module Name: Menu
 * Description: Display Custom Menu
 */

///////////////////////////////////////
// Module Options
///////////////////////////////////////
$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
$this->modules['menu'] = apply_filters( 'themify_builder_module_menu', array(
	'name' => __('Menu', 'themify'),
	'options' => array(
		array(
			'id' => 'mod_title_menu',
			'type' => 'text',
			'label' => __('Module Title', 'themify'),
			'class' => 'large'
		),
		array(
			'id' => 'layout_menu',
			'type' => 'layout',
			'label' => __('Menu Layout', 'themify'),
			'options' => array(
				array('img' => 'menu-bar.png', 'value' => 'menu-bar', 'label' => __('Menu Bar', 'themify')),
				array('img' => 'menu-fullbar.png', 'value' => 'fullwidth', 'label' => __('Menu Fullbar', 'themify')),
				array('img' => 'menu-vertical.png', 'value' => 'vertical', 'label' => __('Menu Vertical', 'themify'))
			)
		),
		array(
			'id' => 'custom_menu',
			'type' => 'select_menu',
			'label' => __('Custom Menu', 'themify'),
			'options' => $menus,
			'help' => sprintf(__('Add more <a href="%s" target="_blank">menu</a>', 'themify'), admin_url( 'nav-menus.php' )),
			'break' => true
		),
		array(
			'id' => 'color_menu',
			'type' => 'layout',
			'label' => __('Menu Color', 'themify'),
			'options' => array(
				array('img' => 'color-default.png', 'value' => 'default', 'label' => __('default', 'themify')),
				array('img' => 'color-black.png', 'value' => 'black', 'label' => __('black', 'themify')),
				array('img' => 'color-grey.png', 'value' => 'gray', 'label' => __('gray', 'themify')),
				array('img' => 'color-blue.png', 'value' => 'blue', 'label' => __('blue', 'themify')),
				array('img' => 'color-light-blue.png', 'value' => 'light-blue', 'label' => __('light-blue', 'themify')),
				array('img' => 'color-green.png', 'value' => 'green', 'label' => __('green', 'themify')),
				array('img' => 'color-light-green.png', 'value' => 'light-green', 'label' => __('light-green', 'themify')),
				array('img' => 'color-purple.png', 'value' => 'purple', 'label' => __('purple', 'themify')),
				array('img' => 'color-light-purple.png', 'value' => 'light-purple', 'label' => __('light-purple', 'themify')),
				array('img' => 'color-brown.png', 'value' => 'brown', 'label' => __('brown', 'themify')),
				array('img' => 'color-orange.png', 'value' => 'orange', 'label' => __('orange', 'themify')),
				array('img' => 'color-yellow.png', 'value' => 'yellow', 'label' => __('yellow', 'themify')),
				array('img' => 'color-red.png', 'value' => 'red', 'label' => __('red', 'themify')),
				array('img' => 'color-pink.png', 'value' => 'pink', 'label' => __('pink', 'themify'))
			)
		),
		array(
			'id' => 'according_style_menu',
			'type' => 'checkbox',
			'label' => __('According Styles', 'themify'),
			'default' => array(
				'rounded', 
				'gradient'
			),
			'options' => array(
				array( 'name' => 'rounded', 'value' => __('Rounded', 'themify')),
				array( 'name' => 'gradient', 'value' => __('Gradient', 'themify')),
				array( 'name' => 'glossy', 'value' => __('Glossy', 'themify')),
				array( 'name' => 'embossed', 'value' => __('Embossed', 'themify')),
				array( 'name' => 'shadow', 'value' => __('Shadow', 'themify'))
			)
		),
		array(
			'id' => 'css_menu',
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