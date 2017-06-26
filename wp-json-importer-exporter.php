<?php
/*
Plugin Name: WordPress JSON Importer/Exporter
Plugin URI: https://wordpress.org/plugins/search/wp-json-exporter-importer/
Description: Import and export WordPress posts, pages and custom posts with attachments and terms.
Version: 0.1.0
Author: James Whayman
Author URI: http://www.jameswhayman.com/
Copyright: James Whayman
Text Domain: jimex
Domain Path: /lang
*/

if ( ! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if ( ! class_exists('Jimex')) :

    class Jimex
    {
        var $version = '0.1.0';

        public function __construct()
        {
            // Do nothing
        }

        public function init()
        {
            // constants
            $this->define('JIMEX_VERSION', $this->version);

            require_once(__DIR__ . '/controllers/import-export-controller.php');

            add_action('admin_enqueue_scripts', [$this, 'register_scripts']);
            add_action('admin_menu', [$this, 'init_menu']);
        }

        /**
         * Register scripts and styles
         */
        public function register_scripts()
        {
            wp_enqueue_style('jimex-css', plugin_dir_url(__FILE__) . 'assets/dist/main.css', false, $this->version);
            wp_enqueue_script('jimex-js', plugin_dir_url(__FILE__) . 'assets/dist/main.js', ['jquery'], $this->version,
                true);
        }

        /**
         * Display the sub-menu page under the tools menu.
         */
        public function init_menu()
        {
            add_submenu_page('tools.php',
                __('WP JSON Importer/Exporter', 'jimex'),
                __('WP JSON Importer/Exporter', 'jimex'),
                'export',
                'wp-json-importer-exporter',
                [$this, 'display_dashboard']);
        }

        public function display_dashboard()
        {
            require_once(__DIR__ . '/views/dashboard.php');
        }

        /**
         * Define a constant
         *
         * @param $name
         * @param $value
         */
        private function define($name, $value)
        {
            if ( ! defined($name)) {
                define($name, $value);
            }
        }


    }

    function jimex()
    {
        global $jimex;

        if ( ! isset($jimex)) {
            $jimex = new Jimex();
            $jimex->init();
        }

        return $jimex;
    }

    jimex();

endif;