<?php
/**
 * The header.
 */
?>
        <footer id="colophon" class="site-footer">
            <?php if (is_active_sidebar('footer_sidebar')): ?>
                <aside class="widget">
                    <?php dynamic_sidebar('footer_sidebar') ?>
                </aside>
            <?php endif; ?>
        </footer>
    <?php wp_footer(); ?>
    </body>
</html>
