<?php

function listings_fields()
{
    global $listing_fields;

    $listing_fields['sortby'] = form_control(array(
        'type'    => 'select',
        'name'    => 'price_sort',
        'id'      => 'price_sort',
        'label'   => 'Sort by',
        'class'   => 'form-control-lg',
        'options' => array(
            ''         => 'Default',
            'price-asc'         => 'Price: Low to High',
            'price-desc' => 'Price: High to Low',
            'name-asc' => 'Name: A-Z',
            'name-desc' => 'Name: Z-A',
        ),
    ));


    $listing_fields['berths'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Berths',
        'id'      => 'Berths',
        'label'   => 'Berths',
        'class'   => 'form-control-lg',
        'options' => array(
            ''    => 'How many berths?',
            'All' => 'All',
            '2'   => '2',
            '3'   => '3',
            '4'   => '4',
            '5'   => '5',
            '6'   => '6',
        ),
    ));

    $listing_fields['make'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Make',
        'id'      => 'Make',
        'label'   => 'Make',
        'class'   => 'form-control-lg',
        'options' => array(
            ''         => 'Select Make',
            'Option 1' => 'Option 1',
            'Option 2' => 'Option 2',
            'Option 3' => 'Option 3',
            'Option 4' => 'Option 4',
            'Option 5' => 'Option 5',
            'Option 6' => ' Option6',
        ),
    ));
    $listing_fields['model'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Model',
        'id'      => 'Model',
        'label'   => 'Model',
        'class'   => 'form-control-lg',
        'options' => array(
            ''         => 'Select Model',
            'Option 1' => 'Option 1',
            'Option 2' => 'Option 2',
            'Option 3' => 'Option 3',
            'Option 4' => 'Option 4',
            'Option 5' => 'Option 5',
            'Option 6' => ' Option6',
        ),
    ));
    $listing_fields['price_min'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Price-Min',
        'id'      => 'Price-Min',
        'label'   => 'Price(min.)',
        'class'   => 'form-control-lg',
        'options' => array(
            '' => 'Any',
        ),
    ));
    $listing_fields['price_max'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Price-Max',
        'id'      => 'Price-Max',
        'label'   => 'Price(max.)',
        'class'   => 'form-control-lg',
        'options' => array(
            '' => 'Any',
        ),
    ));
}
add_action('after_setup_theme', 'listings_fields');

