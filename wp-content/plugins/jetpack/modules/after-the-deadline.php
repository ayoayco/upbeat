<?php
/**
 * Module Name: Spelling and Grammar
 * Module Description: Check your spelling, style, and grammar with the After the Deadline proofreading service.
 * Sort Order: 6
 * First Introduced: 1.1
 * Requires Connection: Yes
 * Auto Activate: Yes
 * Module Tags: Writing
 */

add_action( 'jetpack_modules_loaded', 'AtD_load' );

function AtD_load() {
	Jetpack::enable_module_configurable( __FILE__ );
	Jetpack::module_configuration_load( __FILE__, 'AtD_configuration_load' );
}

function AtD_configuration_load() {
	wp_safe_redirect( get_edit_profile_url( get_current_user_id() ) . '#atd' );
	exit;
}

/*
 *  Load necessary include files
 */
include( 'after-the-deadline/config-options.php' );
include( 'after-the-deadline/config-unignore.php' );
include( 'after-the-deadline/proxy.php' );

define('ATD_VERSION', '20120221');

/**
 * Update a user's After the Deadline Setting
 */
function AtD_update_setting( $user_id, $name, $value ) {
	update_user_meta( $user_id, $name, $value );
}

/**
 * Retrieve a user's After the Deadline Setting
 */
function AtD_get_setting( $user_id, $name, $single = true ) {
	return get_user_meta( $user_id, $name, $single );
}

/*
 * Display the AtD configuration options
 */
function AtD_config() {
	AtD_display_options_form();
	AtD_display_unignore_form();
}

/*
 *  Code to update the toolbar with the AtD Button and Install the AtD TinyMCE Plugin
 */
function AtD_addbuttons() {
	/* Don't bother doing this stuff if the current user lacks permissions */
	if ( ! AtD_is_allowed() )
		return;

	if ( ! defined( 'ATD_TINYMCE_4' ) ) {
		define( 'ATD_TINYMCE_4', ( ! empty( $GLOBALS['tinymce_version'] ) && substr( $GLOBALS['tinymce_version'], 0, 1 ) >= 4 ) );
	}

	/* Add only in Rich Editor mode */
	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_AtD_tinymce_plugin' );
		add_filter( 'mce_buttons', 'register_AtD_button' );
	}

	add_action( 'personal_options_update', 'AtD_process_options_update' );
	add_action( 'personal_options_update', 'AtD_process_unignore_update' );
	add_action( 'profile_personal_options', 'AtD_config' );
}

/*
 * Hook into the TinyMCE buttons and replace the current spellchecker
 */
function register_AtD_button( $buttons ) {
	if ( ATD_TINYMCE_4 ) {
		// Use the default icon in TinyMCE 4.0 (replaced by dashicons in editor.css)
		if ( ! in_array( 'spellchecker', $buttons, true ) ) {
			$buttons[] = 'spellchecker';
		}

		return $buttons;
	}

	/* kill the spellchecker.. don't need no steenkin PHP spell checker */
	foreach ( $buttons as $key => $button ) {
		if ( $button == 'spellchecker' ) {
			$buttons[$key] = 'AtD';
			return $buttons;
		}
	}

	/* hrm... ok add us last plz */
	array_push( $buttons, '|', 'AtD' );
	return $buttons;
}

/*
 * Load the TinyMCE plugin : editor_plugin.js (TinyMCE 3.x) | plugin.js (TinyMCE 4.0)
 */
function add_AtD_tinymce_plugin( $plugin_array ) {
	$plugin = ATD_TINYMCE_4 ? 'plugin' : 'editor_plugin';

	$plugin_array['AtD'] = plugins_url( 'after-the-deadline/tinymce/' . $plugin . '.js?v=' . ATD_VERSION, __FILE__ );
	return $plugin_array;
}

/*
 * Update the TinyMCE init block with AtD specific settings
 */
