jQuery(document).ready(function () {
    swiper_sliders();
    fancybox();
    mega_menu();
    search_stock();
    listings();
    header_distance();
    margin__Left();
    fixed_menu_link_mobile();
    read__more();
    listing_search_trigger();
    price_range();
    listing_filter_reset();

    //jQuery('.listing-search--trigger').select2();
});

function listing_filter_reset() {
    jQuery('.reset--filter').click(function (e) {
        jQuery('.listing-filter select').each(function (index, element) {
            jQuery(this).val('');
            if (jQuery(this).attr('id') == 'price_sort') {
                $val_text = 'Default';
            } else {
                $val_text = 'Any';
            }
            jQuery(this).parents('.accordion-item').find('.selected--option').text($val_text);
        });
        $min_range = jQuery('.min-range').attr('min');
        $max_range = jQuery('.max-range').attr('max');
        jQuery('.min-range').val($min_range);
        jQuery('.max-range').val($max_range);
        jQuery('.price-slider').css('left', '0');
        jQuery('.price-slider').css('right', '0');
        jQuery(".min-input-html").text($min_range);
        jQuery(".max-input-html").text($max_range);
        jQuery('.accordion-item--price .selected--option').text('Any');
        jQuery('.accordion-item--sortby select').trigger('change');
        jQuery('.reset-filter-holder').addClass('hidden');
        e.preventDefault();
    });
}
function price_range() {
    $ = jQuery;
    const rangevalue = $(".slider .price-slider");
    const min_input_html = $(".min-input-html");
    const max_input_html = $(".max-input-html");
    const rangeInputvalue = $(".range-input input");
    const priceInputvalue = $(".price-input input");
    const priceGap = 500;

    // Get the minimum and maximum possible values from the range inputs
    const minPossible = parseInt(rangeInputvalue.eq(0).attr('min'));
    const maxPossible = parseInt(rangeInputvalue.eq(0).attr('max'));
    const rangeTotal = maxPossible - minPossible;

    // Adding event listeners to price input elements
    priceInputvalue.on("input", function (e) {
        let minp = parseInt(priceInputvalue.eq(0).val());
        let maxp = parseInt(priceInputvalue.eq(1).val());
        let diff = maxp - minp;

        // Validate the input values against the range's min and max
        if (minp < minPossible) {
            alert(`minimum price cannot be less than ${minPossible}`);
            priceInputvalue.eq(0).val(minPossible);
            minp = minPossible;
        }

        if (maxp > maxPossible) {
            alert(`maximum price cannot be greater than ${maxPossible}`);
            priceInputvalue.eq(1).val(maxPossible);
            maxp = maxPossible;
        }

        if (minp > maxp - priceGap) {
            priceInputvalue.eq(0).val(maxp - priceGap);
            minp = maxp - priceGap;
            if (minp < minPossible) {
                priceInputvalue.eq(0).val(minPossible);
                minp = minPossible;
            }
        }

        // Check if the price gap is met and max price is within the range
        if (diff >= priceGap && maxp <= maxPossible) {
            if ($(this).hasClass("min-input")) {
                rangeInputvalue.eq(0).val(minp);
                rangevalue.css('left', `${((minp - minPossible) / rangeTotal) * 100}%`);
            } else {
                rangeInputvalue.eq(1).val(maxp);
                rangevalue.css('right', `${100 - (((maxp - minPossible) / rangeTotal) * 100)}%`);
            }
        }
    });

    // Add event listeners to range input elements
    rangeInputvalue.on("input", function (e) {
        let minVal = parseInt(rangeInputvalue.eq(0).val());
        let maxVal = parseInt(rangeInputvalue.eq(1).val());
        let diff = maxVal - minVal;

        // Check if the price gap is exceeded
        if (diff < priceGap) {
            // Check if the input is the min range input
            if ($(this).hasClass("min-range")) {
                rangeInputvalue.eq(0).val(maxVal - priceGap);
            } else {
                rangeInputvalue.eq(1).val(minVal + priceGap);
            }
        } else {
            // Update price inputs and range progress
            priceInputvalue.eq(0).val(minVal);
            priceInputvalue.eq(1).val(maxVal);
            min_input_html.text(minVal);
            max_input_html.text(maxVal);
            rangevalue.css('left', `${((minVal - minPossible) / rangeTotal) * 100}%`);
            rangevalue.css('right', `${100 - (((maxVal - minPossible) / rangeTotal) * 100)}%`);
        }
    });
}
function listing_search_trigger() {

    jQuery('body').on('change', '.listing-filter .listing-search--trigger', function (e) {
        var filter_active = '';
        jQuery('html, body').animate({
            scrollTop: jQuery('#listings').offset().top
        }, 800);

        if (jQuery(this).attr('id') == 'min_price' || jQuery(this).attr('id') == 'max_price') {
            $min_price = jQuery('.min-input-html').text();
            $max_price = jQuery('.max-input-html').text();



            if ($max_price && $min_price) {
                if ($max_price == $min_price) {
                    $val_text = '£' + $min_price;
                } else {
                    $val_text = '£' + $min_price + '-£' + $max_price;
                }
            } else if ($max_price && !$min_price) {
                $val_text = 'Up to £' + $max_price;
            } else if (!$max_price && $min_price) {
                $val_text = 'From £' + $min_price;
            } else {
                $val_text = 'Any'
            }


            if ($val_text == 'Any') {
                jQuery(this).parents('.accordion-item').removeClass('filter-item--active');
            } else {
                jQuery(this).parents('.accordion-item').addClass('filter-item--active');
            }

        } else {
            $val = jQuery(this).val();
            $val_text = jQuery(this).parents('.accordion-item').find('select option[value="' + $val + '"]').text();

            if ($val != '') {
                jQuery(this).parents('.accordion-item').addClass('filter-item--active');
            } else {
                jQuery(this).parents('.accordion-item').removeClass('filter-item--active');
            }

        }
        jQuery('.filter-item--active:not(.accordion-item--sortby) select').each(function (index, element) {
            filter_active += '#' + jQuery(this).attr('id') + '|';
        });


        if (jQuery(this).attr('id') == 'make') {
            model = '';
        } else {
            model = jQuery('.listing-filter #model').val();
        }



        jQuery(this).parents('.accordion-item').find('.selected--option').text($val_text);

        if (jQuery('.filter-item--active').length > 0) {
            jQuery('.reset-filter-holder').removeClass('hidden');
        }

        const nonce = posts_vars.nonce;

        category = jQuery('#category').val();
        price_sort = jQuery('#price_sort').val();
        new_used = jQuery('.listing-filter #new_used').val();
        berths = jQuery('#berths').val();
        make = jQuery('.listing-filter #make').val();
        min_price = jQuery('.listing-filter #min_price').val();
        max_price = jQuery('.listing-filter #max_price').val();
        width = jQuery('#width').val();
        year = jQuery('#year').val();
        axle = jQuery('#axle').val();
        field_id = jQuery(this).attr('id');
        data = {
            action: 'listing_search',
            nonce: nonce,
            category: category,
            price_sort: price_sort,
            new_used: new_used,
            berths: berths,
            make: make,
            model: model,
            min_price: min_price,
            max_price: max_price,
            width: width,
            year: year,
            axle: axle,
            field_id: field_id,
            filter_active: filter_active,
        };
        jQuery('.ajax--section-js').addClass('is--doing-ajax');
        jQuery('.loading').removeClass('hidden');
        jQuery('#results').addClass('hidden-visibility');
        ajax_function(data);
        jQuery('.listing-filter').addClass('filter--active')
        e.preventDefault();
    });
}


