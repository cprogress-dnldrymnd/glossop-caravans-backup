<?php get_header() ?>

<div class="site-content full-width-content">
   <?php 
	  $post = get_post(3221);
        echo apply_filters('the_content', $post->post_content);
	?>

<?php get_footer() ?>