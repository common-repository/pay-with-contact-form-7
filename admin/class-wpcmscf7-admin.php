<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/admin
 * @author     CMSMINDS <info@cmsminds.com>
 */
class Wpcmscf7_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The last inserted id of form record.
	 *
	 * @since    1.0.3
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $last_insert_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.3
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcmscf7_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcmscf7_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcmscf7-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcmscf7_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcmscf7_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpcmscf7-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Check that Contact Form 7 installed and active or not.
	 *
	 * @since    1.0.3
	 */
	function wpcmscf7_check_dependancy(){
		if ( ! in_array( 'contact-form-7/wp-contact-form-7.php', 
                       apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			?>
			<div class="error">
				<p><?php _e( '<b>Contact Form 7 PayPal Add-on:</b> Contact Form 7 is not installed and / or active! ', 'wpcmscf7' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Add submenu WPCMSCF7-PayPal-Settings in Contact Form 7.
	 *
	 * @since    1.0.3
	 */
	function wpcmscf7_admin_menu(){
		add_submenu_page( 'wpcf7', 'PayPal Settings', 'PayPal Settings', 'wpcf7_edit_contact_forms', 'wpcmscf7_admin_settings',	array($this,'wpcmscf7_cf7_entry_callback') );
	}

	function wpcmscf7_editor_panels($panels){
		$new_page = array(
			'PayPal1' => array(
				'title' => __( 'PayPal', 'contact-form-7' ),
				'callback' => array($this,'wpcmscf7_admin_after_additional_settings')
			)
		);
		
		$panels = array_merge($panels, $new_page);
		
		return $panels;
	}

	function wpcmscf7_admin_after_additional_settings( $cf7 ){
		
		$post_id = sanitize_text_field($_GET['post']);
		
		$wpcmscf7_enable = get_post_meta($post_id, "wpcmscf7_enable", true);
		$wpcmscf7_name = get_post_meta($post_id, "wpcmscf7_name", true);
		$wpcmscf7_price = get_post_meta($post_id, "wpcmscf7_price", true);
		$wpcmscf7_id = get_post_meta($post_id, "wpcmscf7_id", true);
		$wpcmscf7_email = get_post_meta($post_id, "wpcmscf7_email", true);

		$options = get_option('wpcms_cf7pp_options');
		if(isset($options) && !empty($options)){
			foreach ($options as $k => $v ) { 
				$value[$k] = $v; 

			}
		}


		$account = '';
		if(isset($options) && !empty($options)){
			if ($options['mode'] == "1") {
				$account = $value['sandboxaccount'];
			} elseif ($options['mode'] == "2")  {
				$account = $value['liveaccount'];
			}
		}
		$req_msg = '';
		$checked = '';
		if($account == ''){
			$disabled = 'disabled';
			$req_msg = ' <strong style="color:red;">Please Enter Sandbox/Live Account Detail from <a href="'.site_url().'/wp-admin/admin.php?page=wpcmscf7_admin_settings" target="_blank"><u>Contact->Paypal Setting</u></a></strong>';  
			$checked = " "; 
			update_post_meta($post_id, "wpcmscf7_enable", 0);
		}else{
			$disabled = '';
			if($wpcmscf7_enable == 1){
				$checked = "checked"; 
			}
		}

		
		if ($wpcmscf7_email == "1") { $before = "SELECTED"; $after = ""; } elseif ($wpcmscf7_email == "2") { $after = "SELECTED"; $before = ""; } else { $before = ""; $after = ""; }
		
		$admin_table_output = "";
		$admin_table_output .= "";
		$admin_table_output .= "<div id='wpcmscf7_additional_settings-sortables' class='meta-box-sortables ui-sortable'><div id='' class='postbox'>";
		$admin_table_output .= "<div class='handlediv' title='Click to toggle'><br></div><h3 class='hndle ui-sortable-handle'><span>PayPal Settings</span></h3>";
		$admin_table_output .= "<div class='inside'>";
		
		$admin_table_output .= "<div class='mail-field'>";
		$admin_table_output .= "<input name='wpcmscf7_enable' id='wpcmscf7_enabled_form' value='1' $disabled type='checkbox' $checked>";
		$admin_table_output .= "<label for='wpcmscf7_enabled_form' >Enable PayPal on this form</label>".'&nbsp;'.$req_msg ;
		$admin_table_output .= "</div>";
		
		$admin_table_output .= "<br /><table><tr><td>Item Description: </td></tr><tr><td>";
		$admin_table_output .= "<input type='text' name='wpcmscf7_name' value='$wpcmscf7_name'> </td><td> (Optional, if left blank customer will be able to enter their own description at checkout)</td></tr><tr><td>";
		
		$admin_table_output .= "Item Price: </td></tr><tr><td>";
		$admin_table_output .= "<input type='text' name='wpcmscf7_price' value='$wpcmscf7_price'> </td><td> (Optional, if left blank customer will be able to enter their own price at checkout. Format: for $2.99, enter 2.99)</td></tr><tr><td>";
		
		$admin_table_output .= "Item ID / SKU: </td></tr><tr><td>";
		$admin_table_output .= "<input type='text' name='wpcmscf7_id' value='$wpcmscf7_id'> </td><td> (Optional)</td></tr><tr><td>";
		
		$admin_table_output .= "<input type='hidden' name='wpcmscf7_email' value='2'>";
		
		$admin_table_output .= "<input type='hidden' name='wpcmscf7_post' value='$post_id'>";
		
		$admin_table_output .= "</td></tr></table>";
		$admin_table_output .= "</div>";
		$admin_table_output .= "</div>";
		$admin_table_output .= "</div>";

		echo $admin_table_output;
	}

	function wpcmscf7_plugin_settings_link($links){
		unset($links['edit']);

		$settings = '<a href="admin.php?page=wpcmscf7_admin_settings">' . __('Settings', 'wpcmscf7') . '</a>';
		$edit = '<a href="plugin-editor.php?file=wpcmscf7/wpcmscf7.php">' . __('Edit', 'wpcmscf7') . '</a>';
		array_push($links, $edit);
		array_push($links, $settings);
		return $links;
	}

	function wpcmscf7_save_contact_form( $cf7 ) {
		
			$post_id = intval(sanitize_text_field($_POST['wpcmscf7_post']));
			
			if (!empty($_POST['wpcmscf7_enable'])) {
				$wpcmscf7_enable = sanitize_text_field($_POST['wpcmscf7_enable']);
				update_post_meta($post_id, "wpcmscf7_enable", $wpcmscf7_enable);
			} else {
				update_post_meta($post_id, "wpcmscf7_enable", 0);
			}
			
			$wpcmscf7_name = sanitize_text_field($_POST['wpcmscf7_name']);
			update_post_meta($post_id, "wpcmscf7_name", $wpcmscf7_name);
			
			$wpcmscf7_price = sanitize_text_field($_POST['wpcmscf7_price']);
			update_post_meta($post_id, "wpcmscf7_price", $wpcmscf7_price);
			
			$wpcmscf7_id = sanitize_text_field($_POST['wpcmscf7_id']);
			update_post_meta($post_id, "wpcmscf7_id", $wpcmscf7_id);
			
			$wpcmscf7_email = sanitize_text_field($_POST['wpcmscf7_email']);
			update_post_meta($post_id, "wpcmscf7_email", $wpcmscf7_email);
					
			
	}

	/***
	* This function is for insert cf7 form data to table table->prefix wpcmscf7_forms.
	* 
	*/
	function wpcmscf7_before_send_mail( $form_tag )
	{
		global $wpdb;
	    $table_name    = $wpdb->prefix.'cmscf7_forms';
	    $upload_dir    = wp_upload_dir();
	    $wpcmscf7_dirname = $upload_dir['basedir'].'/wpcmscf7_uploads';
	    $time_now      = time();

	    $form = WPCF7_Submission::get_instance();

	    if ( $form ) {

	    	$black_list   = array('_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag',
        '_wpcf7_is_ajax_call','cfdb7_name','_wpcf7_container_post','_wpcf7cf_hidden_group_fields',
        '_wpcf7cf_hidden_groups', '_wpcf7cf_visible_groups', '_wpcf7cf_options','g-recaptcha-response');

	        $data           = $form->get_posted_data();
	        $files          = $form->uploaded_files();
	        $uploaded_files = array();

	        foreach ($files as $file_key => $file) {
	            array_push($uploaded_files, $file_key);
	            copy($file, $wpcmscf7_dirname.'/'.$time_now.'-'.basename($file));
	        }

	        $form_data   = array();

	        foreach ($data as $key => $d) {
	            if ( !in_array($key, $black_list ) && !in_array($key, $uploaded_files ) ) {
	                
	                $tmpD = $d;
	                
	                if ( ! is_array($d) ){

	                    $bl   = array('\"',"\'",'/','\\');
	                    $wl   = array('&quot;','&#039;','&#047;', '&#092;');

	                    $tmpD = str_replace($bl, $wl, $tmpD );
	                } 

	                $form_data[$key] = $tmpD; 
	            }
	            if ( in_array($key, $uploaded_files ) ) {
	                $form_data[$key.'wpcmscf7_file'] = $time_now.'-'.$d;
	            }
	        }

	        /* wpcmscf7 before save data. */ 
	        do_action( 'wpcmscf7_before_save_data', $form_data );

	        $form_post_id = $form_tag->id();
	        $form_value   = serialize( $form_data );
	        $form_date    = current_time('Y-m-d H:i:s');
	 
	        $wpdb->insert( $table_name, array( 
	            'form_post_id' => $form_post_id,
	            'form_value'   => $form_value,
	            'form_date'    => $form_date
	        ) );

	        /* wpcmscf7 after save data */ 
	        $this->last_insert_id = $wpdb->insert_id;
			
	        do_action( 'wpcmscf7_after_save_data', $this->last_insert_id );
	    }
		
	}

	function wpcmscf7_admin_list_table_page()
	{	
		    	add_submenu_page( 'wpcf7', 'Contact Forms', 'Form Entries', 'manage_options', 'wpcmscf7-list.php', array($this, 'wpcmscf7_list_table_page') );
	}

	function wpcmscf7_list_table_page()
	{
		if ( ! in_array( 'contact-form-7/wp-contact-form-7.php', 
                       apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
           
           wp_die( 'Please activate <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">contact form 7</a> plugin.' );
        }
        
        require_once plugin_dir_path(__FILE__) . 'partials/wpcmscf7-admin-subpage.php';
        require_once plugin_dir_path(__FILE__) . 'partials/wpcmscf7-admin-form-details.php';

        $fid  = empty($_GET['fid']) ? 0 : (int) $_GET['fid'];
        $ufid = empty($_GET['ufid']) ? 0 : (int) $_GET['ufid'];

        if ( !empty($fid) && empty($_GET['ufid']) ) {

            new Wpcmscf7_Wp_Sub_Page();
            return;
        }

        if( !empty($ufid) && !empty($fid) ){

            new Wpcmscf7_Form_Details();
            return;
        }

        $file = require_once plugin_dir_path(__FILE__) . 'partials/wpcmscf7-Main-List-Table.php';

        if($file) {
	        $ListEntryTable = new WPCMSCF7_Main_List_Table();
	        $ListEntryTable->prepare_items();
	        ?>
	            <div class="wrap">
	                <div id="icon-users" class="icon32"></div>
	                <h2>Contact Forms List</h2>
	                <?php $ListEntryTable->display(); ?>
	            </div>
	        <?php
	    }
	    else{
	    	echo "There was an Error for including some files.";
	    }
	}

	function wpcmscf7_after_send_mail( $cf7 ){

		global $postid;
		
		$postid = $cf7->id();
		$enable = get_post_meta( $postid, "wpcmscf7_enable", true);
		$email = get_post_meta( $postid, "wpcmscf7_email", true);
		
		if ($enable == "1") {
			if ($email == "2") {
				
				include_once(plugin_dir_path( __FILE__ ) . 'partials/wpcmscf7-admin-paypal-redirect.php');
				
				exit;
			
			}
		}
	}

	public function wpcmscf7_cf7_entry_callback(){
		if ( !current_user_can( "manage_options" ) )  {
			wp_die( __( "You do not have sufficient permissions to access this page." ) );
		}
		
		include_once(plugin_dir_path( __FILE__ ).'partials/wpcmscf7-admin-display.php');
	}

	public function wpcmscf7_add_tag_generator(){

		if (class_exists('WPCF7_TagGenerator')) {
			$tag_generator = WPCF7_TagGenerator::get_instance();
			$tag_generator->add( 'paypal', __( 'paypal' ),array($this,'tag_generator_paypal') );
		}

	}

	/**
	 * Tag generator form
	 *
	 * @since    4.0.0
	 */
	public function tag_generator_paypal( $contact_form, $args = '' ) {

		$args = wp_parse_args( $args, array() );
		$type = 'paypal';

		$description = __( "Generate a form-tag for a paypal field.", 'contact-form-7' );
		?>
		<div class="control-box">
		<fieldset>
		<legend><?php echo sprintf( esc_html( $description ) ); ?></legend>
		<table class="form-table">
		<tbody>
			<tr>
			<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
			<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
			</tr>

			<tr>
			<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
			<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
			</tr>

			<tr>
			<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
			<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
			</tr>
			
		</tbody>
		</table>
		</fieldset>
		</div>

		<div class="insert-box">
			<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

			<div class="submitbox">
			<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
			</div>
		</div>
		<?php
	}

}