function listing_search(response) {

    $selectors = JSON.parse(response.data.filter_options_script);

    $.each($selectors, function (i) {
        jQuery($selectors[i]).addClass('hidden');
    });

    jQuery('#results .listings > div').remove();
    jQuery('.listing--count').text(response.data.listing_count);
    jQuery('#results .listings').html(response.data.html);

    jQuery('.ajax--section-js').removeClass('is--doing-ajax');

    jQuery('html, body').animate({
        scrollTop: jQuery('#listings').offset().top
    }, 800);

    jQuery('.loading').addClass('hidden');
    jQuery('#results').removeClass('hidden-visibility');
}

function ajax_function(data) {
    const ajaxurl = posts_vars.ajax_url;
    jQuery.ajax({
        url: ajaxurl, // WordPress AJAX URL
        type: 'POST',
        data: data,
        success: function (response) {
            if (data.action == 'listing_search') {
                listing_search(response);

            } else if (data.action == 'filter_options') {
                filter_options(response);

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Request Failed:', textStatus, errorThrown, jqXHR);

        }
    });
}



function read__more() {
    // Find the main container and all of its child items.
    const $container = jQuery('.read--more');
    const $items = $container.find('> *');
    const itemCount = $items.length;
    const visibleItems = 2;

    // Check if there are more items than the desired visible count.
    if (itemCount > visibleItems) {
        // Hide all child items starting from the third one.
        $items.slice(visibleItems).hide();

        // Create and append the "Read more" button.
        const $readMoreButton = jQuery('<a>')
            .text('Read more')
            .addClass('fw-semibold read-more-button');

        // Append the button to the container.
        $container.append($readMoreButton);

        // Add a click event handler to the "Read more" button.
        $readMoreButton.on('click', function () {
            // Show all the previously hidden items with a fade effect.
            $items.fadeIn(600);

            // Remove the "Read more" button after the items are shown.
            jQuery(this).remove();
        });
    }
}

function fixed_menu_link_mobile() {
    jQuery('li.wp-block-navigation-item:not(.has-custom-submenu) .wp-block-navigation-item__content').click(function (e) {
        $href = jQuery(this).attr('href');
        window.location.href = $href;
        console.log($href);
        e.preventDefault();
    });
}

function margin__Left() {
    $margin = jQuery('#main-header > div').css('margin-left');
    jQuery('body').css('--margin', $margin);
}



function listings() {
    if (jQuery('.nav-tabs-js').length > 0) {
        jQuery('.nav-tabs-js .nav-item:first-child .nav-link').click();
    }
}
function search_stock() {
    jQuery('.edit-stock-filter').click(function (e) {
        jQuery(this).parents('.search-stock-mobile').toggleClass('filter--active');
        e.preventDefault();

    });
}
function mega_submenu() {
    jQuery('#Motorhomes-Submenu').appendTo('.Motorhomes-Submenu');
    jQuery('#Caravans-Submenu').appendTo('.Caravans-Submenu');
    jQuery('#Export-Submenu').appendTo('.Export-Submenu');

    let highestHeight = 0;
    let highestElement = null;

    jQuery('.custom-submenu').each(function () {
        const currentHeight = jQuery(this).outerHeight(); // Use .outerHeight() to include padding and border

        if (currentHeight > highestHeight) {
            highestHeight = currentHeight;
            highestElement = jQuery(this).outerHeight();
        }
    });
    jQuery('body').css('--mega-menu-height', highestElement + 'px');
}

jQuery(window).scroll(function () {
    header_distance();
});

function header_distance() {
    var $element = jQuery('#masthead');
    var elementOffset = $element.offset().top;
    var scrollPosition = jQuery(window).scrollTop();
    var elementDistanceFromViewportTop = elementOffset - scrollPosition;
    jQuery('body').css('--header-distance', elementDistanceFromViewportTop + 'px');
}
function mega_menu() {
    mega_submenu();

    $height = jQuery('#main-header').outerHeight();
    $main_header_inner_height = jQuery('#main-header > div').outerHeight();
    jQuery('body').css('--header-height', $height + 'px');
    jQuery('body').css('--header-inner-height', $main_header_inner_height + 'px');

    if (window.innerWidth > 991) {
        jQuery('.has-custom-submenu').hover(function () {
            jQuery('body').addClass('mega-menu-active');
        }, function () {
            jQuery('body').removeClass('mega-menu-active');
        });
    } else {

        jQuery('.has-custom-submenu a').click(function (e) {
            jQuery(this).parent().toggleClass('active');
            e.preventDefault();
        });
        jQuery('.group-submenu-mobile > p').click(function (e) {
            jQuery(this).parent().toggleClass('active');
            e.preventDefault();
        });
    }



}

function fancybox() {
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });

    jQuery('.zoom').click(function (e) {
        jQuery(this).next().find('.swiper-slide-active a').addClass('sdsdss');
        jQuery(this).next().find('.swiper-slide-active a').trigger('click');
        e.preventDefault();
    });
}