function listing__features($id, $hide_per_month = true)
{
    ob_start();
    $finance_available = get__post_meta_by_id($id, 'finance_available');
    if ($finance_available != '' || $hide_per_month != false) {
?>
        <div class="listing-grid__feature-holder">
            <div class="listing-grid__feature fs-13 row g-xxs fw-semibold">
                <?php if ($finance_available) { ?>
                    <div class="listing-grid__feature-item col-auto listing-grid__feature-finance">
                        <div class="grid__feature-inner rounded h-100 d-flex align-items-center justify-content-center text-center">
                            Finance available: <?= $finance_available ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!$hide_per_month) { ?>
                    <div class="listing-grid__feature-item listing-grid__feature-per-month col-auto">
                        <div
                            class="grid__feature-inner rounded h-100 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="fs-7 fw-medium">Per month</span>
                            £565.50
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
    } else {
        return false;
    }
    return ob_get_clean();
}

function listing__price($id, $per_month = true)
{
    ob_start();
    $rrp = get__post_meta_by_id($id, 'rrp');
    $our_price = get__post_meta_by_id($id, 'our_price');
    $savings =  $rrp - $our_price;
    ?>
    <div class="listing-grid-item__prices-holder">
        <div class="listing-grid-item__prices row g-xxs text-center">
            <?php if ($rrp) { ?>
                <div class="listing-grid-item__price col">
                    <div class="grid-item__price-inner rounded h-100">
                        <span class="fs-14">RRP</span>
                        <strong><?= price__format($rrp) ?></strong>
                    </div>
                </div>
            <?php } ?>

            <?php if ($our_price) { ?>
                <div class="listing-grid-item__price col">
                    <div class="grid-item__price-inner rounded h-100">
                        <span class="fs-14">Our price</span>
                        <strong><?= price__format($our_price) ?></strong>
                    </div>
                </div>
            <?php } ?>
            <?php if ($savings) { ?>
                <div class="listing-grid-item__price col">
                    <div class="grid-item__price-inner rounded h-100">
                        <span class="fs-14">Save</span>
                        <strong class="text-orange-3"><?= price__format($savings) ?></strong>
                    </div>
                </div>
            <?php } ?>
            <?php if ($per_month) { ?>
                <div class="listing-grid-item__price col">
                    <div class="grid-item__price-inner rounded h-100">
                        <span class="fs-14">Per month</span>
                        <strong class="text-orange"><?= price__format(500) ?></strong>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
<?php
    return ob_get_clean();
}
function price__format($value)
{
    return "£" . number_format($value, 2);
}
function listing__action($share = true, $save = false)
{
    ob_start();
?>
    <ul class="icon-list mb-0 d-flex list-inline align-items-center justify-content-end fw-semibold">
        <?php if ($share == true) { ?>
            <li><?= get__theme_images('share.svg') ?> Share</li>
        <?php } ?>
        <?php if ($save == true) { ?>
            <li><?= get__theme_images('save.svg') ?> Save</li>
        <?php } ?>

    </ul>
<?php
    return ob_get_clean();
}

function listing__gallery($id, $is_thumbnail = false, $images = 'default', $class = 'h-100')
{
    ob_start();

    $images = get__post_meta_by_id($id, 'images');
    $images_arr = explode("|", $images);
    $finance_available = get__post_meta_by_id($id, 'finance_available');
    if (!$images) {
        $images_arr = array('/wp-content/uploads/2025/08/glossop-placeholder.jpg');
    }
?>
    <div class="listing-grid--gallery <?= $class ?>">
        <div class="zoom d-none d-lg-flex">
            <?= get__theme_images('zoom.svg') ?>
        </div>
        <?php if ($finance_available) { ?>
            <div class="listing-grid--feature--action  listing-grid--feature--action--style-2 d-flex d-lg-none">
                <div class="listing-grid__feature fs-13 row g-xxs fw-semibold">
                    <div class="listing-grid__feature-item col-auto">
                        <div
                            class="grid__feature-inner rounded h-100 d-flex align-items-center justify-content-center text-center">
                            Finance available: 7.9% APR
                        </div>
                    </div>
                    <!--
                    <div class="listing-grid__feature-item col-auto">
                        <div
                            class="grid__feature-inner rounded h-100 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="fs-7 fw-medium">Per month</span>
                            £565.50
                        </div>
                    </div>-->
                </div>
                <?php
                echo listing__action(false);
                ?>
            </div>
        <?php } ?>
        <div class="swiper <?= $is_thumbnail == false ? 'swiper-gallery h-100' : 'swiper-thumbnails' ?>">
            <div class="swiper-wrapper <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                <?php foreach ($images_arr as $image) { ?>
                    <div class="swiper-slide <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                        <a href="<?= $image ?>" <?= $is_thumbnail == false ? 'data-fancybox="gallery-' . $id . '"' : '' ?>
                            class="d-block image-box image-style <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                            <img src="<?= $image ?>" alt="Caravan Image">
                        </a>
                    </div>
                <?php } ?>
            </div>
            <?php if ($is_thumbnail == false) { ?>
                <div class="swiper-button-next swiper-gallery-next swiper-button"></div>
                <div class="swiper-button-prev swiper-gallery-prev swiper-button"></div>
                <div class="swiper-pagination swiper-gallery-pagination"></div>
            <?php } ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}


function listing__key_information($id, $category = 'caravans', $show = ['berths', 'bedrooms', 'year', 'width', 'internal_length', 'external_length', 'chassis', 'mileage', 'gearbox', 'bhp', 'engine', 'length', 'mtplm', 'registered_keepers', 'new_used', 'internal_stock_number', 'awning_size', 'unladen_weight', 'axle', 'warranty', 'fuel_type', 'country_of_origin', 'driver_side', 'power_steering'])
{
    ob_start();
    if (in_array('berths', $show)) {
        $key_information[] = array(
            'id' => 'berths',
            'label' => 'Berths',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('bedrooms', $show)) {
        $key_information[] = array(
            'id' => 'bedrooms',
            'label' => 'Bedrooms',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('berths', $show)) {
        $key_information[] = array(
            'id' => 'year',
            'label' => 'Year',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('width', $show)) {
        $key_information[] = array(
            'id' => 'width',
            'label' => 'Width',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => array(
                'caravans' => 'caravan_width.svg',
                'static-caravans' => 'static_caravan_width.svg'
            )
        );
    }
    if (in_array('internal_length', $show)) {
        $key_information[] = array(
            'id' => 'internal_length',
            'label' => 'Internal Length',
            'show_on_listing_page' => true,
            'after' => 'm',
            'icon' => false

        );
    }
    if (in_array('external_length', $show)) {
        $key_information[] = array(
            'id' => 'external_length',
            'label' => 'External Length',
            'show_on_listing_page' => true,
            'after' => 'm',
            'icon' => false
        );
    }
    if (in_array('chassis', $show)) {
        $key_information[] = array(
            'id' => 'chassis',
            'label' => 'Chassis',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('mileage', $show)) {
        $key_information[] = array(
            'id' => 'mileage',
            'label' => 'Mileage',
            'show_on_listing_page' => true,
            'after' => ' miles',
            'icon' => false
        );
    }
    if (in_array('gearbox', $show)) {
        $key_information[] = array(
            'id' => 'gearbox',
            'label' => 'Gearbox',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('bhp', $show)) {
        $key_information[] = array(
            'id' => 'bhp',
            'label' => 'BHP',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('engine', $show)) {
        $key_information[] = array(
            'id' => 'engine',
            'label' => 'Engine',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('length', $show)) {
        $key_information[] = array(
            'id' => 'length',
            'label' => 'Length',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => array(
                'motorhomes' => 'motorhomes_length.svg',
                'static-caravans' => 'static_caravan_length.svg'
            )
        );
    }
    if (in_array('mtplm', $show)) {
        $key_information[] = array(
            'id' => 'mtplm',
            'label' => 'MTPLM',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('registered_keepers', $show)) {
        $key_information[] = array(
            'id' => 'registered_keepers',
            'label' => 'Registered Keepers',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('new_used', $show)) {
        $key_information[] = array(
            'id' => 'new_used',
            'label' => 'New/Used',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('internal_stock_number', $show)) {
        $key_information[] = array(
            'id' => 'internal_stock_number',
            'label' => 'Stock Number',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('awning_size', $show)) {
        $key_information[] = array(
            'id' => 'awning_size',
            'label' => 'Awning Size',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('unladen_weight', $show)) {
        $key_information[] = array(
            'id' => 'unladen_weight',
            'label' => 'Unladen Weight',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('axle', $show)) {
        $key_information[] = array(
            'id' => 'axle',
            'label' => '',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }
    if (in_array('warranty', $show)) {
        $key_information[] = array(
            'id' => 'warranty',
            'label' => '',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }



    if (in_array('fuel_type', $show)) {
        $key_information[] = array(
            'id' => 'fuel_type',
            'label' => 'Fuel Type',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }


    if (in_array('country_of_origin', $show)) {
        $key_information[] = array(
            'id' => 'country_of_origin',
            'label' => 'Country of Origin',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }


    if (in_array('driver_side', $show)) {
        $key_information[] = array(
            'id' => 'driver_side',
            'label' => 'Driver Side',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }

    if (in_array('power_steering', $show)) {
        $key_information[] = array(
            'id' => 'power_steering',
            'label' => 'Power Steering',
            'show_on_listing_page' => true,
            'after' => false,
            'icon' => false
        );
    }


?>
    <ul
        class="icon-list mb-0 icon-list-v2 d-flex list-inline align-items-center justify-content-end fw-semibold flex-wrap fs-18">
        <?php
        foreach ($key_information as $key_info) {
            $value = get__post_meta_by_id($id, $key_info['id']);
            if ($value) {
                if ($key_info['icon'] == false) {
                    $icon = get__theme_icons($key_info['id'] . '.svg');
                } else {
                    $term = get_term_by('term_id', $category, 'listing_category');
                    $icon = get__theme_icons($key_info['icon'][$term->slug]);
                }
                echo '<li class="key--info-' . $key_info['id'] . '">';
                echo $icon;
                echo '<span class="icon-list-text">';
                echo '<span class="icon-list-text_label">';
                echo $key_info['label'];
                echo ' ';
                echo '</span>';
                echo '<span class="icon-list-text_value">';
                echo $value;
                if ($key_info['after']) {
                    echo $key_info['after'];
                }
                echo '</span>';

                echo '</span>';
                echo '</li>';
            }
        }
        ?>
    </ul>
    <?php
    return ob_get_clean();
}



function listing_manufacturer_logo($id)
{
    ob_start();
    $manufacturer = get_the_terms($id, 'manufacturer');
    $logo = get__term_meta($manufacturer[0]->term_id, 'main_logo');
    if ($logo) {
    ?>
        <div class="image-box brand">
            <?= wp_get_attachment_image($logo, 'medium') ?>
        </div>
    <?php
    }
    return ob_get_clean();
}


function listing_grid_full_details($id, $category = 'caravans')
{
    ob_start();
    ?>
    <div class="listing-grid-full-details bg-white rounded overflow-hidden position-relative style-1">
        <div class="listing-grid--top d-none d-lg-block">
            <div class="listing-grid--top--manufacturer mb-3">
                <div class="row g-3 justify-content-between mb-1">
                    <div class="col-md-6">
                        <div class="image-box brand">
                            <?= listing_manufacturer_logo($id) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= listing__action() ?>
                    </div>
                </div>
            </div>
            <div class="row g-3 justify-content-between">
                <div class="col-md-12">
                    <h3 class="mb-0"><?= get_the_title($id) ?></h3>
                </div>
            </div>
        </div>
        <div class="listing-grid--bottom">
            <div class="row g-0">
                <div class="col-xl-7">
                    <div class="listing-grid--left-inner position-relative h-100">
                        <?php
                        echo listing__gallery($id);
                        ?>
                        <div class="d-none d-lg-block">
                            <?php
                            echo listing__price($id);
                            ?>
                        </div>

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="listing-grid--right-inner h-100 d-flex flex-column justify-content-between">
                        <div class="listing-grid-right-item--top listing-grid--right-inner d-flex flex-column">
                            <div class="listing-grid-right-item">
                                <!--<div class="image-box image-style mb-20 d-none d-lg-block" style="--fit: contain; --padding: 18%">
              <?= wp_get_attachment_image(189, 'large') ?>
            </div>-->
                                <h3 class="d-block d-lg-none"><?= get_the_title($id) ?></h3>
                                <div class="listing-inner--key-info d-none d-lg-block">
                                    <?php
                                    echo listing__key_information($id, $category, ['year', 'width', 'internal_length', 'external_length', 'internal_stock_number', 'berths']);
                                    ?>
                                </div>
                                <div class="d-block d-lg-none mt-3">
                                    <div class="listing-inner--key-info mb-3">
                                        <?php
                                        echo listing__key_information($id, $category, ['berths', 'bedrooms', 'year']);
                                        ?>
                                    </div>
                                    <?php
                                    echo listing__price($id);
                                    ?>
                                </div>
                            </div>
                            <?php if (listing__features($id, true) != false) { ?>
                                <div class="listing-grid-right-item listing-grid-top--last-item d-none d-lg-flex align-items-center">
                                    <?php
                                    echo listing__features($id, true);
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="listing-grid-right-item listing-grid-right-item--bottom">
                            <div class="row g-xxs">
                                <div class="col-lg-6">
                                    <div class="listing-grid-item__button h-100">
                                        <a href="<?= get_the_permalink($id) ?>" class="btn btn-primary w-100 btn-lg btn-hover-bordered text-hover-orange fw-semibold h-100 d-inline-flex align-items-center justify-content-center">
                                            View deal
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="listing-grid-item__button h-100">
                                        <a href="#" class="btn btn-outline-dark w-100 btn-lg fw-semibold h-100 d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#EnquireModal">
                                            Enquire now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}


function listing_grid($id, $category = 'caravan', $style = 'style-2')
{
    ob_start();
    $images = carbon_get_post_meta($id, 'images');
    $images_arr = explode("|", $images);
    $finance_available = get__post_meta_by_id($id, 'finance_available');
    if (!$images) {
        $images_arr = array('/wp-content/uploads/2025/08/glossop-placeholder.jpg');
    }
    $finance_available = get__post_meta_by_id($id, 'finance_available');
?>
    <div class="listing-grid h-100 position-relative rounded <?= $style ?>">
        <div class="listing-grid-item__top position-relative">
            <?php if ($style == 'style-1') { ?>
                <h3><?= get_the_title($id) ?></h3>
                <div class="desc mb-3 mt-3">
                    <p><?= get_the_excerpt($id) ?></p>
                </div>
            <?php } ?>

            <div class="listing-grid--feature--action listing-grid--feature--action--style-2">
                <div class="listing-grid__feature fs-13 row g-xxs fw-semibold">
                    <?php if ($finance_available) { ?>
                        <div class="listing-grid__feature-item col-auto">
                            <div
                                class="grid__feature-inner rounded h-100 d-flex align-items-center justify-content-center text-center">
                                Finance available: <?= $finance_available ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="listing-grid__feature-item col-auto">
                        <div
                            class="grid__feature-inner rounded h-100 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="fs-7 fw-medium">Per month</span>
                            £565.50
                        </div>
                    </div>
                </div>
                <?php
                if ($style == 'style-2') {
                    echo listing__action(false);
                }
                ?>
            </div>
            <div class="listing-grid__image image-style">
                <img src="<?= $images_arr['0'] ?>" alt="Listing Image">
            </div>
        </div>
        <div class="listing-grid-item__bottom">
            <?php if ($style == 'style-2') { ?>
                <h3 class="fs-23"><?= get_the_title($id) ?></h3>
                <div class="listing-grid--key-information listing-grid--key-information--simple mb-20">
                    <?php
                    echo listing__key_information($id, $category, ['berths', 'bedrooms', 'year']);
                    ?>
                </div>
            <?php } ?>
            <?= listing__price($id, false) ?>
            <div class="listing-grid-item__button mt-3">
                <a href="<?= get_the_permalink($id) ?>" class="btn btn-primary w-100 btn-lg btn-hover-bordered text-hover-orange">
                    View deal
                </a>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

function listing_sidebar_filter($category)
{
    ob_start();
    global $listing_fields;

    $_new_used = get__search_field_options('_new_used', [$category]);
    $_berths = get__search_field_options('_berths', [$category]);
    $_our_price = get__search_field_options('_our_price', [$category], 'price');
    $_year = get__search_field_options('_year', [$category]);
    $_width = get__search_field_options('_width', [$category]);
    $_axle = get__search_field_options('_axle', [$category]);
    $_model = get__search_field_options('_model', [$category]);
?>

    <div class="listing-filter sticky-element accordion-style-1">
        <div class="offcanvas offcanvas-end offcanvas-visible-desktop" tabindex="-1" id="offCanvasFilter" raria-labelledby="offCanvasFilterLabel">
            <div class="offcanvas-body">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <div class="accordion rounded overflow-hidden" id="accordionFilter">
                    <div class="accordion-item accordion-item--sortby">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSort-by" aria-expanded="false"
                                aria-controls="collapseSort-by">
                                <span class="accordion-button-inner">
                                    <span class="icon-text">
                                        <span class="icon"><?= get__theme_icons('sort-by.svg') ?></span>
                                        Sort by
                                    </span>
                                    <span class="selected selected--option fs-14 fw-bold">Default</span>
                                </span>
                            </button>
                        </h2>
                        <div id="collapseSort-by" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFilter">
                            <div class="accordion-body">
                                <?= $listing_fields['sortby'] ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo listing__filter_field('new_used', 'New-Used', 'Any', $_new_used);
                    echo listing__filter_field('berths', 'Berths', 'Any', $_berths);
                    echo listing__filter_field_terms('make', 'Make', 'manufacturer');
                    echo listing__filter_field('model', 'Model', 'Any', $_model);
                    ?>

                    <div class="accordion-item accordion-item--price">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-Array" aria-expanded="false" aria-controls="collapseBerths">
                                <span class="accordion-button-inner">
                                    <span class="icon-text">
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="28.39" height="28.637" viewBox="0 0 28.39 28.637">
                                                <path id="Icon_ionic-ios-pricetag" data-name="Icon ionic-ios-pricetag" d="M32.761,3.375H23.343a1.108,1.108,0,0,0-.782.322L7.215,19.282a2.211,2.211,0,0,0,0,3.119l8.967,8.967a2.211,2.211,0,0,0,3.119,0L34.639,15.79a1.108,1.108,0,0,0,.322-.782V5.582A2.2,2.2,0,0,0,32.761,3.375Zm-3.656,8.568a2.452,2.452,0,1,1,2.169-2.169A2.455,2.455,0,0,1,29.106,11.943Z" transform="translate(-6.571 -3.375)" fill="#202020"></path>
                                            </svg>
                                        </span>
                                        Price </span>
                                    <span class="selected selected--option fs-14 fw-bold">Any</span>
                                </span>
                            </button>
                        </h2>
                        <div id="collapse-Array" class="accordion-collapse collapse" data-bs-parent="#accordionFilter">
                            <div class="accordion-body accordion-body--search-field">
                                <?php
                                $_our_price = get__search_field_options('_our_price', [$category]);
                                $our_price_count = count($_our_price);
                                ?>
                                <div class="price-input">
                                    <div class="price-field">
                                        <span>Minimum Price</span>
                                        <input type="number" class="min-input" value="<?= reset($_our_price) ?>">
                                    </div>
                                    <div class="price-field">
                                        <span>Maximum Price</span>
                                        <input type="number" class="max-input" value="<?= end($_our_price) ?>">
                                    </div>
                                </div>
                                <div class="slider--parent">
                                    <div class="slider">
                                        <div class="price-slider"></div>
                                    </div>
                                    <!-- Slider -->
                                    <div class="range-input">
                                        <input type="range" class="min-range" min="0" max="10000" value="2500" step="1">
                <input type="range" class="max-range" min="0" max="10000" value="8500" step="1">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo listing__filter_field(['min_price', 'max_price'], 'Price', ['Min Price (£)', 'Max Price (£)'], $_our_price, true);
                    echo listing__filter_field('year', 'Year', 'Any', $_year);
                    echo listing__filter_field('width', 'Width', 'Any', $_width);
                    echo listing__filter_field('axle', 'Axles', 'Any', $_axle);
                    ?>
                </div>
            </div>
        </div>

    </div>
<?php
    return ob_get_clean();
}

function listing__filter_field($id, $label, $placeholder = '', $available_options, $is_price = false, $is_accordion = true)
{
    ob_start();
    if ($is_price == true) {
        $icon = 'our_price';
    } else {
        $icon = $id;
    }

    if ($is_price == true) {
        $placeholder_val = 'Any';
    } else {
        $placeholder_val = $placeholder;
    }
?>
    <?php if ($is_accordion) { ?>
        <div class="accordion-item accordion-item--<?= $id ?>">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-<?= $id ?>" aria-expanded="false"
                    aria-controls="collapseBerths">
                    <span class="accordion-button-inner">
                        <span class="icon-text">
                            <span class="icon"><?= get__theme_icons($icon . '.svg') ?></span>
                            <?= $label ?>
                        </span>
                        <span class="selected selected--option fs-14 fw-bold"><?= $placeholder_val ?></span>
                    </span>
                </button>
            </h2>
            <div id="collapse-<?= $id ?>" class="accordion-collapse collapse"
                data-bs-parent="#accordionFilter">
                <div class="accordion-body accordion-body--search-field d-flex gap-1">
                <?php
            }
            if ($is_price == true) {
                $options_min[''] = $placeholder[0];
                echo form_control(array(
                    'type'    => 'select',
                    'name'    => $id[0],
                    'id'      => $id[0],
                    'class'   => 'w-100 form-control-lg listing-search--trigger',
                    'options' => $options_min + $available_options
                ));
                $options_max[''] = $placeholder[1];
                echo form_control(array(
                    'type'    => 'select',
                    'name'    => $id[1],
                    'id'      => $id[1],
                    'class'   => 'w-100 form-control-lg listing-search--trigger',
                    'options' => $options_max + $available_options
                ));
            } else {
                $options[''] = $placeholder;
                $args = array(
                    'type'    => 'select',
                    'name'    => $id,
                    'id'      => $id,
                    'class'   => 'form-control-lg listing-search--trigger',
                    'options' => $options + $available_options
                );
                if ($is_accordion == false) {
                    $args['label'] = $label;
                }
                echo form_control($args);
            }
            if ($is_accordion) {
                ?>
                </div>
            </div>
        </div>
    <?php
            }
            return ob_get_clean();
        }


        function listing__filter_field_terms($id, $label, $taxonomy)
        {
            ob_start();
            $terms = get_terms(array(
                'taxonomy' => $taxonomy,
                'hide_empty' => true
            ));
            $options[''] = 'Any';

            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }

    ?>
    <div class="accordion-item accordion-item--<?= $id ?>">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse-<?= $id ?>" aria-expanded="false"
                aria-controls="collapseBerths">
                <span class="accordion-button-inner">
                    <span class="icon-text">
                        <span class="icon"><?= get__theme_icons($id . '.svg') ?></span>
                        <?= $label ?>
                    </span>
                    <span class="selected selected--option fs-14 fw-bold">Any</span>
                </span>
            </button>
        </h2>
        <div id="collapse-<?= $id ?>" class="accordion-collapse collapse"
            data-bs-parent="#accordionFilter">
            <div class="accordion-body">
                <?php
                $args = array(
                    'type'    => 'select',
                    'name'    => $id,
                    'id'      => $id,
                    'class'   => 'form-control-lg listing-search--trigger',
                    'options' => $options
                );
                echo form_control($args);
                ?>
            </div>
        </div>
    </div>
<?php
            return ob_get_clean();
        }


        function get__search_field_options($meta_key, $terms = 'caravans', $format = 'default', $post_type = 'caravan', $taxonomy = 'listing_category')
        {
            global $wpdb;
            // Sanitize the input to prevent SQL injection
            $meta_key = sanitize_text_field($meta_key);
            $post_type = sanitize_text_field($post_type);
            $taxonomy = sanitize_text_field($taxonomy);
            $term_slugs = array_map('sanitize_title_for_query', (array) $terms);

            // Build the query to get post IDs filtered by taxonomy and term slugs
            $sql_in_clause = "'" . implode("','", $term_slugs) . "'";

            $query_post_ids = "
        SELECT p.ID
        FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
        INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
        WHERE p.post_type = %s
        AND p.post_status = 'publish'
        AND tt.taxonomy = %s
        AND t.term_id IN ({$sql_in_clause})
    ";

            $prepared_post_ids_query = $wpdb->prepare($query_post_ids, $post_type, $taxonomy);
            $post_ids = $wpdb->get_col($prepared_post_ids_query);

            if (empty($post_ids)) {
                return [];
            }

            // Build the query to get unique meta values from the retrieved post IDs
            $post_ids_in_clause = implode(",", array_map('intval', $post_ids));

            $query_meta_values = "
        SELECT DISTINCT meta_value
        FROM {$wpdb->postmeta}
        WHERE meta_key = %s
        AND post_id IN ({$post_ids_in_clause})
        ORDER BY meta_value ASC
    ";

            $prepared_meta_values_query = $wpdb->prepare($query_meta_values, $meta_key);
            $unique_values = $wpdb->get_col($prepared_meta_values_query);

            $unique_values_arr = [];
            foreach ($unique_values as $unique_value) {
                if ($format == 'default') {
                    $val = $unique_value;
                } else {
                    $val = price__format($unique_value);
                }

                $unique_values_arr[$unique_value] = $val;
            }
            return $unique_values_arr;
        }

        function get_model_options($make, $category)
        {
            $tax_query = [];

            $args = array(
                'post_type' => 'caravan',
                'numberposts' => -1,
            );
            if ($category) {
                $tax_query[] = array(
                    'taxonomy' => 'listing_category',
                    'field' => 'term_id',
                    'terms' => $category,
                );
            }
            if ($make) {
                $tax_query[] = array(
                    'taxonomy' => 'manufacturer',
                    'field' => 'slug',
                    'terms' => $make,
                );
            }
            if ($tax_query) {
                $args['tax_query'] = $tax_query;
            }
            $posts = get_posts($args);
            $model_arr = [];
            foreach ($posts as $post) {
                $model = get__post_meta_by_id($post->ID, 'model');
                $model_arr[$model] = $model;
            }

            return $model_arr;
        }
