<div class="listing-grid h-100 position-relative rounded <?= $args['style'] ?>">
    <div class="listing-grid-item__top position-relative">
        <h3>Swift Elegance Grande 780</h3>
        <div class="desc mb-3 mt-3">
            <p>Step into luxury with the Swift Elegance Grande 780.</p>
        </div>

        <div class="listing-grid--feature--action listing-grid--feature--action--style-2">
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
        </div>



        <div class="listing-grid__image image-style">
            <?= wp_get_attachment_image($args['image_id'], 'large') ?>
        </div>
    </div>
    <div class="listing-grid-item__bottom">
        <?= listing__price(get_the_ID()) ?>
        <div class="listing-grid-item__button mt-3">
            <a href="https://newglossopacaravans.theprogressteam.co.uk/listing-inner" class="btn btn-primary w-100 btn-lg btn-hover-bordered text-hover-orange">
                View deal
            </a>
        </div>
    </div>
</div>