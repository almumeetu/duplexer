<?php
if (!defined('ABSPATH')) {
    exit;
}

class DupleXer_Duplicator {

    public function duplicate($post_id) {
        $post = get_post($post_id);

        if (!$post) {
            wp_die('Invalid post ID');
        }

        $new_post = array(
            'post_title'   => $post->post_title . ' (Copy)',
            'post_content' => $post->post_content,
            'post_status'  => 'draft',
            'post_type'    => $post->post_type,
            'post_author'  => get_current_user_id(),
        );

        $new_post_id = wp_insert_post($new_post);

        if ($new_post_id) {
            $this->copy_meta_data($post_id, $new_post_id);
            $this->copy_taxonomies($post_id, $new_post_id);
        }

        wp_redirect(admin_url('edit.php?post_type=' . $post->post_type));
        exit;
    }

    private function copy_meta_data($post_id, $new_post_id) {
        $meta_data = get_post_meta($post_id);
        foreach ($meta_data as $key => $value) {
            update_post_meta($new_post_id, $key, maybe_unserialize($value[0]));
        }
    }

    private function copy_taxonomies($post_id, $new_post_id) {
        $taxonomies = get_object_taxonomies(get_post_type($post_id));
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'ids'));
            wp_set_object_terms($new_post_id, $terms, $taxonomy);
        }
    }
}
