<?php
/***************************************************************************
 *
 * 	----------------------------------------------------------------------
 * 						DO NOT EDIT THIS FILE
 *	----------------------------------------------------------------------
 * 
 *  				     Copyright (C) Themify
 * 
 *	----------------------------------------------------------------------
 *
 * 
 * Layout Hooks:
 * 
 * 		themify_body_start
 * 
 * 		themify_header_before
 * 		themify_header_start
 * 		themify_header_end
 * 		themify_header_after
 * 
 * 		themify_layout_before
 * 
 * 		themify_content_before 
 * 		themify_content_start
 * 
 * 		themify_post_before
 * 		themify_post_start
 *		themify_post_end
 * 		themify_post_after
 * 
 * 		themify_comment_before
 * 		themify_comment_start
 * 		themify_comment_end
 * 		themify_comment_after
 * 
 *		themify_content_end
 * 		themify_content_after
 * 
 * 		themify_sidebar_before
 * 		themify_sidebar_start
 * 		themify_sidebar_end
 * 		themify_sidebar_after
 * 
 * 		themify_layout_after
 * 
 * 		themify_footer_before
 * 		themify_footer_start
 * 		themify_footer_end
 *		themify_footer_after
 * 
 *		themify_body_end
 * 
 * Theme Feature Hooks:
 * 
 * 		welcome_before
 * 		welcome_start
 * 		welcome_end
 * 		welcome_after
 * 
 * 		slider_before
 * 		slider_start
 * 		slider_end
 *		slider_after
 * 
 * 		footer_slider_before
 * 		footer_slider_start
 * 		footer_slider_end
 * 		footer_slider_after
 * 		
 * 		themify_product_slider_add_to_cart_before
 * 		themify_product_slider_add_to_cart_after
 * 		
 * 		
 * 		
 * 		
 * 
***************************************************************************/

/**
 * Layout Hooks
 */

function themify_body_start() { 		do_action( 'themify_body_start' 	);}

function themify_header_before() { 		do_action( 'themify_header_before' 	);}
function themify_header_start() { 		do_action( 'themify_header_start' 	);}
function themify_header_end() { 		do_action( 'themify_header_end' 	);}
function themify_header_after(){ 		do_action( 'themify_header_after'	);}

function themify_layout_before() { 		do_action( 'themify_layout_before' 	);}

function themify_content_before (){		do_action( 'themify_content_before' );}
function themify_content_start(){ 		do_action( 'themify_content_start' 	);}

function themify_post_before(){ 		do_action( 'themify_post_before' 	);}
function themify_post_start() { 		do_action( 'themify_post_start' 	);}

function themify_before_post_image() { 	do_action( 'themify_before_post_image' 	);}
function themify_after_post_image() { 	do_action( 'themify_after_post_image' 	);}

function themify_before_post_title() { 	do_action( 'themify_before_post_title' );}
function themify_after_post_title() { 	do_action( 'themify_after_post_title' 	);}

function themify_before_post_content(){ do_action( 'themify_before_post_content' );}
function themify_after_post_content() { do_action( 'themify_after_post_content'  );}

function themify_post_end() { 			do_action( 'themify_post_end' 		);}
function themify_post_after() { 		do_action( 'themify_post_after' 	);}

function themify_comment_before() { 	do_action( 'themify_comment_before' );}
function themify_comment_start() { 		do_action( 'themify_comment_start' 	);}
function themify_comment_end() { 		do_action( 'themify_comment_end' 	);}
function themify_comment_after() { 		do_action( 'themify_comment_after' 	);}

function themify_content_end() { 		do_action( 'themify_content_end' 	);}
function themify_content_after() { 		do_action( 'themify_content_after' 	);}

function themify_sidebar_before(){ 		do_action( 'themify_sidebar_before' );}
function themify_sidebar_start (){		do_action( 'themify_sidebar_start' 	);}
function themify_sidebar_end(){ 		do_action( 'themify_sidebar_end' 	);}
function themify_sidebar_after(){ 		do_action( 'themify_sidebar_after' 	);}

function themify_layout_after() { 		do_action( 'themify_layout_after' 	);}

function themify_footer_before() { 		do_action( 'themify_footer_before' 	);}
function themify_footer_start() { 		do_action( 'themify_footer_start' 	);}
function themify_footer_end() { 		do_action( 'themify_footer_end' 	);}
function themify_footer_after() { 		do_action( 'themify_footer_after' 	);}

function themify_body_end() { 			do_action( 'themify_body_end' 		);}


