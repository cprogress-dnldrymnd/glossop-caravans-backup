<?php

function listings_fields()
{
    global $listing_fields;

    $listing_fields['sortby'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Type',
        'id'      => 'Type',
        'label'   => 'Type',
        'class'   => 'form-control-lg',
        'options' => array(
            ''         => 'Sort 1',
            'Option 1' => 'Option 1',
            'Option 2' => 'Option 2',
            'Option 3' => 'Option 3',
            'Option 4' => 'Option 4',
            'Option 5' => 'Option 5',
            'Option 6' => ' Option6',
        ),
    ));
    $listing_fields['type'] = form_control(array(
        'type'    => 'select',
        'name'    => 'Type',
        'id'      => 'Type',
        'label'   => 'Type',
        'class'   => 'form-control-lg',
        'options' => array(
            ''     => 'New or Used?',
            'New'  => 'New',
            'Used' => 'Used',
            'Both' => 'Both',
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

    $images = carbon_get_post_meta($id, 'images');
    $finance_available = get__post_meta_by_id($id, 'finance_available');
    if (!$images || empty($images)) {
        $images = array(
            array('image_url' => '/wp-content/uploads/2025/08/glossop-placeholder.jpg')
        );
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
                <?php foreach ($images as $image) { ?>
                    <div class="swiper-slide <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                        <a href="<?= $image['image_url'] ?>" <?= $is_thumbnail == false ? 'data-fancybox="gallery-' . $id . '"' : '' ?>
                            class="d-block image-box image-style <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                            <img src="<?= $image['image_url'] ?>" alt="Caravan Image">
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

function listing__key_information_simple($berths = 4, $year = 2024, $axle = false)
{
    ob_start();
?>
    <ul class="icon-list mb-0 icon-list-v4 d-flex list-inline align-items-center flex-wrap fs-18">
        <?php if ($berths) { ?>
            <li> <?= get__theme_images('berths.svg') ?> <?= $berths ?> Berth</li>
        <?php } ?>
        <?php if ($year) { ?>
            <li><?= get__theme_images('year.svg') ?> <?= $year ?> </li>
        <?php } ?>
        <?php if ($axle) { ?>
            <li>
                <?php if ($axle == 'Twin Axle') { ?>
                    <?= get__theme_images('axles.svg') ?>
                <?php } ?>
                <?= get__theme_images('axles.svg') ?>
                <?= $axle ?>
            </li>
        <?php } ?>
    </ul>
<?php
    return ob_get_clean();
}

function listing__key_information($id, $category = 'caravans')
{
    ob_start();
    $key_information[] = array(
        'id' => 'berths',
        'label' => 'Berths',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'bedrooms',
        'label' => 'Bedrooms',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'year',
        'label' => 'Year',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
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
    $key_information[] = array(
        'id' => 'internal_length',
        'label' => 'Internal Length',
        'show_on_listing_page' => true,
        'after' => 'm',
        'icon' => false

    );
    $key_information[] = array(
        'id' => 'external_length',
        'label' => 'External Length',
        'show_on_listing_page' => true,
        'after' => 'm',
        'icon' => false
    );

    $key_information[] = array(
        'id' => 'chassis',
        'label' => 'Chassis',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'mileage',
        'label' => 'Mileage',
        'show_on_listing_page' => true,
        'after' => ' miles',
        'icon' => false
    );

    $key_information[] = array(
        'id' => 'gearbox',
        'label' => 'Gearbox',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );


    $key_information[] = array(
        'id' => 'bhp',
        'label' => 'BHP',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );


    $key_information[] = array(
        'id' => 'engine',
        'label' => 'Engine',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );


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

    $key_information[] = array(
        'id' => 'mtplm',
        'label' => 'MTPLM',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );


    $key_information[] = array(
        'id' => 'registered_keepers',
        'label' => 'Registered Keepers',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'new_used',
        'label' => 'New/Used',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'internal_stock_number',
        'label' => 'Stock Number',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );

    $key_information[] = array(
        'id' => 'awning_size',
        'label' => 'Awning Size',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'unladen_weight',
        'label' => 'Unladen Weight',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );

    $key_information[] = array(
        'id' => 'axle',
        'label' => '',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );
    $key_information[] = array(
        'id' => 'warranty',
        'label' => '',
        'show_on_listing_page' => true,
        'after' => false,
        'icon' => false
    );



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
                    <h3><?= get_the_title($id) ?></h3>
                    <div class="desc">
                        <?= get_the_excerpt($id) ?>
                    </div>
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
                                <h3 class="d-block d-lg-none">Swift Sprite Quattro FB 2024</h3>
                                <div class="listing-inner--key-info d-none d-lg-block">
                                    <?php
                                    echo listing__key_information($id, $category);
                                    ?>
                                </div>
                                <div class="d-block d-lg-none mt-3">
                                    <div class="listing-inner--key-info mb-3">
                                        <?php
                                        echo listing__key_information_simple();
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


function listing_grid($id, $style = 'style-2')
{
    ob_start();
    $images = carbon_get_post_meta($id, 'images');
    if (!$images || empty($images)) {
        $images = array(
            array('image_url' => '/wp-content/uploads/2025/08/glossop-placeholder.jpg')
        );
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
                <img src="<?= $images['0']['image_url'] ?>" alt="Listing Imae">
            </div>
        </div>
        <div class="listing-grid-item__bottom">
            <?php if ($style == 'style-2') { ?>
                <h3 class="fs-23"><?= get_the_title($id) ?></h3>
                <div class="listing-grid--key-information mb-20">
                    <?php
                    echo listing__key_information_simple();
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
