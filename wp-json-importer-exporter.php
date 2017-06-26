<?php
/*
Plugin Name: WordPress JSON Importer Exporter
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