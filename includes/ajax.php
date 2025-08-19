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
	$layout_type = isset($_POST['layout_type']) ? $_POST['layout_type'] : false;
	$width = isset($_POST['widthwidth']) ? $_POST['widthwidth'] : false;
	$year = isset($_POST['year']) ? $_POST['year'] : false;
	$axle = isset($_POST['axle']) ? $_POST['axle'] : false;

	$tax_query = [];
	$meta_query = [];

	echo $new_used;
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
	if ($layout_type) {
		$meta_query[] = 	array(
			'key'     => '_layout_type',
			'value'   => $layout_type,
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
	echo filter_options($args);
	$count = $listings->found_posts;
	if ($listings->have_posts()) {
		while ($listings->have_posts()) {
			$listings->the_post();
?>
			<div class="listing-item" id="swiper-gallery-1">
				<?php
				echo listing_grid_full_details(get_the_ID(), $category);
				?>
			</div>
		<?php
		}
		wp_reset_postdata();
	} else {
		?>
		<div class="no-found-listing">
			<p>
				No listing found on your search filter.
			</p>
		</div>
	<?php
	}
	?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.listing--count').text('<?= $count ?>');
		});
	</script>
<?php

	die();
}


add_action('wp_ajax_nopriv_model_options', 'model_options'); // for not logged in users
add_action('wp_ajax_model_options', 'model_options');

/*
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

function filter_options($args)
{
	ob_start();
	unset($args['posts_per_page']);
	$args['numberposts'] = -1;
	$args['fields'] = 'ids';

	$posts = get_posts($args);
	foreach ($posts as $post) {
		$year = get__post_meta_by_id($post, 'year');
		echo $year;
	}
	echo '<pre>';
	var_dump($posts);
	echo '</pre>';
	return ob_get_clean();
}
