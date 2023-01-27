<?php

/**
 * The main template file
 */

get_header(); ?>
<main class="my-theme__content">
    <?php
    $paged = (get_query_var('paged')) ?: 1;
    $query = new WP_Query([
        'posts_per_page' => 2,
        'paged' => $paged,
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
            'total'        => $query->max_num_pages,
            'current'      => max(1, $paged),
            'format'       => '?paged=%#%',
            'type'         => 'plain',
            'add_args'     => false,
            ]) ?>
    </div>
    <?php wp_reset_postdata(); ?>
</main>
<?php get_footer();
