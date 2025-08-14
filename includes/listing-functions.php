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

function listing__features($id, $hide_per_month = false)
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

function listing__price($rrp = '33795', $our_price = '42200', $savings = '1955', $per_month = false)
{
    ob_start();
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
                        <strong class="text-orange-3"><?= price__format($per_month) ?></strong>
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
        <div class="listing-grid--feature--action  listing-grid--feature--action--style-2 d-flex d-lg-none">
            <div class="listing-grid__feature fs-13 row g-xxs fw-semibold">
                <div class="listing-grid__feature-item col-auto">
                    <div
                        class="grid__feature-inner rounded h-100 d-flex align-items-center justify-content-center text-center">
                        Finance available: 7.9% APR
                    </div>
                </div>
                <div class="listing-grid__feature-item col-auto">
                    <div
                        class="grid__feature-inner rounded h-100 d-flex flex-column align-items-center justify-content-center text-center">
                        <span class="fs-7 fw-medium">Per month</span>
                        £565.50
                    </div>
                </div>
            </div>
            <?php
            echo listing__action(false);
            ?>
        </div>
        <div class="swiper <?= $is_thumbnail == false ? 'swiper-gallery h-100' : 'swiper-thumbnails' ?>">
            <div class="swiper-wrapper <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                <?php foreach ($images as $image) { ?>
                    <div class="swiper-slide <?= $is_thumbnail == false ? 'h-100' : '' ?>">
                        <a href="<?= wp_get_attachment_image_url($image, 'full') ?>" <?= $is_thumbnail == false ? 'data-fancybox="gallery-' . $id . '"' : '' ?>
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

function listing__key_information($id)
{
    ob_start();
    $berths = get__post_meta_by_id($id, 'berths');
    $axle = get__post_meta_by_id($id, 'axle');
    $year = get__post_meta_by_id($id, 'year');
    $warranty = get__post_meta_by_id($id, 'warranty');
    $weight = get__post_meta_by_id($id, 'weight');
    $awning_size = get__post_meta_by_id($id, 'awning_size');
    $internal_length = get__post_meta_by_id($id, 'internal_length');
    $external_length = get__post_meta_by_id($id, 'external_length');
    $width = get__post_meta_by_id($id, 'width');
    $internal_stock_number = get__post_meta_by_id($id, 'internal_stock_number');
    $chassis_no = get__post_meta_by_id($id, 'chassis_no');
?>
    <ul
        class="icon-list mb-0 icon-list-v2 d-flex list-inline align-items-center justify-content-end fw-semibold flex-wrap fs-18">
        <?php if ($internal_stock_number) { ?>
            <li><?= get__theme_icons('year.svg') ?> <?= $internal_stock_number ?> Stock Number</li>
        <?php } ?>
        <?php if ($berths) { ?>
            <li> <?= get__theme_icons('berths.svg') ?> <?= $berths ?> Berth</li>
        <?php } ?>
        <?php if ($warranty) { ?>
            <li><?= get__theme_icons('warranty.svg') ?> <?= $warranty ?></li>
        <?php } ?>
        <?php if ($year) { ?>
            <li><?= get__theme_icons('year.svg') ?> <?= $year ?> Year</li>
        <?php } ?>


        <?php if ($internal_length) { ?>
            <li><?= get__theme_icons('Caravan-Internal-Length.svg') ?> <?= $internal_length ?>m Internal Length</li>
        <?php } ?>
        <?php if ($internal_length) { ?>
            <li><?= get__theme_icons('Caravan-External-Length.svg') ?> <?= $external_length ?>m External Length</li>
        <?php } ?>
        <?php if ($width) { ?>
            <li><?= get__theme_icons('Caravan-External-Width.svg') ?> <?= $width ?>m Width</li>
        <?php } ?>



        <?php if ($axle) { ?>
            <li>
                <span class="icons">
                    <?php if ($axle == 'Twin Axle') { ?>
                        <?= get__theme_icons('tire.svg') ?>
                    <?php } ?>
                    <?= get__theme_icons('tire.svg') ?>
                </span>
                <?= $axle ?>
            </li>
        <?php } ?>
        <?php if ($weight) { ?>
            <li><?= get__theme_icons('kg.svg') ?> MTPLM <?= $weight ?>kg</li>
        <?php } ?>
        <?php if ($awning_size) { ?>
            <li><?= get__theme_icons('awning-size.svg') ?> <?= $awning_size ?> Awning Size</li>
        <?php } ?>
    </ul>
<?php
    return ob_get_clean();
}


function listing__key_information_v2()
{
    ob_start();
?>
    <ul
        class="icon-list mb-0 icon-list-v2 d-flex list-inline align-items-center justify-content-end fw-semibold flex-wrap fs-18">
        <li class="border-bottom py-1 py-lg-3"> <?= get__theme_images('berths.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>Berth</span>
                <span>6</span>
            </span>
        </li>
        <li class="border-bottom py-1 py-lg-3"><?= get__theme_images('year.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>Unladen Weight</span>
                <span>1450kg</span>
            </span>
        </li>
        <li class="border-bottom py-1 py-lg-3"><?= get__theme_images('year.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>Year</span>
                <span>2024</span>
            </span>
        </li>
        <li class="border-bottom py-1 py-lg-3"><?= get__theme_images('kg.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>MTPLM</span>
                <span>1630kg</span>
            </span>
        </li>
        <li class="border-bottom py-1 py-lg-3"><?= get__theme_images('awning-size.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>Awning Size</span>
                <span>10.52m</span>
            </span>
        </li>
        <li class="border-bottom py-1 py-lg-3"><?= get__theme_images('dimensions.svg') ?>
            <span class="col d-flex justify-content-between">
                <span>Dimensions</span>
                <span>L 7.98m x W 2.25m</span>
            </span>
        </li>
    </ul>
    <?php
    return ob_get_clean();
}


function listing_manufacturer_logo()
{
    ob_start();
    $manufacturer = get_the_terms(get_the_ID(), 'manufacturer');
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
