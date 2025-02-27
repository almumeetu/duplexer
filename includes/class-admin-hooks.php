<?php
if (!defined('ABSPATH')) {
    exit;
}

class DupleXer_Admin_Hooks {

    public function __construct() {
        add_action('post_row_actions', [$this, 'add_duplicate_button'], 10, 2);
        add_action('page_row_actions', [$this, 'add_duplicate_button'], 10, 2);
        add_action('admin_action_duplexer_duplicate_post', [$this, 'duplicate_post']);
    }

    public function add_duplicate_button($actions, $post) {
        if (current_user_can('edit_posts')) {
            $actions['duplicate'] = '<a href="' . wp_nonce_url(admin_url('admin.php?action=duplexer_duplicate_post&post=' . $post->ID), 'duplexer_duplicate_post', 'nonce') . '" title="Duplicate this item">Duplicate</a>';
        }
        return $actions;
    }

    public function duplicate_post() {
        if (!isset($_GET['post']) || !isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'duplexer_duplicate_post')) {
            wp_die('Unauthorized request');
        }

        $post_id = absint($_GET['post']);
        $duplicator = new DupleXer_Duplicator();
        $duplicator->duplicate($post_id);
    }
}
