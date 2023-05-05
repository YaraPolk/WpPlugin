<?php
/**
 * The header.
 */
?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= wp_get_document_title() ?></title>
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="<?= is_singular() ? 'without-filter' : ''?>">
            <?php if (has_custom_logo()): ?>
                <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php else: ?>
                <div class="site-logo">
                    <a href="<?= site_url()?>">
                        <img src="<?= get_stylesheet_directory_uri() . '/media/logo.svg' ?>" alt="site logo">
                    </a>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('header_sidebar')): ?>
                <nav class="widget nav-menu">
                    <?php dynamic_sidebar('header_sidebar') ?>
                </nav>
            <?php endif; ?>
            <?php if(!is_singular()): ?>
            <div class="categories">
                <p class="categories-list">
                    <span>Categories: </span>
                    <?= wp_list_categories('orderby=name&hide_empty=1&show_option_all=&style=none&separator=,') ?>
                </p>
                <?php if (!is_category()): ?>
                    <form action="" method="POST" id="filter">
                        <?php
                            $categories = get_terms([
                                        'taxonomy'  => 'category',
                                        'orderby'   => 'name',
                                        ]);
                            if($categories): ?>
                                <select name="cat_filter" id="cat_filter">
                                    <option value="">All categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->term_id ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            </div>
            <div class="sort">
                <form action="" method="post" id="sort">
                    <button type="button">sort</button>
                </form>
            </div>
            <?php endif; ?>
        </header>