<?php get_header() ?>
 <?php
	$post = get_post(3226);
echo apply_filters('the_content', $post->post_content);
	?>
<?php get_footer() ?>