function swiper_sliders() {
    var swiper = new Swiper(".swiper-listing", {
        loop: true, // Add this line
        breakpoints: {
            0: {
                slidesPerView: 'auto',
                spaceBetween: 12,
                freeMode: true,
            },


            992: {
                slidesPerView: 3,
                spaceBetween: 20,
            },

        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    $key = 1;

    if (jQuery('.swiper-thumbnails').length > 0) {

        if (window.innerWidth > 991) {
            $height = jQuery('.swiper-gallery').outerHeight();

            jQuery('.swiper-thumbnails').css('height', $height + 'px');
            var swiper_thumb = new Swiper(".swiper-thumbnails", {
                direction: "vertical",
                spaceBetween: 10,
                slidesPerView: 'auto',
                freeMode: true,
                watchSlidesProgress: true,
            });
        } else {
            var swiper_thumb = new Swiper(".swiper-thumbnails", {
                spaceBetween: 5,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });
        }



        var swiper_gallery = new Swiper('.swiper-gallery', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            thumbs: {
                swiper: swiper_thumb,
            },
            navigation: {
                nextEl: '.swiper-gallery-next',
                prevEl: '.swiper-gallery-prev',
            },
            pagination: {
                el: '.swiper-gallery-pagination',
                type: "fraction",
            },
        });
        $key++;
    } else {
        jQuery('.swiper-gallery').each(function (index, element) {
            var $id = 'swiper' + $key;
            jQuery(this).attr('id', $id);
            jQuery(this).find('.swiper-button-next').attr('id', $id + '-next');
            jQuery(this).find('.swiper-button-prev').attr('id', $id + '-prev');
            jQuery(this).find('.swiper-pagination').attr('id', $id + '-pagination');

            var $id = new Swiper('#' + $id, {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                navigation: {
                    nextEl: '#' + $id + '-next',
                    prevEl: '#' + $id + '-prev',
                },
                pagination: {
                    el: '#' + $id + '-pagination',
                    type: "fraction",
                },
            });
            $key++;
        });
    }
    jQuery('.nav-tabs-swiper .swiper-slide').each(function (index, element) {
        $width = jQuery(this).find('.nav-link').outerWidth();
        jQuery(this).css('width', $width + 'px');
    });
    var swiper_on_mobile = new Swiper('.nav-tabs-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        freeMode: true,
    });

    if (window.innerWidth < 992) {
        jQuery('.swiper-on-mobile').addClass('swiper swiper-on-mobile-js');
        jQuery('.swiper-on-mobile > *').addClass('swiper-wrapper');
        jQuery('.swiper-on-mobile > * > *').addClass('swiper-slide');
        var swiper_on_mobile = new Swiper('.swiper-on-mobile-js', {
            slidesPerView: 'auto',
            spaceBetween: 12,
            freeMode: true,

        });
    }
    if (window.innerWidth < 992) {
        jQuery('.swiper-on-mobile-2').addClass('swiper swiper-on-mobile-2-js');
        jQuery('.swiper-on-mobile-2 > *').addClass('swiper-wrapper');
        jQuery('.swiper-on-mobile-2 > * > *').removeClass().addClass('swiper-slide');
        jQuery('<div class="swiper-button-next"></div><div class="swiper-button-prev"></div>').appendTo('.swiper-on-mobile-2');
        var swiper_on_mobile2 = new Swiper('.swiper-on-mobile-2-js', {
            slidesPerView: 1,
            autoplay: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
    if (jQuery('.swiper-hero-slider').length > 0) {
        jQuery('.swiper-hero-slider img').removeAttr('srcset');
        jQuery('<div class="swiper-button-next swiper-button"></div><div class="swiper-button-prev swiper-button"></div>').appendTo('.swiper-hero-slider');
        var swiper_hero_slider = new Swiper('.swiper-hero-slider', {
            slidesPerView: 1,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
    if (jQuery('.swiper--timeline').length > 0) {
        jQuery('.swiper--timeline-thumbs .swiper-slide').each(function (index, element) {
            $width = jQuery(this).outerWidth();
            jQuery(this).css('width', $width + 'px !important');
        });
        jQuery('.swiper--timeline, .swiper--timeline *').removeClass('is-layout-constrained wp-block-group-is-layout-constrained');
        jQuery('.swiper--timeline-thumbs, .swiper--timeline-thumbs *').removeClass('is-layout-constrained wp-block-group-is-layout-constrained');
        var swiper_thumbs = new Swiper(".swiper--timeline-thumbs", {
            spaceBetween: 30,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper_timeline = new Swiper(".swiper--timeline", {
            spaceBetween: 0,
            slidesPerView: 1,
            thumbs: {
                swiper: swiper_thumbs,
            },
        });
    }


    if (jQuery('.swiper-listing-loop').length > 0) {

        jQuery('.swiper-listing-loop > *').removeAttr('class').addClass('swiper-wrapper');
        jQuery('.swiper-listing-loop > * > *').removeAttr('class').addClass('swiper-slide');

        var swipe_listing_loop = new Swiper(".swiper-listing-loop", {
            loop: true, // Add this line
            breakpoints: {
                0: {
                    slidesPerView: 'auto',
                    spaceBetween: 12,
                    freeMode: true,
                },


                992: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },

            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
}	