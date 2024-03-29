<?php

function myThemeStylesAndScripts() {
    wp_enqueue_style('webpack_style_for_site', get_stylesheet_directory_uri() . '/assets/css/my-theme.css' );
    wp_enqueue_script('webpack_js', get_stylesheet_directory_uri() . '/assets/js/main.js', ['jquery'], time(), true);
    wp_localize_script('webpack_js', 'cat_filter', ['ajaxurl' => admin_url( 'admin-ajax.php' )]);
}

add_action( 'wp_enqueue_scripts', 'myThemeStylesAndScripts', 25 );

add_action( 'wp_ajax_filter', 'true_filter_function' );
add_action( 'wp_ajax_nopriv_filter', 'true_filter_function' );

function true_filter_function(){
	$currentPage = get_query_var('paged');
	query_posts([
        'cat'            => $_POST['cat_filter'],
        'paged'          => $currentPage,
        'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => !empty($_POST['sort']) ? $_POST['sort'] : '',

	]);
	load_template(get_template_directory() . '/templates/filter-posts.php');
    wp_die();
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

add_action('wp_insert_post', 'set_default_post_custom_fields', 10, 2);
function set_default_post_custom_fields($post_id)
{
	add_post_meta($post_id, 'Note', '', true);
}