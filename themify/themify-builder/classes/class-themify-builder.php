<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Themify_Builder' ) ) {

	/**
	 * Main Themify Builder class
	 * 
	 * @package default
	 */
	class Themify_Builder {

		/**
		 * @var string
		 */
		private $meta_key;

		/**
		 * @var string
		 */
		private $meta_key_transient;

		/**
		 * @var array
		 */
		var $builder_settings = array();

		/**
		 * @var array
		 */
		var $modules = array();

		/**
		 * @var array
		 */
		var $template_vars = array();

		/**
		 * @var array
		 */
		var $module_settings = array();

		/**
		 * @var array
		 */
		var $registered_post_types = array();

		/**
		 * Feature Image
		 * @var array
		 */
		var $post_image = array();
		
		/**
		 * Feature Image Size
		 * @var array
		 */
		var $featured_image_size = array();

		/**
		 * Image Width
		 * @var array
		 */
		var $image_width = array();

		/**
		 * Image Height
		 * @var array
		 */
		var $image_height = array();

		/**
		 * External Link
		 * @var array
		 */
		var $external_link = array();

		/**
		 * Lightbox Link
		 * @var array
		 */
		var $lightbox_link = array();

		/**
		 * Define builder grid active or not
		 * @var bool
		 */
		var $frontedit_active = false;

		/**
		 * Themify Builder Constructor
		 */
		function __construct() {}

		/**
		 * Class Init
		 */
		function init() {
			// Include required files
			$this->includes();

			// Init
			$this->load_general_metabox(); // setup metabox fields
			$this->load_modules(); // load builder modules

			// Builder write panel
			add_filter( 'themify_do_metaboxes', array( &$this, 'builder_write_panels' ), 11 );

			// Filtered post types
			add_filter( 'themify_post_types', array( &$this, 'extend_post_types' ) );

			// Actions
			add_action( 'init', array( &$this, 'setup' ), 10 );
			add_action( 'themify_builder_metabox', array( &$this, 'add_builder_metabox' ), 10 );
			add_action( 'admin_enqueue_scripts', array( &$this, 'load_admin_js_css' ), 10 );
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_front_js_css' ), 10 );

			// Ajax Actions
			add_action( 'wp_ajax_tfb_add_element', array( &$this, 'add_element_ajaxify' ), 10 );
			add_action( 'wp_ajax_tfb_lightbox_options', array( &$this, 'module_lightbox_options_ajaxify' ), 10 );
			add_action( 'wp_ajax_tfb_add_wp_editor', array( &$this, 'add_wp_editor_ajaxify' ), 10 );

			// Builder Save Data
			add_action( 'wp_ajax_tfb_save_data', array( &$this, 'save_data_builder' ), 10 );

			// Duplicate page / post action
			add_action( 'wp_ajax_tfb_duplicate_page', array( &$this, 'duplicate_page_ajaxify' ), 10 );

			// Hook to frontend
			add_action( 'wp_head', array( &$this, 'load_inline_js_script' ), 10 );
			add_filter( 'the_content', array( &$this, 'builder_show_on_front' ), 11 );
			add_action( 'wp_ajax_tfb_toggle_frontend', array( &$this, 'load_toggle_frontend_ajaxify' ), 10 );
			add_action( 'wp_ajax_tfb_load_module_partial', array( &$this, 'load_module_partial_ajaxify' ), 10 );
			add_filter( 'body_class', array( &$this, 'body_class'), 10 );
			add_filter( 'themify_builder_tmpl_shortcode', array( &$this, 'builder_tmpl_shortcode_page_init' ), 10 );

			// Shortcode
			add_shortcode( 'themify_builder_render_content', array( &$this, 'do_shortcode_builder_render_content' ) );
			
			// Plupload Action
			add_action( 'admin_head', array( &$this, 'plupload_admin_head' ), 10 );
			add_action( 'wp_head', array( &$this, 'plupload_front_head' ), 10 );

			add_action( 'wp_ajax_themify_builder_plupload_action', array( &$this, 'builder_plupload' ), 10 );

			add_action( 'wp_before_admin_bar_render', array( &$this, 'builder_admin_bar_menu'), 1000 );

			// Frontend editor
			add_action( 'themify_builder_edit_module_panel', array( &$this, 'module_edit_panel_front'), 10, 2 );

			// Switch to frontend
			add_action( 'save_post', array( &$this, 'switch_frontend' ), 999, 1 );

			// Flush permalink
			add_action( 'after_switch_theme', array( &$this, 'rewrite_flush' ), 10 );

			// Reset Builder Filter
			add_action( 'themify_builder_before_template_content_render', array( &$this, 'do_reset_before_template_content_render' ) );
			add_action( 'themify_builder_after_template_content_render', array( &$this, 'do_reset_after_template_content_render' ) );

			// Wordpress Search
			add_filter( 'posts_where', array( &$this, 'do_search' ) );
		}

		/**
		 * Check whether builder is active or not
		 * @return bool
		 */
		function builder_check() {
			$enable_builder = apply_filters( 'themify_enable_builder', themify_get('setting-page_builder_is_active') );
			if ( $enable_builder == 'disable'){
				return false;
			} else {
				return true;
			}
		}

		/**
		 * Init function
		 */
		function setup() {
			// Define builder path
			$this->builder_settings = array(
				'template_url' => 'themify-builder/',
				'builder_path' => THEMIFY_BUILDER_TEMPLATES_DIR .'/'
			);

			// Define meta key name
			$this->meta_key = apply_filters( 'themify_builder_meta_key', '_themify_builder_settings' );
			$this->meta_key_transient = apply_filters( 'themify_builder_meta_key_transient', 'themify_builder_settings_transient' );

			// Check whether grid edit active
			$this->is_front_builder_activate();

			// Template variables
			require_once( THEMIFY_BUILDER_INCLUDES_DIR . '/themify-builder-template-vars.php' );
		}

		/**
		 * Include required files
		 */
		function includes() {
			include( THEMIFY_BUILDER_CLASSES_DIR . '/class-builder-duplicate-page.php' ); // Class duplicate page
		}

		/**
		 * Builder write panels
		 */
		function builder_write_panels( $meta_boxes ) {
			// Page builder Options
			$page_builder_options = apply_filters( 'themify_builder_write_panels_options', array(
				// Feature Image
				array(
						'name' 		=> 'page_builder',	
						'title' 		=> __( 'Themify Builder', 'themify' ),
						'description' => '',
						'type' 		=> 'page_builder',			
						'meta'		=> array()			
					),
				array(
					'name' 		=> 'builder_switch_frontend',	
					'title' 		=> false, 
					'type' 		=> 'textbox',
					'value'		=> 0,			
					'meta'		=> array( 'size' => 'small' )
				)
			) );
			
			$types = themify_post_types();
			$all_meta_boxes = array();
			foreach ($types as $type) {
				$all_meta_boxes[] = apply_filters( 'themify_builder_write_panels_meta_boxes', array(
					'name'		=> __( 'Themify Builder', 'themify' ),
					'id' 		=> 'page-builder',
					'options'	=> $page_builder_options,
					'pages'    	=> $type
				) );
			}

			return array_merge( $meta_boxes, $all_meta_boxes);
		}

		/**
		 * Load general metabox fields
		 */
		function load_general_metabox() {
			// Feature Image
			$this->post_image = apply_filters( 'themify_builder_metabox_post_image', array(
				'name' 		=> 'post_image',	
				'title' 	=> __('Featured Image', 'themify'),
				'description' => '', 				
				'type' 		=> 'image',			
				'meta'		=> array()
			) );
			// Featured Image Size
			$this->featured_image_size = apply_filters( 'themify_builder_metabox_featured_image_size', array(
				'name'	=>	'feature_size',
				'title'	=>	__('Image Size', 'themify'),
				'description' => __('Image sizes can be set at <a href="options-media.php">Media Settings</a> and <a href="admin.php?page=regenerate-thumbnails">Regenerated</a>', 'themify'),
				'type'		 =>	'featimgdropdown'
			) );
			// Image Width
			$this->image_width = apply_filters( 'themify_builder_metabox_image_width', array(
				'name' 		=> 'image_width',
				'title' 	=> __('Image Width', 'themify'),
				'description' => '',			
				'type' 		=> 'textbox',
				'meta'		=> array('size'=>'small')
			) );
			// Image Height
			$this->image_height = apply_filters( 'themify_builder_metabox_image_height', array(
				'name' 		=> 'image_height',
				'title' 		=> __('Image Height', 'themify'),
				'description' => '',
				'type' 		=> 'textbox',
				'meta'		=> array('size'=>'small')
			) );
			// External Link
			$this->external_link = apply_filters( 'themify_builder_metabox_external_link', array(
				'name' 		=> 'external_link',
				'title' 	=> __('External Link', 'themify'),
				'description' => __('Link Featured Image to external URL', 'themify'),
				'type' 		=> 'textbox',
				'meta'		=> array()
			) );
			// Lightbox Link
			$this->lightbox_link = apply_filters( 'themify_builder_metabox_lightbox_link', array(
				'name' 		=> 'lightbox_link',
				'title' 	=> __('Lightbox Link', 'themify'),
				'description' => __('Link Featured Image to lightbox image, video or external iframe', 'themify'),
				'type' 		=> 'textbox',
				'meta'		=> array()
			) );
		}

		/**
		 * Load builder modules
		 */
		function load_modules() {
			// load modules
			$active_modules = $this->get_modules( 'active' );

			foreach ( $active_modules as $m ) {
				$path = $m['dirname'] . '/' . $m['basename'];
				require_once( $path );
			}
		}

		/**
		 * Get module php files data
		 * @param string $select
		 * @return array
		 */
		function get_modules( $select = 'all' ) {
			$files = array();
			$file_names = apply_filters( 'themify_builder_modules_list', array(
					'accordion',
					'box',
					'callout',
					'divider',
					'gallery',
					'highlight',
					'image',
					'map',
					'menu',
					'portfolio',
					'post',
					'slider',
					'tab',
					'testimonial',
					'text',
					'video',
					'widget',
					'widgetized'
				)
			);
			foreach( $file_names as $file_name ) {
				$tmp = THEMIFY_BUILDER_MODULES_DIR . '/module-'.$file_name.'.php';
				
				if( file_exists( $tmp ) )
					$files[$file_name] = $tmp;
			}
			$modules = array();
			if ( count( $files ) > 0 ) {
				foreach ( $files as $key => $value ) {
					$path_info = pathinfo( $value );
					$name = explode( '-', $path_info['filename'] );
					$name = $name[1];
					$modules[ $name ] = array(
						'name' => $name,
						'dirname' => $path_info['dirname'],
						'extension' => $path_info['extension'],
						'basename' => $path_info['basename'],
					);
				}
			}

			if ( $select == 'active' ) {
				$pre = 'setting-page_builder_';
				$data = themify_get_data();
				if ( count( $modules ) > 0 ) {
					foreach ( $modules as $key => $m ) {
						$exclude = $pre . 'exc_' . $m['name'];
						if( isset( $data[ $exclude ] ) )
							unset( $modules[ $m['name'] ] );
					}
				}
			}

			return $modules;
		}

		/**
		 * Check whether module is active
		 * @param $name
		 * @return boolean
		 */
		function check_module_active( $name ) {
			$actives = $this->get_modules( 'active' );
			if ( array_key_exists( $name, $actives ) ) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Check if builder frontend edit being invoked
		 */
		function is_front_builder_activate() {
			if( isset( $_POST['builder_grid_activate'] ) && $_POST['builder_grid_activate'] == 1 )
				$this->frontedit_active = true;
		}

		/**
		 * Add builder metabox
		 */
		function add_builder_metabox() {
			global $post, $pagenow;

			$builder_data = get_post_meta( $post->ID, $this->meta_key, true );
			$builder_data = stripslashes_deep( maybe_unserialize( $builder_data ) );

			if ( empty( $builder_data ) ) {
				$builder_data = array();
			}

			include THEMIFY_BUILDER_INCLUDES_DIR . '/themify-builder-meta.php';
		}

		/**
		 * Load admin js and css
		 * @param $hook
		 */
		function load_admin_js_css( $hook ) {
			global $version, $pagenow, $current_screen;

			if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && in_array( get_post_type(), themify_post_types() ) ) {

				wp_enqueue_style( 'themify-builder-main', THEMIFY_BUILDER_URI . '/css/themify-builder-main.css', array(), $version );
				wp_enqueue_style( 'themify-builder-admin-ui', THEMIFY_BUILDER_URI . '/css/themify-builder-admin-ui.css', array(), $version );
				if(is_rtl()) {
					wp_enqueue_style( 'themify-builder-admin-ui-rtl', THEMIFY_BUILDER_URI . '/css/themify-builder-admin-ui-rtl.css', array('themify-builder-admin-ui'), $version );
				}
				
				//Enqueue jquery ui script
				wp_enqueue_script( 'jquery-ui-accordion' );
				wp_enqueue_script( 'jquery-ui-droppable' );
				wp_enqueue_script( 'jquery-ui-sortable' );

				wp_register_script( 'themify-builder-admin-ui-js', THEMIFY_BUILDER_URI . "/js/themify.builder.admin.ui.js", array('jquery'), $version, true );
				wp_enqueue_script( 'themify-builder-plugins-js' );
				wp_enqueue_script( 'themify-builder-admin-ui-js' );

				wp_localize_script( 'themify-builder-admin-ui-js', 'themifyBuilder', apply_filters( 'themify_builder_ajax_admin_vars', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'tfb_load_nonce' => wp_create_nonce( 'tfb_load_nonce' ),
					'tfb_url' => THEMIFY_BUILDER_URI,
					'dropPlaceHolder' => __( 'drop module here', 'themify' ),
					'newRowTemplate' => $this->template_vars['rows']['content'],
					'draggerTitleMiddle' => __( 'Drag left/right to change columns', 'themify' ),
					'draggerTitleLast' => __( 'Drag left to add columns', 'themify' ),
					'confirm_on_duplicate_page' => __('Save the Builder before duplicating this page?', 'themify')
				)) );
			}
		}

		/**
		 * Load inline js script
		 * Frontend editor
		 */
		function load_inline_js_script() {
			global $post;
			if ( $this->is_frontend_editor_page() ) {
			?>
			<script type="text/javascript">
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>',
					isRtl = <?php echo (int) is_rtl(); ?>;
			</script>
			<?php
			}
		}

		/**
		 * Load frontend js and css
		 */
		function load_front_js_css() {
			global $version, $post;

			wp_enqueue_style( 'themify-builder-style', THEMIFY_BUILDER_URI . '/css/themify-builder-style.css', array(), $version );

			// load only when editing and login
			if ( $this->is_frontend_editor_page() ) {
				wp_enqueue_style( 'themify-builder-main', THEMIFY_BUILDER_URI . '/css/themify-builder-main.css', array(), $version );
				wp_enqueue_style( 'themify-builder-admin-ui', THEMIFY_BUILDER_URI . '/css/themify-builder-admin-ui.css', array(), $version );
				wp_enqueue_style( 'colorpicker', THEMIFY_URI . '/css/jquery.minicolors.css' ); // from themify framework
			}
			
			// lib scripts
			if ( ! wp_script_is( 'themify-carousel-js' ) ) {
				wp_enqueue_script( 'themify-carousel-js', THEMIFY_URI . '/js/carousel.js', array('jquery') ); // grab from themify framework
			}

			// module scripts
			wp_register_script( 'themify-builder-module-plugins-js', THEMIFY_BUILDER_URI . "/js/themify.builder.module.plugins.js", array( 'jquery' ), $version, true );
			wp_enqueue_script( 'themify-builder-module-plugins-js' );

			wp_register_script( 'themify-builder-script-js', THEMIFY_BUILDER_URI . "/js/themify.builder.script.js", array( 'jquery' ), $version, true );
			wp_enqueue_script( 'themify-builder-script-js' );
			
			if ( $this->is_frontend_editor_page() ) {

				// load module panel frontend
				add_action( 'wp_footer', array( &$this, 'builder_module_panel_frontedit' ), 10 );
				
				if( function_exists( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				}
				$enqueue_scripts = array(
					'jquery-ui-core',
					'jquery-ui-accordion', 
					'jquery-ui-droppable', 
					'jquery-ui-sortable', 
					'jquery-ui-resizable',
					'media-upload',
					'jquery-ui-dialog',
					'wpdialogs',
					'wpdialogs-popup',
					'wplink',
					'editor',
					'quicktags',
					'admin-widgets',
					'colorpicker-js',
					'themify-builder-front-ui-js'
				);

				// is mobile version
				if( $this->isMobile() ) {
					wp_register_script( 'themify-builder-mobile-ui-js', THEMIFY_BUILDER_URI . "/js/jquery.ui.touch-punch.js", array( 'jquery' ), $version, true );
					wp_enqueue_script( 'jquery-ui-mouse' );
					wp_enqueue_script( 'themify-builder-mobile-ui-js' );
				}

				foreach ( $enqueue_scripts as $script ) {
					switch ( $script ) {
						case 'admin-widgets':
							wp_enqueue_script( $script, admin_url( '/js/widgets.min.js' ) ,array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable' ) );
						break;

						case 'colorpicker-js':
							wp_enqueue_script( $script, THEMIFY_URI . '/js/jquery.minicolors.js', array('jquery') ); // grab from themify framework
						break;

						case 'themify-builder-front-ui-js':
							// front ui js
							wp_register_script( $script, THEMIFY_BUILDER_URI . "/js/themify.builder.front.ui.js", array('jquery'), $version, true );
							wp_enqueue_script( $script );

							wp_localize_script( $script, 'themifyBuilder', apply_filters( 'themify_builder_ajax_front_vars', array(
								'ajaxurl' => admin_url( 'admin-ajax.php' ),
								'tfb_load_nonce' => wp_create_nonce( 'tfb_load_nonce' ),
								'tfb_url' => THEMIFY_BUILDER_URI,
								'post_ID' => $post->ID,
								'dropPlaceHolder' => __('drop module here', 'themify'),
								'newRowTemplate' => $this->template_vars['rows']['content'],
								'draggerTitleMiddle' => __('Drag left/right to change columns','themify'),
								'draggerTitleLast' => __('Drag left to add columns','themify'),
								'moduleDeleteConfirm' => __('Press OK to remove this module','themify'),
								'toggleOn' => __('Turn On Builder', 'themify'),
								'toggleOff' => __('Turn Off Builder', 'themify'),
								'confirm_on_turn_off' => __('Do you want to save the changes made to this page?', 'themify'),
								'confirm_on_duplicate_page' => __('Save the Builder before duplicating this page?', 'themify'),
								'confirm_on_unload' => __('You have unsaved data.', 'themify')
							)) );
						break;
						
						default:
							wp_enqueue_script( $script );
						break;
					}	
				}

			}
		}

		/**
		 * Add element via ajax
		 * Drag / drop / add + button
		 */
		function add_element_ajaxify() {
			
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$template_name = $_POST['tfb_template_name'];
			
			if( $template_name == 'module' ) {
				$module_name = $_POST['tfb_module_name'];
				echo stripslashes( $this->template_vars[ $template_name ][ $module_name ]['content'] );
			} elseif( $template_name == 'module_front' ) {
				$mod = array( 'mod_name' => $_POST['tfb_module_name'] );
				$this->get_template_module( $mod );
			} else{
				echo stripslashes( $this->template_vars[ $template_name ]['content'] );
			}
			
			die();
		}

		/**
		 * Module settings modal lightbox
		 */
		function module_lightbox_options_ajaxify() {
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$module_name = $_POST['tfb_module_name'];

			require_once( THEMIFY_BUILDER_INCLUDES_DIR . '/themify-builder-options.php' );
			
			die();
		}

		/**
		 * Duplicate page
		 */
		function duplicate_page_ajaxify() {
			global $themifyBuilderDuplicate;
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$post = get_post( $_POST['tfb_post_id'] );
			$themifyBuilderDuplicate->edit_link = $_POST['tfb_is_admin'];
			$themifyBuilderDuplicate->duplicate( $post );
			$response['status'] = 'success';
			$response['new_url'] = $themifyBuilderDuplicate->new_url;
			echo json_encode( $response );
			die();
		}

		/**
		 * Add wp editor element
		 */
		function add_wp_editor_ajaxify() {
			
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$txt_id = $_POST['txt_id'];
			$class = $_POST['txt_class'];
			$txt_name = $_POST['txt_name'];
			$txt_val = stripslashes_deep( $_POST['txt_val'] );
			wp_editor( $txt_val, $txt_id, array('textarea_name' => $txt_name, 'editor_class' => $class, 'textarea_rows' => 20) );
			
			die();
		}

		/**
		 * Load Editable builder grid
		 */
		function load_toggle_frontend_ajaxify() {
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$response = array();
			$post_ids = $_POST['tfb_post_ids'];
			global $post;

			$this->builder_update_shortcode_action(); // fix shortcode issue output as text string
			
			foreach( $post_ids as $k => $id ) {
				$post = get_post( $id );
				setup_postdata( $post );
				
				$builder_data = get_post_meta( $post->ID, $this->meta_key, true );
				$builder_data = stripslashes_deep( maybe_unserialize( $builder_data ) );

				if ( ! is_array( $builder_data ) ) {
					$builder_data = array();
				}

				$response[$k]['builder_id'] = $post->ID;
				$response[$k]['markup'] = $this->retrieve_template( 'builder-output.php', array( 'builder_output' => $builder_data, 'builder_id' => $post->ID ), '', '', false );
			} wp_reset_postdata();

			echo json_encode( $response );

			die();
		}

		/**
		 * Load module partial when update live content
		 */
		function load_module_partial_ajaxify() {
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);
			global $post;
			
			$post_id = $_POST['tfb_post_id'];
			$w_class = $_POST['tfb_w_class'];
			$selector = $_POST['tfb_mod_selector'];
			$mod = array();
			$identifier = array();

			$this->builder_update_shortcode_action(); // fix shortcode issue output as text string

			$post = get_post( $post_id );
			setup_postdata( $post );

			$transient = $this->meta_key_transient . '_' . $post_id;
			$builder_data = get_transient( $transient );

			if ( $builder_data !== false ) {
				$builder_data = stripslashes_deep( maybe_unserialize( $builder_data ) );
				$mod = $builder_data[ $selector['row'] ]['cols'][ $selector['col'] ]['modules'][ $selector['mod'] ];
				$identifier = array( $selector['row'], $selector['col'], $selector['mod'] );
			}

			$this->get_template_module( $mod, true, true, $w_class, $identifier );

			wp_reset_postdata();

			die();
		}

		/**
		 * Save builder main data
		 */
		function save_data_builder() {
			if ( ! wp_verify_nonce( $_POST['tfb_load_nonce'], 'tfb_load_nonce' ) ) die(-1);

			$post_data = array();
			if( count( $_POST['post_data'] ) > 0 ) {
				$post_data = $_POST['post_data'];
			}
			$saveto = $_POST['tfb_saveto'];
			$tfb_post_id = (int) $_POST['tfb_post_id'];
			
			if ( $saveto == 'main' ) {
				update_post_meta( $tfb_post_id, $this->meta_key, $post_data );
				do_action( 'themify_builder_save_data', $tfb_post_id, $this->meta_key, $post_data ); // hook save data
			} else {
				$transient = $this->meta_key_transient . '_' . $tfb_post_id;
				set_transient( $transient, $post_data, 60*60 );
			}
			
			die();
		}

		/**
		 * Hook to content filter to show builder output
		 * @param $content
		 * @return string
		 */
		function builder_show_on_front( $content ) {
			global $post, $wp_query;
			if ( ( is_post_type_archive() && ! is_post_type_archive( 'product' ) ) || post_password_required() || isset( $wp_query->query_vars['product_cat'] ) ) return $content;

			if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 && $this->builder_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post = get_post( woocommerce_get_page_id( 'shop' ) );
			}
			
			$builder_data = get_post_meta( $post->ID, $this->meta_key, true );
			$builder_data = stripslashes_deep( maybe_unserialize( $builder_data ) );

			if ( ! is_array( $builder_data ) || strpos( $content, '#more-' ) ) {
				$builder_data = array();
			}

			$content .= $this->retrieve_template( 'builder-output.php', array( 'builder_output' => $builder_data, 'builder_id' => $post->ID ), '', '', false );
			return $content;
		}

		/**
		 * Display module panel on frontend edit
		 */
		function builder_module_panel_frontedit() {
			include_once THEMIFY_BUILDER_INCLUDES_DIR . '/themify-builder-module-panel.php';
		}

		/**
		 * Get initialization parameters for plupload. Filtered through themify_builder_plupload_init_vars.
		 * @return mixed|void
		 * @since 1.4.2
		 */
		function get_builder_plupload_init() {
			return apply_filters('themify_builder_plupload_init_vars', array(
				'runtimes'				=> 'html5,flash,silverlight,html4',
				'browse_button'			=> 'themify-builder-plupload-browse-button', // adjusted by uploader
				'container' 			=> 'themify-builder-plupload-upload-ui', // adjusted by uploader
				'drop_element' 			=> 'drag-drop-area', // adjusted by uploader
				'file_data_name' 		=> 'async-upload', // adjusted by uploader
				'multiple_queues' 		=> true,
				'max_file_size' 		=> wp_max_upload_size() . 'b',
				'url' 					=> admin_url('admin-ajax.php'),
				'flash_swf_url' 		=> includes_url('js/plupload/plupload.flash.swf'),
				'silverlight_xap_url' 	=> includes_url('js/plupload/plupload.silverlight.xap'),
				'filters' 				=> array( array(
					'title' => __('Allowed Files', 'themify'),
					'extensions' => 'jpg,jpeg,gif,png'
				)),
				'multipart' 			=> true,
				'urlstream_upload' 		=> true,
				'multi_selection' 		=> false, // added by uploader
				 // additional post data to send to our ajax hook
				'multipart_params' 		=> array(
					'_ajax_nonce' 		=> '', // added by uploader
					'action' 			=> 'themify_builder_plupload_action', // the ajax action name
					'imgid' 			=> 0 // added by uploader
				)
			));
		}

		/**
		 * Inject plupload initialization variables in Javascript
		 * @since 1.4.2
		 */
		function plupload_front_head() {
			$plupload_init = $this->get_builder_plupload_init();
			wp_localize_script( 'themify-builder-front-ui-js', 'themify_builder_plupload_init', $plupload_init );
		}

		/**
		 * Plupload initialization parameters
		 * @since 1.4.2
		 */
		function plupload_admin_head() {
			$plupload_init = $this->get_builder_plupload_init();
			wp_localize_script( 'themify-builder-admin-ui-js', 'themify_builder_plupload_init', $plupload_init );
		}

		/**
		 * Plupload ajax action
		 */
		function builder_plupload() {
			$imgid = $_POST['imgid'];
			
			/** If post ID is set, uploaded image will be attached to it. @var String */
			$postid = $_POST['topost'];

			/** Handle file upload storing file|url|type. @var Array */
			$file = wp_handle_upload( $_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'themify_builder_plupload_action') );
			
			//let's see if it's an image, a zip file or something else
			$ext = explode( '/', $file['type'] );

			// Insert into Media Library
			// Set up options array to add this file as an attachment
			$attachment = array(
				'post_mime_type' => sanitize_mime_type($file['type']),
				'post_title' => str_replace('-', ' ', sanitize_file_name(pathinfo($file['file'], PATHINFO_FILENAME))),
				'post_status' => 'inherit'
			);
			
			if( $postid ) 
				$attach_id = wp_insert_attachment( $attachment, $file['file'], $postid );

			// Common attachment procedures
			require_once( ABSPATH . 'wp-admin' . '/includes/image.php' );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			if( $postid ) {		
				$large = wp_get_attachment_image_src( $attach_id, 'large');		
				$thumb = wp_get_attachment_image_src( $attach_id, 'thumbnail' );
				
				//Return URL for the image field in meta box
				$file['large_url'] = $large[0];
				$file['thumb'] = $thumb[0];
			}

			$file['type'] = $ext[1];
			// send the uploaded file url in response
			echo json_encode( $file );
			exit;
		}

		/**
		 * Display Toggle themify builder
		 * wp admin bar
		 */
		function builder_admin_bar_menu() {
			global $wp_admin_bar, $wpdb, $post, $wp_query;

			if ( ( is_post_type_archive() && ! is_post_type_archive( 'product' ) ) || !is_admin_bar_showing() || is_admin() || !current_user_can( 'edit_page', $post->ID ) || isset( $wp_query->query_vars['product_cat'] ) ) return;

			/* Add the main siteadmin menu item */
			$wp_admin_bar->add_menu( array( 
					'id' => 'themify_builder', 
					'title' => sprintf('<span class="themify_builder_front_icon"></span> %s', __('Themify Builder','themify')), 
					'href' => '#'
				)
			);

			$wp_admin_bar->add_menu( array( 
					'id' => 'toggle_themify_builder', 
					'parent' => 'themify_builder', 
					'title' => __( 'Turn On Builder', 'themify' ), 
					'href' => '#',
					'meta' => array(
						'class' => 'toggle_tf_builder'
					) 
				)
			);
			$wp_admin_bar->add_menu( array( 
				'id' => 'duplicate_themify_builder', 
				'parent' => 'themify_builder',
				'title' => __( 'Duplicate This Page', 'themify' ), 
				'href' => '#', 
				'meta' => array(
					'class' => 'themify_builder_dup_link'
					) 
				) 
			);
			$wp_admin_bar->add_menu( array( 
				'id' => 'help_themify_builder', 
				'parent' => 'themify_builder', 
				'title' => __( 'Help', 'themify' ), 
				'href' => 'http://themify.me/docs/builder',
				'meta' => array(
					'target' => '_blank',
					'class' => ''
					) 
				) 
			);
		}

		/**
		 * Switch to frontend
		 * @param int $post_id
		 */
		function switch_frontend( $post_id ) {
			//verify post is not a revision
			if ( ! wp_is_post_revision( $post_id ) ) {
				$redirect = isset( $_POST['builder_switch_frontend'] ) ? $_POST['builder_switch_frontend'] : 0;

				// redirect to frontend
				if( 1 == $redirect ) {
					$_POST['builder_switch_frontend'] = 0;
					$post_url = get_permalink( $post_id );
					wp_redirect( themify_https_esc( $post_url ) . '#builder_active' );
					exit;
				}
			}
		}

		/**
		 * Editing module panel in frontend
		 * @param $mod_name
		 * @param $mod_settings
		 */
		function module_edit_panel_front( $mod_name, $mod_settings ) {
			?>
			<div class="module_menu_front">
				<ul class="themify_builder_dropdown_front">
					<li><a href="#" title="<?php _e('Edit', 'themify') ?>" class="themify_module_options" data-module-name="<?php echo $mod_name; ?>"><?php _e('Edit', 'themify') ?></a></li>
					<li><a href="#" title="<?php _e('Duplicate', 'themify') ?>" class="themify_module_duplicate"><?php _e('Duplicate', 'themify') ?></a></li>
					<li><a href="#" title="<?php _e('Delete', 'themify') ?>" class="themify_module_delete"><?php _e('Delete', 'themify') ?></a></li>
				</ul>
				<?php
					$mod_settings = $this->return_text_shortcode( $mod_settings );
					$mod_settings = json_encode( $mod_settings );
				?>
				<div class="front_mod_settings mod_settings_<?php echo $mod_name; ?>" data-settings="<?php echo esc_attr( $mod_settings ); ?>"></div>
			</div>
			<div class="themify_builder_data_mod_name" style="display:none;"><?php echo $mod_name; ?></div>
			<?php
		}

		/**
		 * Check is frontend editor page
		 */
		function is_frontend_editor_page() {
			global $post;
			if ( is_user_logged_in() && current_user_can( 'edit_page', $post->ID ) ) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Add Builder body class
		 * @param $classes
		 * @return mixed|void
		 */
		function body_class( $classes ) {
			if ( $this->is_frontend_editor_page() ) 
				$classes[] = 'frontend';

			// return the $classes array
			return apply_filters( 'themify_builder_body_class', $classes );
		}

		/**
		 * Just print the shortcode text instead of output html
		 * @param array $array
		 * @return array
		 */
		function return_text_shortcode( $array ) {
			if ( count( $array ) > 0 ) {
				foreach ( $array as $key => $value ) {
					if( is_array( $value ) ) {
						$this->return_text_shortcode( $value );
					} else {
						$array[ $key ] = str_replace( "[", "&#91;", $value );
						$array[ $key ] = str_replace( "]", "&#93;", $value ); 
					}
				}
			} else {
				$array = array();
			}
			return $array;
		}

		/**
		 * Retrieve builder templates
		 * @param $template_name
		 * @param array $args
		 * @param string $template_path
		 * @param string $default_path
		 * @param bool $echo
		 * @return string
		 */
		function retrieve_template( $template_name, $args = array(), $template_path = '', $default_path = '', $echo = true ) {
			ob_start();
			$this->get_template( $template_name, $args, $template_path = '', $default_path = '' );
			if ( $echo )
				echo ob_get_clean();
			else
				return ob_get_clean();
		}

		/**
		 * Get template builder
		 * @param $template_name
		 * @param array $args
		 * @param string $template_path
		 * @param string $default_path
		 */
		function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
			if ( $args && is_array( $args ) )
				extract( $args );

			$located = $this->locate_template( $template_name, $template_path, $default_path );

			include( $located );
		}

		/**
		 * Locate a template and return the path for inclusion.
		 *
		 * This is the load order:
		 *
		 *		yourtheme		/	$template_path	/	$template_name
		 *		$default_path	/	$template_name
		 */
		function locate_template( $template_name, $template_path = '', $default_path = '' ) {
			if ( ! $template_path ) $template_path = $this->builder_settings['template_url'];
			if ( ! $default_path ) $default_path = $this->builder_settings['builder_path'];

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name
				)
			);

			// Get default template
			if ( ! $template )
				$template = $default_path . $template_name;

			// Return what we found
			return apply_filters('themify_builder_locate_template', $template, $template_name, $template_path);
		}

		/**
		 * Get template for module
		 * @param $mod
		 * @param bool $echo
		 * @param bool $wrap
		 * @param null $class
		 * @param array $identifier
		 * @return bool|string
		 */
		function get_template_module( $mod, $echo = true, $wrap = true, $class = null, $identifier = array() ) {
			$output = '';
			$mod_id = $mod['mod_name'] . '-' . implode( '-', $identifier );
			$output .= PHP_EOL; // add line break

			// check whether module active or not
			if ( ! $this->check_module_active( $mod['mod_name'] ) ) 
				return false;

			if ( $wrap ) {
				ob_start(); ?>
				<div class="themify_builder_module_front clearfix module-<?php echo $mod['mod_name']; ?> active_module <?php echo $class; ?>" data-module-name="<?php echo $mod['mod_name']; ?>">
				<div class="themify_builder_module_front_overlay"></div>
				<?php themify_builder_edit_module_panel( $mod['mod_name'], $mod['mod_settings'] ); ?>
				<?php
				$output .= ob_get_clean();
			}
			$output .= $this->retrieve_template( 'template-'.$mod['mod_name'].'.php', array(
				'module_ID' => $mod_id,
				'mod_name' => $mod['mod_name'],
				'mod_settings' => ( isset( $mod['mod_settings'] ) ? $mod['mod_settings'] : '' )
			),'', '', false );

			if ( $wrap ) 
				$output .= '</div>';

			// add line break
			$output .= PHP_EOL;

			if ( $echo ) {
				echo $output;
			} else {
				return $output;
			}
		}

		/**
		 * Check whether theme loop template exist
		 * @param string $template_name 
		 * @param string $template_path 
		 * @return boolean
		 */
		function is_loop_template_exist($template_name, $template_path) {
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name
				)
			);

			if ( ! $template ) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * Get module excerpt
		 * @param array $module
		 */
		function get_module_excerpt( $module ) {
			switch ( $module['mod_name'] ) {
				case 'text':
					$return = $this->split_words( $module['mod_settings']['content_text'], 100, '' );
					break;
				
				default:
					# code...
					$return = '';
					break;
			}

			return $return;
		}

		/**
		 * Split words function
		 * @param string $string
		 * @param int $nb_caracs
		 * @param string $separator
		 */
		function split_words( $string, $nb_caracs, $separator ) {
			$string = strip_tags( html_entity_decode( $string ) );
			if( strlen( $string ) <= $nb_caracs ) {
				$final_string = $string;
			} else {
				$final_string = "";
				$words = explode( " ", $string );
				foreach ( $words as $value ) {
					if( strlen( $final_string . " " . $value ) < $nb_caracs ) {
						if( ! empty( $final_string ) ) $final_string .= " ";
						$final_string .= $value;
					} else {
						break;
					}
				}
				$final_string .= $separator;
			}
			return $final_string;
		}

		/**
		 * Get checkbox data
		 * @param $setting
		 * @return string
		 */
		function get_checkbox_data( $setting ) {
			return implode( ' ', explode( '|', $setting ) );
		}

		/**
		 * Return only value setting
		 * @param $string 
		 * @return string
		 */
		function get_param_value( $string ) {
			$val = explode( '|', $string );
			return $val[0];
		}

		/**
		 * Get custom menus
		 * @param int $term_id
		 */
		function get_custom_menus( $term_id ) {
			$menu_list = '';
			ob_start();
			wp_nav_menu( array( 'menu' => $term_id ) );
			$menu_list .= ob_get_clean();

			return $menu_list;
		}

		/**
		 * Rewrite permalink for custom post type
		 */
		function rewrite_flush() {
			flush_rewrite_rules();
		}

		/**
		 * Display an additional column in categories list
		 * @since 1.1.8
		 */
		function taxonomy_header( $cat_columns ) {
			$cat_columns['cat_id'] = 'ID';
			return $cat_columns;
		}

		/**
		 * Display ID in additional column in categories list
		 * @since 1.1.8
		 */
		function taxonomy_column_id( $null, $column, $termid ){
			return $termid;
		}

		/**
		 * Includes this custom post to array of cpts managed by Themify
		 * @param Array
		 * @return Array
		 */
		function extend_post_types( $types ) {
			return array_merge( $types, $this->registered_post_types );
		}

		/**
		 * Push the registered post types to object class
		 * @param $type
		 */
		function push_post_types( $type ) {
			array_push( $this->registered_post_types, $type );
		}

		/**
		 * Detect mobile browser
		 */
		function isMobile() {
			return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
		}

		/**
		 * Get images from gallery shortcode
		 * @return object
		 */
		function get_images_from_gallery_shortcode( $shortcode ) {
			preg_match( '/\[gallery.*ids=.(.*).\]/', $shortcode, $ids );
			$image_ids = explode( ",", $ids[1] );
			$orderby = $this->get_gallery_param_option( $shortcode, 'orderby' );
			$orderby = $orderby != '' ? $orderby : 'post__in';
			$order = $this->get_gallery_param_option( $shortcode, 'order' );
			$order = $order != '' ? $order : 'ASC';

			// Check if post has more than one image in gallery
			return get_posts( array(
				'post__in' => $image_ids,
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'numberposts' => -1,
				'orderby' => $orderby,
				'order' => $order
			) );
		}

		/**
		 * Get gallery shortcode options
		 * @param $shortcode
		 * @param $param
		 */
		function get_gallery_param_option( $shortcode, $param = 'link' ) {
			if ( $param == 'link' ) {
				preg_match( '/\[gallery .*?(?=link)link=.([^\']+)./si', $shortcode, $out );
			} elseif ( $param == 'order' ) {
				preg_match( '/\[gallery .*?(?=order)order=.([^\']+)./si', $shortcode, $out );	
			} elseif ( $param == 'orderby' ) {
				preg_match( '/\[gallery .*?(?=orderby)orderby=.([^\']+)./si', $shortcode, $out );	
			} elseif ( $param == 'columns' ) {
				preg_match( '/\[gallery .*?(?=columns)columns=.([^\']+)./si', $shortcode, $out );	
			}
			
			$out = isset($out[1]) ? explode( '"', $out[1] ) : array('');
			return $out[0];
		}

		/**
		 * Reset builder query
		 * @param $action
		 */
		function reset_builder_query( $action = 'reset' ) {
			if ( $action == 'reset' ) {
				remove_filter( 'the_content', array( &$this, 'builder_show_on_front' ), 11 );
			} else if( $action == 'restore' ) {
				add_filter( 'the_content', array( &$this, 'builder_show_on_front' ), 11 );
			}
		}

		/**
		 * Check whether img.php is use or not
		 * @return boolean
		 */
		function is_img_php_disabled() {
			if ( themify_check( 'setting-img_settings_use' ) ) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Checks whether the url is an img link, youtube, vimeo or not.
		 * @param string $url
		 * @return bool
		 */
		function is_img_link( $url ) {
			$parsed_url = parse_url($url);
			$pathinfo = isset( $parsed_url['path'] ) ? pathinfo( $parsed_url['path'] ) : '';
			$extension = isset( $pathinfo['extension'] ) ? strtolower( $pathinfo['extension'] ) : '';

			$image_extensions = array('png', 'jpg', 'jpeg', 'gif');

			if ( in_array($extension, $image_extensions) || stripos('youtube', $url) || stripos('vimeo', $url) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Apply filter the content to all modules template content
		 * @param string $shortcode 
		 * @return string
		 */
		function builder_tmpl_shortcode_callback( $shortcode ) {
			$this->reset_builder_query();
			$return = apply_filters( 'the_content', $shortcode );
			$this->reset_builder_query( 'restore' );
			return $return;
		}

		/**
		 * Apply shortcode filter when initial loaded
		 */
		function builder_tmpl_shortcode_page_init( $shortcode ) {
			return do_shortcode( $shortcode );
		}

		/**
		 * Action for filter shortcode template
		 */
		function builder_update_shortcode_action() {
			add_filter( 'themify_builder_tmpl_shortcode', array( &$this, 'builder_tmpl_shortcode_callback' ), 10 );
		}

		/**
		 * Get query page
		 */
		function get_paged_query() {
			global $wp;
			$page = 1;
			$qpaged = get_query_var( 'paged' );
			if ( ! empty( $qpaged ) ) {
				$page = $qpaged;
			} else {
				$qpaged = wp_parse_args( $wp->matched_query );
				if ( isset( $qpaged['paged'] ) && $qpaged['paged'] > 0 ) {
					$page = $qpaged['paged'];
				}
			}
			return $page;
		}

		/**
		 * Returns page navigation
		 * @param string Markup to show before pagination links
		 * @param string Markup to show after pagination links
		 * @param object WordPress query object to use
		 * @return string
		 */
		function get_pagenav($before = '', $after = '', $query = false) {
			global $wpdb, $wp_query;
			
			if( false == $query ){
				$query = $wp_query;
			}
			$request = $query->request;
			$posts_per_page = intval(get_query_var('posts_per_page'));
			$paged = intval($this->get_paged_query());
			$numposts = $query->found_posts;
			$max_page = $query->max_num_pages;
		
			if(empty($paged) || $paged == 0) {
				$paged = 1;
			}
			$pages_to_show = apply_filters('themify_filter_pages_to_show', 5);
			$pages_to_show_minus_1 = $pages_to_show-1;
			$half_page_start = floor($pages_to_show_minus_1/2);
			$half_page_end = ceil($pages_to_show_minus_1/2);
			$start_page = $paged - $half_page_start;
			if($start_page <= 0) {
				$start_page = 1;
			}
			$end_page = $paged + $half_page_end;
			if(($end_page - $start_page) != $pages_to_show_minus_1) {
				$end_page = $start_page + $pages_to_show_minus_1;
			}
			if($end_page > $max_page) {
				$start_page = $max_page - $pages_to_show_minus_1;
				$end_page = $max_page;
			}
			if($start_page <= 0) {
				$start_page = 1;
			}
		
			if ($max_page > 1) {
				$out .=  $before.'<div class="pagenav clearfix">';
				if ($start_page >= 2 && $pages_to_show < $max_page) {
					$first_page_text = "&laquo;";
					$out .=  '<a href="'.get_pagenum_link().'" title="'.$first_page_text.'" class="number">'.$first_page_text.'</a>';
				}
				if($pages_to_show < $max_page)
					$out .= get_previous_posts_link('&lt;');
				for($i = $start_page; $i  <= $end_page; $i++) {
					if($i == $paged) {
						$out .=  ' <span class="number current">'.$i.'</span> ';
					} else {
						$out .=  ' <a href="'.get_pagenum_link($i).'" class="number">'.$i.'</a> ';
					}
				}
				if($pages_to_show < $max_page)
					$out .= get_next_posts_link('&gt;');
				if ($end_page < $max_page) {
					$last_page_text = "&raquo;";
					$out .=  '<a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'" class="number">'.$last_page_text.'</a>';
				}
				$out .=  '</div>'.$after;
			}
			return $out;
		}

		/**
		 * Reset builder filter before template content render
		 */
		function do_reset_before_template_content_render(){
			$this->reset_builder_query();
		}

		/**
		 * Reset builder filter after template content render
		 */
		function do_reset_after_template_content_render(){
			$this->reset_builder_query('restore');
		}

		/**
		 * Check is plugin active
		 */
		function builder_is_plugin_active($plugin) {
			return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		/**
		 * Include builder in search
		 * @param string $where 
		 * @return string
		 */
		function do_search($where){
			if( is_search() ) {
				global $wpdb;
				$query = get_search_query();
				$query = like_escape( $query );

				$where .=" OR {$wpdb->posts}.ID IN (SELECT {$wpdb->postmeta}.post_id FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_key = '{$this->meta_key}' AND {$wpdb->postmeta}.meta_value LIKE '%$query%' AND {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";
			}
			return $where;
		}

	}

} // class_exists check
?>