<?php

namespace Functions;
class CreatePost
{
    public $newPostData = array();

    public function setPostData()
    {
        foreach ($this->newPostData as $post) {
            $PostToInsert = array(
                'post_title' => wp_strip_all_tags($post['post_title']),
                'post_content' => $post['post_content'],
                'post_status' => 'publish',
                'post_type' => 'sliders'
            );
            $postId = wp_insert_post($PostToInsert);
            update_field('slider_link', $post['post_link'], $postId);

            $this->setPostThumbnail($post['post_image_url'], $postId);
        }
    }

    public function createPost(array $newPostData, int $timeInterval)
    {
        $this->newPostData = $newPostData;
        add_action('create_new_post_action', array($this, 'setPostData'));
        wp_schedule_single_event(time() + $timeInterval, 'create_new_post_action');
    }

    private function setPostThumbnail($postImageUrl, $postId)
    {
        $image_url = $postImageUrl;
        $image_name = 'slider-image' . time() . '.png';
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
        $filename = basename($unique_file_name);
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        file_put_contents($file, $image_data);
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $postId);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($postId, $attach_id);
    }
}