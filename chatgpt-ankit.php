<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://qrolic.com
 * @since             1.0.0
 * @package           Chatgpt_Ankit
 *
 * @wordpress-plugin
 * Plugin Name:       ChatGPT Ankit
 * Plugin URI:        https://qrolic.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Qrolic
 * Author URI:        https://qrolic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chatgpt-ankit 
 * Domain Path:       /languages
 */


Class ChatGPT_Ankit{

	function _construct(){
		// add_action()		
		// add_action("init",array( $this, "enqueue"));
	}

	public function activate(){
		require_once plugin_dir_path(__FILE__). "includes/class-chatgpt-ankit-activator.php";
		Chatgpt_Ankit_Activator::activate();
	}

	public function deactivate(){
		require_once plugin_dir_path(__FILE__). "includes/class-chatgpt-ankit-deactivator.php";
		Chatgpt_Ankit_Deactivator::deactivate();
	}

	public function my_action_javascript() { ?>
		<script type="text/javascript" >
		jQuery(document).ready(function(jQuery) {
	
			var data = {
				'action': 'my_action',
				'whatever': 1234
			};
	
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				alert('Got this from the server: ' + response);
			});
		});
		</script> <?php
	}

	public function add_chatgpt_metabox() {
		add_meta_box(
			'chatgpt_metabox',
			'Generate Content with ChatGPT',
			array($this ,'render_chatgpt_metabox'),
			'post',
			'normal',
			'default'
		);
		
		add_meta_box(
			'chatgpt_metabox',
			'Generate Content with ChatGPT',
			array($this ,'render_chatgpt_metabox'),
			'page',
			'normal',
			'default'
		);
	}

	
	

    public function generate_chatgpt_content() {

		// error_log("heelo");
		if(!$_POST['search'] || $_POST['search'] == NULL){
			echo 'Please enter some text ';
			exit;
		}
		$search = $_POST["search"];

		check_ajax_referer('chatgpt_generate_content', 'nonce');
	
		// Set your OpenAI API key and ChatGPT instance URL
		$api_key = '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';
		$api_url = 'https://api.openai.com/v1';
	
		// Set the parameters for the content generation request
		$params = [
			"model"=> "text-davinci-003",
			"prompt"=> $search,
			"max_tokens"=> 1000,
			"temperature"=> 0
		];
	
		// // Send the request to ChatGPT
		$response = wp_remote_post($api_url.'/completions', [
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer '.$api_key
			],
			'body' => json_encode($params)
		]);
	
		// print_r($response);
		
		// Parse the response and return the generated content
		$data = json_decode($response['body'], true);
		$content = $data['choices'][0]['text'];
		
		wp_send_json(['content' => $content]);
		echo $content;
		// exit;
	}

	function enqueue_custom_popup_scripts() {
		// wp_enqueue_script('jquery');
		// wp_enqueue_script('my-popup-script', plugins_url('/assets/popup.js',__FILE__));
		// wp_enqueue_style('my-popup-script', plugins_url('/assets/popup.css',__FILE__));
		wp_enqueue_script( 'custom_popup','https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js' );
		wp_enqueue_style( 'custom_popup', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css');
	}

	function enqueue(){
		// enqueue all our scripts
		wp_enqueue_style( 'my_pluginstyle' , plugins_url( '/assets/chatgpt-ankit-admin.css',__FILE__) );    
		wp_enqueue_script( 'my_pluginscript' , 
							plugins_url( '/assets/chatgpt-ankit-admin.js',__FILE__), 
							array(), 
							date("h.i.s"),
							true);
	}

	function register(){
	
		add_action('admin_enqueue_scripts', array( $this, 'enqueue'));

		add_action('admin_enqueue_scripts', array( $this, 'enqueue_custom_popup_scripts'));
		
		add_action('admin_enqueue_scripts', array( $this,'enqueue_custom_popup_scripts'));    

		// add ajax script for metabox
	
		add_action('add_meta_boxes', array( $this,'add_chatgpt_metabox'));

		add_action('wp_ajax_generate_chatgpt_content', array( $this,'generate_chatgpt_content'));

		add_action('wp_ajax_nopriv_generate_chatgpt_content',array( $this,'generate_chatgpt_content'));

	}
}
 
if( class_exists("ChatGPT_Ankit") ) 
{
    $ankitplugin = new ChatGPT_Ankit();


	$ankitplugin->register();

	// function generate_chatgpt_content(){
	// 	 $ankitplugin->generate_chatgpt_content();
	// }
	
	// activation by instance of class
	register_activation_hook(__FILE__, array( $ankitplugin, 'activate'));
	
	// deactivation by instance of class
	register_deactivation_hook(__FILE__, array( $ankitplugin, 'deactivate'));

}




