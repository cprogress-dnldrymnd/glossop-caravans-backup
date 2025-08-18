<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Listing Page
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>
<?php
$category = carbon_get_the_post_meta('select_category');
$term_ids = [];

$term_ids[] = $category['0']['id'];

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

var_dump(carbon_get_post_meta(3579, 'images'));
?>
<div class="site-content listings ajax--section-js background-lightgray">
    <div class="container md-padding-top md-padding-bottom">
        <div class="listings-holder">
            <h2 class="mb-5">We found <span class="text-orange"><?= $listings->found_posts; ?></span> <?php the_title() ?> for you</h2>

            <div class="filter--mobile d-block d-lg-none fw-semibold">
                <div class="row g-xxs">
                    <div class="col-6">
                        <button class="btn-with-icon btn btn-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasFilter" aria-controls="offCanvasFilter">
                            <?= get__theme_icons('filter.svg') ?>
                            Filter
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn-with-icon btn btn-light w-100 border">
                            <?= get__theme_icons('sort-by.svg') ?>
                            Sort
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 position-relative" style="z-index: 3">
                    <input type="hidden" id="category" value="<?= $category['0']['id'] ?>">
                    <?= listing_sidebar_filter($category['0']['id']) ?>
                </div>
                <div class="col-lg-9">
                    <div class="banner mb-20">
                        <?= wp_get_attachment_image(188, 'full') ?>
                    </div>
                    <div class="loading hidden">
                        <span class="wpcf7-spinner"></span>
                    </div>
                    <div id="results">
                        <div class="listings d-flex flex-column" style="--padding: 37%">
                            <?php
                            while ($listings->have_posts()) {
                                $listings->the_post();
                            ?>
                                <div class="listing-item" id="swiper-gallery-1">
                                    <?php
                                    echo listing_grid_full_details(get_the_ID(), $category['0']['id']);
                                    ?>
                                </div>
                            <?php } ?>

                            <?php wp_reset_postdata(); ?>

                        </div>
                    </div>
                    <div class="banner mt-20">
                        <?= wp_get_attachment_image(191, 'full') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_template_part('template-parts/modals/enquire-form');
?>
<?php get_footer() ?>