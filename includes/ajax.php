<?php
add_action('wp_ajax_nopriv_listing_search', 'listing_search'); // for not logged in users
add_action('wp_ajax_listing_search', 'listing_search');
function listing_search()
{

	// Verify nonce for security.
	if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
		wp_send_json_error('Nonce verification failed.');
	}
	$category = isset($_POST['category']) ? $_POST['category'] : false;
	$price_sort = isset($_POST['price_sort']) ? $_POST['price_sort'] : false;
	$new_used = isset($_POST['new_used']) ? $_POST['new_used'] : false;
	$berths = isset($_POST['berths']) ? $_POST['berths'] : false;
	$make = isset($_POST['make']) ? $_POST['make'] : false;
	$model = isset($_POST['model']) ? $_POST['model'] : false;
	$min_price = isset($_POST['min_price']) ? $_POST['min_price'] : false;
	$max_price = isset($_POST['max_price']) ? $_POST['max_price'] : false;
	$width = isset($_POST['widthwidth']) ? $_POST['widthwidth'] : false;
	$year = isset($_POST['year']) ? $_POST['year'] : false;
	$axle = isset($_POST['axle']) ? $_POST['axle'] : false;
	$field_id = isset($_POST['field_id']) ? $_POST['field_id'] : false;
	$filter_active = isset($_POST['filter_active']) ? $_POST['filter_active'] : false;

	$tax_query = [];
	$meta_query = [];

	if ($new_used) {
		$meta_query[] = 	array(
			'key'     => '_new_used',
			'value'   => $new_used,
			'compare' => '='
		);
	}
	if ($berths) {
		$meta_query[] = 	array(
			'key'     => '_berths',
			'value'   => $berths,
			'compare' => '='
		);
	}
	if ($model) {
		$meta_query[] = 	array(
			'key'     => '_model',
			'value'   => $model,
			'compare' => '='
		);
	}

	if ($width) {
		$meta_query[] = 	array(
			'key'     => '_width',
			'value'   => $width,
			'compare' => '='
		);
	}
	if ($year) {
		$meta_query[] = 	array(
			'key'     => '_year',
			'value'   => $year,
			'compare' => '='
		);
	}
	if ($axle) {
		$meta_query[] = 	array(
			'key'     => '_axle',
			'value'   => $axle,
			'compare' => '='
		);
	}
	if ($min_price) {
		$meta_query[] = 	array(
			'key'     => '_our_price',
			'value'   => $min_price,
			'type'    => 'numeric',
			'compare' => '>='
		);
	}

	if ($max_price) {
		$meta_query[] = 	array(
			'key'     => '_our_price',
			'value'   => $max_price,
			'type'    => 'numeric',
			'compare' => '<='
		);
	}

	if ($price_sort) {
		if ($price_sort == 'price-desc' || $price_sort == 'price-asc') {
			$args['meta_key'] = '_our_price';
			$args['orderby'] = 'meta_value_num';
		}
		if ($price_sort == 'name-asc' || $price_sort == 'name-desc') {
			$args['orderby'] = 'title';
		}

		if ($price_sort == 'price-desc' || $price_sort == 'name-desc') {
			$args['order'] = 'desc';
		}
		if ($price_sort == 'price-asc' || $price_sort == 'name-asc') {
			$args['order'] = 'asc';
		}
	}


	$tax_query[] = array(
		'taxonomy' => 'listing_category',
		'field' => 'term_id',
		'terms' => $category,
	);
	if ($make) {
		$tax_query[] = array(
			'taxonomy' => 'manufacturer',
			'field' => 'slug',
			'terms' => $make,
		);
	}



	$args['post_type'] = 'caravan';
	$args['posts_per_page'] = 10;

	if (!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}
	if (!empty($meta_query)) {
		$args['meta_query'] = $meta_query;
	}

	$listings = new WP_Query($args);
	$count = $listings->found_posts;
	$html = '' . $filter_active;
	if ($listings->have_posts()) {
		while ($listings->have_posts()) {
			$listings->the_post();
			$html .= '<div class="listing-item" id="swiper-gallery-1">';
			$html .=  listing_grid_full_details(get_the_ID(), $category);
			$html .= '</div>';
		}
		wp_reset_postdata();
	} else {
		$html .= '<div class="no-found-listing">';
		$html .= '<p> No listing found on your search filter. </p>';
		$html .= '</div>';
	}
	$response_data = array(
		'status'  => 'success',
		'filter_options' => filter_options($args, $field_id, $filter_active),
		'listing_count' => $count,
		'html' => $html,
	);

	// Use wp_send_json_success() to return the JSON object
	wp_send_json_success($response_data);
	die();
}
/*
add_action('wp_ajax_nopriv_model_options', 'model_options'); // for not logged in users
add_action('wp_ajax_model_options', 'model_options');


function model_options()
{

	// Verify nonce for security.
	if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
		wp_send_json_error('Nonce verification failed.');
	}
	$make = isset($_POST['make']) ? $_POST['make'] : false;
	$category = isset($_POST['make']) ? $_POST['category'] : false;
	$model_options = get_model_options($make, $category);
	echo listing__filter_field('model', 'Model', 'Any', $model_options);
	die();
}*/

function filter_options($args, $field_id, $filter_active)
{
	ob_start();
	unset($args['posts_per_page']);
	$field_id_val = '#' . $field_id;
	$args['numberposts'] = -1;
	$args['fields'] = 'ids';

	$posts = get_posts($args);
	$css = [];
	$filter_active = intval($filter_active);
	foreach ($posts as $post) {
		$css['#berths'][] = get__post_meta_by_id($post, 'berths');
		$css['#new_used'][] = get__post_meta_by_id($post, 'new_used');
		$css['#model'][] = get__post_meta_by_id($post, 'model');
		$css['#min_price'][] = get__post_meta_by_id($post, 'our_price');
		$css['#max_price'][] = get__post_meta_by_id($post, 'our_price');
		$css['#width'][] = get__post_meta_by_id($post, 'width');
		$css['#year'][] = get__post_meta_by_id($post, 'year');
		$css['#axle'][] = get__post_meta_by_id($post, 'axle');

		$manufacturer = get_the_terms($post, 'manufacturer');
		foreach ($manufacturer as $maker) {
			$css['#make'][] = $maker->slug;
		}
		if ($filter_active > 0) {
		}
	}
	if ($filter_active == 2) {
		unset($css[$field_id_val]);
	}

	$html = '<style id="filter--options-style">';
	foreach ($css as $key => $css_val) {
		$css_val_format = css_val_format($css_val);
		$html .= $key . " option:not([value=''])$css_val_format{display: none !important}";
	}
	$html .= '<style>';

	echo $html;

	return ob_get_clean();
}

function css_val_format($css_val)
{
	$html = '';
	foreach ($css_val as $css) {
		$html .= ':not([value="' . $css . '"])';
	}
	return $html;
}
