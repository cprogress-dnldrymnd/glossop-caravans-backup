<?php
add_action('wp_ajax_nopriv_listing_search', 'listing_search'); // for not logged in users
add_action('wp_ajax_listing_search', 'listing_search');
function listing_search()
{
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
		/*'meta_query' => array(
        array(
            'key' => 'listing_features:berths/listing_feature',
            'value' => '4',
        ),
    ),*/
		'tax_query' => array(
			array(
				'taxonomy' => 'listing_category',
				'field' => 'term_id',
				'terms' => $term_ids,
			),
		),
	);
	$listings = new WP_Query($args);

?>
	<?php
	die();
}
