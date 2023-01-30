<?php

/**
 * The single template file
 */

get_header(); ?>
<main class="my-theme__content">
	<?php load_template(get_template_directory() . '/templates/posts.php');?>
</main>
<?php get_footer();