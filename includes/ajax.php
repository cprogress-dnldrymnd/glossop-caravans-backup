<?php
add_action('wp_ajax_nopriv_listing_search', 'listing_search'); // for not logged in users
add_action('wp_ajax_listing_search', 'listing_search');
function listing_search()
{

	// Verify nonce for security.
	if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
		wp_send_json_error('Nonce verification failed.');
	}

	$response_data = array(
		'status'  => 'success',
		'message' => 'Data received successfully!',
		'items'   => array(
			'item1' => 'value1',
			'item2' => 'value2'
		)
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
	echo accordion__filter('model', 'Model', 'Any', $model_options);
	die();
}*/

function filter_options($args, $field_id)
{
	ob_start();
	unset($args['posts_per_page']);
	$field_id_val = '#' . $field_id;
	$args['numberposts'] = -1;
	$args['fields'] = 'ids';

	$posts = get_posts($args);
	$css = [];
	foreach ($posts as $post) {
		$css['#berths'][] = get__post_meta_by_id($post, 'berths');
		$css['#new_used'][] = get__post_meta_by_id($post, 'new_used');
		$css['#model'][] = get__post_meta_by_id($post, 'model');
		$css['#min_price'][] = get__post_meta_by_id($post, 'min_price');
		$css['#max_price'][] = get__post_meta_by_id($post, 'max_price');
		$css['#layout_type'][] = get__post_meta_by_id($post, 'layout_type');
		$css['#width'][] = get__post_meta_by_id($post, 'width');
		$css['#year'][] = get__post_meta_by_id($post, 'year');
		$css['#axle'][] = get__post_meta_by_id($post, 'axle');
	}
	unset($css[$field_id_val]);
	$html = '';
	foreach ($css as $key => $css_val) {
		$css_val_format = css_val_format($css_val);
		$html .= '<style style_id="' . $key . '">';
		$html .= $key . " option:not([value=''])$css_val_format{display: none !important}";
		$html .= '</style>';
	}

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