function AtD_change_mce_settings( $init_array ) {
	if ( ! AtD_is_allowed() )
		return $init_array;

	$user = wp_get_current_user();

	$init_array['atd_rpc_url']        = admin_url( 'admin-ajax.php?action=proxy_atd&_wpnonce=' . wp_create_nonce( 'proxy_atd' ) . '&url=' );
	$init_array['atd_ignore_rpc_url'] = admin_url( 'admin-ajax.php?action=atd_ignore&_wpnonce=' . wp_create_nonce( 'atd_ignore' ) . '&phrase=' );
	$init_array['atd_rpc_id']         = 'WPORG-' . md5(get_bloginfo('wpurl'));
	$init_array['atd_theme']          = 'wordpress';
	$init_array['atd_ignore_enable']  = 'true';
	$init_array['atd_strip_on_get']   = 'true';
	$init_array['atd_ignore_strings'] = json_encode( explode( ',',  AtD_get_setting( $user->ID, 'AtD_ignored_phrases' ) ) );
	$init_array['atd_show_types']     = AtD_get_setting( $user->ID, 'AtD_options' );
	$init_array['gecko_spellcheck']   = 'false';

	return $init_array;
}

/*
 * Sanitizes AtD AJAX data to acceptable chars, caller needs to make sure ' is escaped
 */
function AtD_sanitize( $untrusted ) {
        return preg_replace( '/[^a-zA-Z0-9\-\',_ ]/i', "", $untrusted );
}

/*
 * AtD HTML Editor Stuff
 */
function AtD_settings() {
	$user = wp_get_current_user();

	header( 'Content-Type: text/javascript' );

	/* set the RPC URL for AtD */
	echo "AtD.rpc = " . json_encode( esc_url_raw( admin_url( 'admin-ajax.php?action=proxy_atd&_wpnonce=' . wp_create_nonce( 'proxy_atd' ) . '&url=' ) ) ) . ";\n";

	/* set the API key for AtD */
	echo "AtD.api_key = " . json_encode( 'WPORG-' . md5( get_bloginfo( 'wpurl' ) ) ) . ";\n";

	/* set the ignored phrases for AtD */
	echo "AtD.setIgnoreStrings(" . json_encode( AtD_get_setting( $user->ID, 'AtD_ignored_phrases' ) ) . ");\n";

	/* honor the types we want to show */
	echo "AtD.showTypes(" . json_encode( AtD_get_setting( $user->ID, 'AtD_options' ) ) .");\n";

	/* this is not an AtD/jQuery setting but I'm putting it in AtD to make it easy for the non-viz plugin to find it */
	$admin_ajax_url = admin_url( 'admin-ajax.php?action=atd_ignore&_wpnonce=' . wp_create_nonce( 'atd_ignore' ) . '&phrase=' );
	echo "AtD.rpc_ignore = " . json_encode( esc_url_raw( $admin_ajax_url ) ) . ";\n";

	die;
}

function AtD_load_javascripts() {
	if ( AtD_should_load_on_page() ) {
		wp_enqueue_script( 'AtD_core', plugins_url( '/after-the-deadline/atd.core.js', __FILE__ ), array(), ATD_VERSION );
		wp_enqueue_script( 'AtD_quicktags', plugins_url( '/after-the-deadline/atd-nonvis-editor-plugin.js', __FILE__ ), array('quicktags'), ATD_VERSION );
		wp_enqueue_script( 'AtD_jquery', plugins_url( '/after-the-deadline/jquery.atd.js', __FILE__ ), array('jquery'), ATD_VERSION );
		wp_enqueue_script( 'AtD_settings', admin_url() . 'admin-ajax.php?action=atd_settings', array('AtD_jquery'), ATD_VERSION );
		wp_enqueue_script( 'AtD_autoproofread', plugins_url( '/after-the-deadline/atd-autoproofread.js', __FILE__ ), array('AtD_jquery'), ATD_VERSION );

		/* load localized strings for AtD */
		wp_localize_script( 'AtD_core', 'AtD_l10n_r0ar', array (
			'menu_title_spelling'         => __( 'Spelling', 'jetpack' ),
			'menu_title_repeated_word'    => __( 'Repeated Word', 'jetpack' ),

			'menu_title_no_suggestions'   => __( 'No suggestions', 'jetpack' ),

			'menu_option_explain'         => __( 'Explain...', 'jetpack' ),
			'menu_option_ignore_once'     => __( 'Ignore suggestion', 'jetpack' ),
			'menu_option_ignore_always'   => __( 'Ignore always', 'jetpack' ),
			'menu_option_ignore_all'      => __( 'Ignore all', 'jetpack' ),

			'menu_option_edit_selection'  => __( 'Edit Selection...', 'jetpack' ),

			'button_proofread'            => __( 'proofread', 'jetpack' ),
			'button_edit_text'            => __( 'edit text', 'jetpack' ),
			'button_proofread_tooltip'    => __( 'Proofread Writing', 'jetpack' ),

			'message_no_errors_found'     => __( 'No writing errors were found.', 'jetpack' ),
			'message_server_error'        => __( 'There was a problem communicating with the Proofreading service. Try again in one minute.', 'jetpack' ),
			'message_server_error_short'  => __( 'There was an error communicating with the proofreading service.', 'jetpack' ),

			'dialog_replace_selection'    => __( 'Replace selection with:', 'jetpack' ),
			'dialog_confirm_post_publish' => __( "The proofreader has suggestions for this post. Are you sure you want to publish it?\n\nPress OK to publish your post, or Cancel to view the suggestions and edit your post.", 'jetpack' ),
			'dialog_confirm_post_update'  => __( "The proofreader has suggestions for this post. Are you sure you want to update it?\n\nPress OK to update your post, or Cancel to view the suggestions and edit your post.", 'jetpack' ),
		) );
	}
}

