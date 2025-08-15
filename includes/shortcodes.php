<?php

function latest_deals()
{
    ob_start();
    get_template_part('template-parts/shortcodes/latest-deals');
    return ob_get_clean();
}

add_shortcode('latest_deals', 'latest_deals');


function search_stock()
{
    ob_start();
    get_template_part('template-parts/header/search-stock');
    return ob_get_clean();
}
add_shortcode('search_stock', 'search_stock');
