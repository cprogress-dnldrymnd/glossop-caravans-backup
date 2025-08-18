<?php
add_action('wp_ajax_nopriv_listing_search', 'listing_search'); // for not logged in users
add_action('wp_ajax_listing_search', 'listing_search');
function listing_search()
{
	echo $price_sort = $_POST['price_sort'];
	echo $new_used = $_POST['new_used'];
	echo $berths = $_POST['berths'];
	echo $make = $_POST['make'];
	echo $model = $_POST['model'];
	echo $min_price = $_POST['min_price'];
	echo $max_price = $_POST['max_price'];
	echo $layout_type = $_POST['layout_type'];
	echo $width = $_POST['widthwidth'];
	echo $year = $_POST['year'];
	echo $axle = $_POST['axle'];
	echo $taxonomy_terms = $_POST['taxonomy_terms'];

?>
	<?php
	die();
}
