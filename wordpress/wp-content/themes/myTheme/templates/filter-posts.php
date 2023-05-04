<?php
load_template(get_template_directory() . '/templates/posts.php');?>
<div class='pagination'>
    <?php $pagination = get_the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'myTheme' ),
        'next_text'          => __( 'Next page', 'myTheme' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'myTheme' ) . ' </span>',
    ) );

    echo str_replace( admin_url( 'admin-ajax.php/' ), get_category_link($_POST['cat_filter']), $pagination );?>
</div>