/**
 * Theme Features Hooks
 */

function themify_welcome_before(){		do_action( 'themify_welcome_before' );}
function themify_welcome_start(){		do_action( 'themify_welcome_start' 	);}
function themify_welcome_end(){			do_action( 'themify_welcome_end' 	);}
function themify_welcome_after(){		do_action( 'themify_welcome_after' 	);}

function themify_slider_before(){		do_action( 'themify_slider_before' 	);}
function themify_slider_start(){		do_action( 'themify_slider_start' 	);}
function themify_slider_end(){			do_action( 'themify_slider_end'		);}
function themify_slider_after(){		do_action( 'themify_slider_after' 	);}

function themify_footer_slider_before(){do_action( 'themify_footer_slider_before' );}
function themify_footer_slider_start(){ do_action( 'themify_footer_slider_start'  );}
function themify_footer_slider_end(){ 	do_action( 'themify_footer_slider_end' 	  );}
function themify_footer_slider_after(){ do_action( 'themify_footer_slider_after'  );}

function themify_sidebar_alt_before(){ 	do_action( 'themify_sidebar_alt_before'	);}
function themify_sidebar_alt_start(){ 	do_action( 'themify_sidebar_alt_start'	);}
function themify_sidebar_alt_end(){ 	do_action( 'themify_sidebar_alt_end'	);}
function themify_sidebar_alt_after(){ 	do_action( 'themify_sidebar_alt_after'	);}

function themify_product_slider_add_to_cart_before(){ do_action('themify_product_slider_add_to_cart_before'); }
function themify_product_slider_add_to_cart_after(){  do_action('themify_product_slider_add_to_cart_after');  }
function themify_product_slider_image_start(){ 	do_action('themify_product_slider_image_start'); }
function themify_product_slider_image_end(){ 	do_action('themify_product_slider_image_end'); }
function themify_product_slider_title_start(){ 	do_action('themify_product_slider_title_start'); }
function themify_product_slider_title_end(){ 	do_action('themify_product_slider_title_end'); }
function themify_product_slider_price_start(){ 	do_action('themify_product_slider_price_start'); }
function themify_product_slider_price_end(){ 	do_action('themify_product_slider_price_end'); }

function themify_product_image_start(){ do_action('themify_product_image_start'); }
function themify_product_image_end(){ 	do_action('themify_product_image_end'); }
function themify_product_title_start(){ do_action('themify_product_title_start'); }
function themify_product_title_end(){ 	do_action('themify_product_title_end'); }
function themify_product_price_start(){ do_action('themify_product_price_start'); }
function themify_product_price_end(){ 	do_action('themify_product_price_end'); }

function themify_product_cart_image_start(){	do_action('themify_product_cart_image_start'); }
function themify_product_cart_image_end(){ 		do_action('themify_product_cart_image_end'); }

function themify_product_single_image_before(){ do_action('themify_product_single_image_before'); }
function themify_product_single_image_end(){ 	do_action('themify_product_single_image_end'); }
function themify_product_single_title_before(){ do_action('themify_product_single_title_before'); }
function themify_product_single_title_end(){ 	do_action('themify_product_single_title_end'); }
function themify_product_single_price_before(){ do_action('themify_product_single_price_before'); }
function themify_product_single_price_end(){ 	do_action('themify_product_single_price_end'); }

function themify_shopdock_before(){ do_action('themify_shopdock_before'); }
function themify_shopdock_start(){ 	do_action('themify_shopdock_start'); }
function themify_checkout_start(){ 	do_action('themify_checkout_start'); }
function themify_checkout_end(){ 	do_action('themify_checkout_end'); }
function themify_shopdock_end(){ 	do_action('themify_shopdock_end'); }
function themify_shopdock_after(){ 	do_action('themify_shopdock_after'); }

function themify_sorting_before(){ 	do_action('themify_sorting_before'); }
function themify_sorting_after(){ 	do_action('themify_sorting_after'); }
function themify_related_products_start(){ 	do_action('themify_related_products_start'); }
function themify_related_products_end(){ 	do_action('themify_related_products_end'); }

function themify_breadcrumb_before(){ 	do_action('themify_breadcrumb_before'); }
function themify_breadcrumb_after(){ 	do_action('themify_breadcrumb_after'); }

function themify_ecommerce_sidebar_before(){ 	do_action('themify_ecommerce_sidebar_before'); }
function themify_ecommerce_sidebar_after(){ 	do_action('themify_ecommerce_sidebar_after'); }

?>