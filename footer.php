<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package orca
 */


?>
<footer class="main-footer">
    <?php echo do_shortcode('[template template_id=136]'); ?>
</footer>

<div class="backdrop"></div>
<div class="d-none">
    <?= do_shortcode('[template template_id=1719]') ?>
    <?= do_shortcode('[template template_id=1602]') ?>
    <?= do_shortcode('[template template_id=1618]') ?>
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php
get_template_part('template-parts/offcanvas/finance-calculator');
get_template_part('template-parts/offcanvas/reserve-form');
?>

</body>

</html>