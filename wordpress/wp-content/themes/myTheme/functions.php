<?php

function myThemeStylesAndScripts() {
    wp_enqueue_style('style_for_site', get_stylesheet_directory_uri() . '/css/my-theme.css');
    wp_enqueue_script('filter', get_stylesheet_directory_uri() . '/js/filter.js', ['jquery'], time(), true);
    wp_localize_script('filter', 'cat_filter', ['ajaxurl' => admin_url( 'admin-ajax.php' )]);
}

add_action( 'wp_enqueue_scripts', 'myThemeStylesAndScripts', 25 );

add_action( 'wp_ajax_filter', 'true_filter_function' );
add_action( 'wp_ajax_nopriv_filter', 'true_filter_function' );

function true_filter_function(){
	query_posts('cat=' . $_POST['cat_filter']);
	load_template(get_template_directory() . '/templates/posts.php');
    die();
}

function myThemesSetup() {
    register_nav_menus(
        [
            'primary' => esc_html__('Primary menu', 'myTheme'),
            'footer' => esc_html__('Secondary menu', 'myTheme'),
        ]
    );

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
	load_theme_textdomain( 'my-theme', get_template_directory() . '/languages' );
}

add_action('after_setup_theme', 'myThemesSetup');

function myThemeWidgetsInit() {

    register_sidebar(
        [
            'name'          => esc_html__( 'Header', 'myTheme' ),
            'id'            => 'header_sidebar',
            'description'   => esc_html__( 'Add widgets in the header.', 'myTheme' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]
    );

    register_sidebar(
        [
            'name'          => esc_html__( 'Footer', 'myTheme' ),
            'id'            => 'footer_sidebar',
            'description'   => esc_html__( 'Add widgets in the footer.', 'myTheme' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]
    );
}
add_action( 'widgets_init', 'myThemeWidgetsInit' );

function newExcerptMore($more): string
{
    global $post;
    return ' <a href="'. get_permalink($post) . '">Reade more...</a>';
}

add_filter('excerpt_more', 'newExcerptMore');