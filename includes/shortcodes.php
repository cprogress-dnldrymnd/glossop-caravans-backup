<?php

function latest_deals()
{
    ob_start();
    get_template_part('template-parts/shortcodes/latest-deals');
    return ob_get_clean();
}

add_shortcode('latest_deals', 'latest_deals');


function listing_grid($atts)
{
    ob_start();
    extract(
        shortcode_atts(
            array(
                'style' => 'style-1',
                'image_id' => 47
            ),
            $atts
        )
    );
    $args['style'] = $style;
    $args['image_id'] = $image_id;
    get_template_part('template-parts/shortcodes/listing-grid', NULL, $args);
    return ob_get_clean();
}

add_shortcode('listing_grid', 'listing_grid');





function search_stock()
{
    ob_start();
    get_template_part('template-parts/header/search-stock');
    return ob_get_clean();
}
add_shortcode('search_stock', 'search_stock');