/* Spits out user options for auto-proofreading on publish/update */
function AtD_load_submit_check_javascripts() {
	global $pagenow;

	$user = wp_get_current_user();
	if ( ! $user || $user->ID == 0 )
		return;

	if ( AtD_should_load_on_page() ) {
		$atd_check_when = AtD_get_setting( $user->ID, 'AtD_check_when' );

		if ( !empty( $atd_check_when ) ) {
			$check_when = array();
			/* Set up the options in json */
			foreach( explode( ',', $atd_check_when ) as $option ) {
				$check_when[$option] = true;
			}
			echo '<script type="text/javascript">' . "\n";
			echo 'AtD_check_when = ' . json_encode( (object) $check_when ) . ";\n";
			echo '</script>' . "\n";
		}
	}
}

/*
 * Check if a user is allowed to use AtD
 */
function AtD_is_allowed() {
        $user = wp_get_current_user();
        if ( ! $user || $user->ID == 0 )
                return;

        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
                return;

        return 1;
}

function AtD_load_css() {
	if ( AtD_should_load_on_page() )
		wp_enqueue_style( 'AtD_style', plugins_url( '/after-the-deadline/atd.css', __FILE__ ), null, ATD_VERSION, 'screen' );
}

/* Helper used to check if javascript should be added to page. Helps avoid bloat in admin */
function AtD_should_load_on_page() {
	global $pagenow, $current_screen;

	$pages = array( 'post.php', 'post-new.php', 'page.php', 'page-new.php', 'admin.php', 'profile.php' );

	if ( in_array( $pagenow, $pages ) ) {
		if ( isset( $current_screen->post_type ) && $current_screen->post_type ) {
			return post_type_supports( $current_screen->post_type, 'editor' );
		}
		return true;
	}

	return apply_filters( 'atd_load_scripts', false );
}

// add button to DFW
add_filter( 'wp_fullscreen_buttons', 'AtD_fullscreen' );
function AtD_fullscreen($buttons) {
	$buttons['spellchecker'] = array( 'title' => __( 'Proofread Writing', 'jetpack' ), 'onclick' => "tinyMCE.execCommand('mceWritingImprovementTool');", 'both' => false );
	return $buttons;
}

/* add some vars into the AtD plugin */
add_filter( 'tiny_mce_before_init', 'AtD_change_mce_settings' );

/* load some stuff for non-visual editor */
add_action( 'admin_enqueue_scripts', 'AtD_load_javascripts' );
add_action( 'admin_enqueue_scripts', 'AtD_load_submit_check_javascripts' );
add_action( 'admin_enqueue_scripts', 'AtD_load_css' );

/* init process for button control */
add_action( 'init', 'AtD_addbuttons' );

/* setup hooks for our PHP functions we want to make available via an AJAX call */
add_action( 'wp_ajax_proxy_atd', 'AtD_redirect_call' );
add_action( 'wp_ajax_atd_ignore', 'AtD_ignore_call' );
add_action( 'wp_ajax_atd_settings', 'AtD_settings' );
