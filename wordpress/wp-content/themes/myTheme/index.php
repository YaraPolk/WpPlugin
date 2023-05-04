<?php

/**
 * The main template file
 */

get_header(); ?>
<main class="my-theme__content">
    <?php
	$currentPage = get_query_var('paged');
    $posts = new WP_Query([
        'posts_per_page' => -1,
        'paged' => $currentPage,
    ]);
    if ($posts->have_posts()):
        while ($posts->have_posts()): $posts->the_post();?>
            <div class="post">
                <h2><a href="<?= get_permalink() ?>"><?= the_title() ?></a></h2>
                <p class="category"><?= get_the_category_list(',') ?></p>
                <p class="post-logo"><?= get_the_post_thumbnail( get_the_ID(), 'large') ?></p>
                <p class="excerpt"><?= is_singular() ? get_the_content() : get_the_excerpt() ?></p>
                <?php if (get_post_meta( get_the_ID(), 'Note', true ) != ''): ?>
                    <p class="note">Note: <?= get_post_meta(get_the_ID(), 'Note', true)?></p>
                <?php endif; ?>
            </div>
        <?php endwhile;
    endif;?>
    <div class='pagination'>
        <?= paginate_links(['total' => $posts->max_num_pages])?>
    </div>
</main>
<?php get_footer();
