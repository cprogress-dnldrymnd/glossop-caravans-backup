<?php
add_action('wp_ajax_nopriv_listing_search', 'listing_search'); // for not logged in users
add_action('wp_ajax_listing_search', 'listing_search');
function listing_search()
{

	  // Verify nonce for security.
    if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
        wp_send_json_error('Nonce verification failed.');
    }
	$category = $_POST['category'];
	$price_sort = $_POST['price_sort'];
	$new_used = $_POST['new_used'];
	$berths = $_POST['berths'];
	$make = $_POST['make'];
	$model = $_POST['model'];
	$min_price = $_POST['min_price'];
	$max_price = $_POST['max_price'];
	$layout_type = $_POST['layout_type'];
	$width = $_POST['widthwidth'];
	$year = $_POST['year'];
	$axle = $_POST['axle'];


	$args = array(
		'post_type' => 'caravan',
		'posts_per_page' => 10,
		'tax_query' => array(
			array(
				'taxonomy' => 'listing_category',
				'field' => 'term_id',
				'terms' => $category,
			),
		),
	);
	$listings = new WP_Query($args);

	echo '<pre>';
	var_dump($args);
	echo '</pre>';

?>
	<?php
	die();
}
