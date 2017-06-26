<?php

namespace Jimex;

if ( ! defined('ABSPATH')) {
    die();
}

class ImportExportController
{

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init()
    {
        add_action('admin_init', [$this, 'process_action']);
    }

    public function process_action()
    {
        if ( ! isset($_REQUEST['page']) ||
             $_REQUEST['page'] !== 'wp-json-importer-exporter'
        ) {
            return;
        }

        if ( ! isset($_REQUEST['action'])) {
            return;
        }

        if ( ! current_user_can('export')) {
            return;
        }

        $action = $_REQUEST['action'];

        if ($action === 'import') {
            $this->do_import();
        } else if ($action === 'export') {
            $this->do_export();
        }

        return;
    }

    private function do_import()
    {
        $file = file_get_contents($_FILES['jimex-import__file']['tmp_name']);
        $data = json_decode($file);

        return;
    }

    private function do_export()
    {
        global $post;
        $post_types = get_post_types();
        $taxonomies = get_taxonomies();
        $directory  = ABSPATH . '/jimex/';

        if ( ! file_exists($directory)) {
            mkdir($directory);
        }

        foreach ($post_types as $post_type) {

            $filename = 'jimex__' . $post_type . '_' . date('Y-m-d') . '.json';
            $fp       = fopen($directory . $filename, 'w+');

            // Open post type object
            $data = [
                'post_type' => $post_type,
                'posts'     => []
            ];

            $query = new \WP_Query([
                'post_type'      => $post_type,
                'posts_per_page' => -1,
                'post_status'    => 'any'
            ]);

            $post_index = 0;
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_data = (array)$post;

                    // Get custom fields
                    $custom_fields              = get_post_custom($post->ID);
                    $post_data['custom_fields'] = $custom_fields;

                    // Get terms
                    $post_terms = [];
                    foreach ($taxonomies as $taxonomy) {
                        $post_terms[$taxonomy] = get_the_terms($post->ID, $taxonomy);
                    }
                    $post_data['terms'] = $post_terms;

                    // Get attachments
                    $post_data['attachments'] = [];
                    $attachments              = new \WP_Query([
                        'post_type'      => 'attachment',
                        'posts_per_page' => -1,
                        'post_status'    => 'any',
                        'post_parent'    => $post->ID
                    ]);

                    if ($attachments->have_posts()) {
                        while ($attachments->have_posts()) {
                            $attachments->the_post();
                            $post_data['attachments'][] = (array)$post;
                        }
                    }

                    $data['posts'][] = $post_data;
                }
            }

            fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}

new ImportExportController();