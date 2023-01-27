<?php

class MyPlugin
{
    public function __construct()
    {
        register_activation_hook(MY_PLUGIN, [$this, 'checkPhpVersion']);
        add_action( 'admin_init', [$this, 'deactivateMyPlugin']);
        add_action('activated_plugin', [$this, 'addDateForPosts'], 10, 2);
        add_action('deactivated_plugin', [$this, 'removeDateForPosts'], 10, 2);
    }

    public function checkPhpVersion(): void
    {
        if(PHP_VERSION_ID < 70400) {
            add_option( 'Activated_Plugin', 'Invalid' );
        }
    }

    public function deactivateMyPlugin(): void
    {
        if (get_option( 'Activated_Plugin' ) === 'Invalid') {
            delete_option('Activated_Plugin');
            deactivate_plugins(plugin_basename(MY_PLUGIN));
            self::showInvalidMessage();
        }
    }

    public static function showInvalidMessage(): void
    {
        load_template(plugin_dir_path(MY_PLUGIN) . '/templates/invalid-message.php');
    }

    public function addDateForPosts(): void
    {
        global $post;
        $posts = get_posts();

        foreach ($posts as $post){
            setup_postdata($post);
            $args = [
                'ID'         => $post->ID,
                'post_title' => $post->post_title . ' ' . get_the_date(),
            ];

            wp_update_post(wp_slash($args));
        }
    }

    public function removeDateForPosts(): void
    {
        $posts = get_posts();

        foreach ($posts as $post){
            setup_postdata($post);
            $args = [
                'ID'         => $post->ID,
                'post_title' => substr($post->post_title, 0, -11),
            ];

            wp_update_post(wp_slash($args));
        }
    }
}