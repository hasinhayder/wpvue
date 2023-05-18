<?php

/**
 * Plugin Name: WP Vue
 * Description: WP Vue 
 * Author URI:  https://hasin.me
 * Plugin URI:  https://hasin.me
 * Version:     1.0.0
 * Author:      Hasin
 * Text Domain: wp-vue
 * Domain Path: /i18n
 */

class WPVue {
    function __construct() {
        // add_action('init',[$this,'initialize']);
        add_action('admin_enqueue_scripts', [$this, 'loadAssets']);
        add_action('admin_menu', [$this, 'adminMenu']);
        add_filter('script_loader_tag', [$this, 'loadScriptAsModule'], 10, 3);
    }

    function loadScriptAsModule($tag, $handle, $src) {
        if ('wp-vue-core' !== $handle) {
            return $tag;
        }
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        return $tag;
    }

    function adminMenu() {
        add_menu_page('WPVue', 'WPVue', 'manage_options', 'admin/admin.php', [$this, 'loadAdminPage'], 'dashicons-tickets', 6);
    }

    function loadAdminPage() {
        include_once(plugin_dir_path(__FILE__) . "/wp-src/admin/admin.php");
    }

    function loadAssets() {
        $pluginUrl = plugin_dir_url(__FILE__);
        wp_enqueue_script('wp-vue-core', '//localhost:5173/src/main.js', [], time(), true);
        wp_localize_script('wp-vue-core', 'wpvue', [
            'url' => $pluginUrl
        ]);
    }
}

new WPVue();
