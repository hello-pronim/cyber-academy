<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/admin
 * @author     Security Team <info@ays-pro.com>
 */
class Secure_Copy_Content_Protection_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the styles for the admin menu area.
	 *
	 * @since    1.5.0
	 */
	public function admin_menu_styles() {
		echo "
        <style>
            #adminmenu a.toplevel_page_secure-copy-content-protection div.wp-menu-image img {
                padding: 0;
                opacity: .6;
                width: 32px;
                transition: all .3s ease-in;
            }

            #adminmenu a.toplevel_page_secure-copy-content-protection + ul.wp-submenu.wp-submenu-wrap li:last-child a {
                color: #e14d43;
            }
        </style>
        ";
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook_suffix ) {

		wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');
		wp_enqueue_style('sweetalert-css', '//cdn.jsdelivr.net/npm/sweetalert2@7.26.29/dist/sweetalert2.min.css', array(), $this->version, 'all');

		if (false === strpos($hook_suffix, $this->plugin_name)) {
			return;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('ays-sccp-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style('ays_code_mirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.css', array(), $this->version, 'all');
		wp_enqueue_style('copy_content_protection_bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'-jquery-datetimepicker', plugin_dir_url(__FILE__) . 'css/jquery-ui-timepicker-addon.css', array(), $this->version, 'all');
		//wp_enqueue_style('copy_content_protection_datatable', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', array(), $this->version, 'all');
		wp_enqueue_style('copy_content_protection_datatable_bootstrap', '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/secure-copy-content-protection-admin.css', array(), $this->version, 'all');
		wp_enqueue_style('ays_sccp_font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if (false !== strpos($hook_suffix, "plugins.php")){
			wp_enqueue_script('sweetalert-js', '//cdn.jsdelivr.net/npm/sweetalert2@7.26.29/dist/sweetalert2.all.min.js', array('jquery'), $this->version, true);
			wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, true);
			wp_localize_script($this->plugin_name . '-admin', 'sccp_admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		}

		if (false === strpos($hook_suffix, $this->plugin_name)) {
			return;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $wp_roles;
		$ays_users_roles = $wp_roles->roles;

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_media();
		wp_enqueue_script('wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array('wp-color-picker'), '2.1.3', true);
//        wp_enqueue_editor();
		wp_enqueue_script('ays_code_mirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('select2js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('cpy_content_protection_datatable', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('cpy_content_protection_datatable_bootstrap', '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('cpy_content_protection_popper', plugin_dir_url(__FILE__) . 'js/popper.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('cpy_content_protection_bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name."-jquery.datetimepicker.js", plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/secure-copy-content-protection-admin.js', array('jquery'), $this->version, true);
		wp_localize_script($this->plugin_name, 'sccp', array(
			'ajax'           	=> admin_url('admin-ajax.  '),
			'loader_message' 	=> __('Just a moment...', $this->plugin_name),
			'loader_url'     	=> SCCP_ADMIN_URL . '/images/rocket.svg',
			'bc_user_role'    	=> $ays_users_roles,
		));

	}

	function codemirror_enqueue_scripts($hook) {
		if (strpos($hook, $this->plugin_name) !== false) {
			if(function_exists('wp_enqueue_code_editor')){
	            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
	                'type' => 'text/css',
	                'codemirror' => array(
	                    'inputStyle' => 'contenteditable',
	                    'theme' => 'cobalt',
	                )
	            ));
	        
		        wp_localize_script('jquery', 'cm_settings', $cm_settings);
		       
		        wp_enqueue_script('wp-theme-plugin-editor');
	            wp_enqueue_style('wp-codemirror');
	            
	        }
		}
        
	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		add_menu_page('Copy Protection', 'Copy Protection', 'manage_options', $this->plugin_name, array(
			$this,
			'display_plugin_setup_page'
		), SCCP_ADMIN_URL . '/images/sccp.png', 6);		
		add_submenu_page( $this->plugin_name,
            __('Featured Plugins', $this->plugin_name),
            __('Featured Plugins', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_sccp_featured_plugins_page') 
        );
        add_submenu_page(
			$this->plugin_name,
			__('PRO Features', $this->plugin_name),
			__('PRO Features', $this->plugin_name),
			'manage_options',
			$this->plugin_name . '-pro-features',
			array($this, 'display_plugin_sccp_pro_features_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection" target="_blank" style="color:red;">' . __('BUY NOW', $this->plugin_name) . '</a>',
		);

		return array_merge($settings_link, $links);

	}

	public function display_plugin_setup_page() {
		require_once('partials/secure-copy-content-protection-admin-display.php');
	}	

	public function display_plugin_sccp_featured_plugins_page(){
        include_once('partials/features/secure-copy-content-protection-featured-display.php');
    }

    public function display_plugin_sccp_pro_features_page() {
		include_once('partials/features/secure-copy-content-protection-pro-features.php');
	}

	public function deactivate_sccp_option() {
		$request_value  = $_REQUEST['upgrade_plugin'];
		$upgrade_option = get_option('sccp_upgrade_plugin', '');
		if ($upgrade_option === '') {
			add_option('sccp_upgrade_plugin', $request_value);
		} else {
			update_option('sccp_upgrade_plugin', $request_value);
		}
		echo json_encode(array('option' => get_option('sccp_upgrade_plugin', '')));
		wp_die();
	}

}
