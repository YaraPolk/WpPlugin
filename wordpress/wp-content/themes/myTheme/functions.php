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
    $paged = (get_query_var('paged')) ?: 1;
    $query = new WP_Query([
        'posts_per_page' => 2,
        'paged' => $paged,
        'cat' => $_POST['cat_filter'],
    ]);

    if ($query->have_posts()):
        while ($query->have_posts()): $query->the_post();?>
            <div class="post">
                <h2>
                    <a href="<?= get_permalink() ?>"><?= the_title() ?></a>
                </h2>
                <p class="category"><?= get_the_category_list(',') ?></p>
                <p class="post-logo">
                    <a href="<?= get_permalink() ?>"><?= get_the_post_thumbnail( get_the_ID(), [300, 200]) ?></a>
                </p>
                <p class="excerpt"><?= get_the_excerpt() ?></p>
            </div>
        <?php endwhile;?>
    <?php endif; ?>
    <div class="pagination">
        <?= paginate_links([
            'base'         => home_url() . '/?paged=%#%',
            'total'        => $query->max_num_pages,
            'current'      => max(1, $paged),
            'format'       => '',
            'type'         => 'plain',
            'add_args'     => false,
        ]) ?>
    </div>
    <?php wp_reset_postdata();
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