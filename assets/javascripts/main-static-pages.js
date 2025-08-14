jQuery(document).ready(function () {
    search_stock();
});

jQuery.ajax({
    url: 'https://newglossopacaravans.theprogressteam.co.uk/template/static-pages-header/?static_template=true', // Path to the HTML file you want to insert
    method: 'GET', // Or 'POST' if applicable, but 'GET' is standard for fetching templates
    dataType: 'html', // Expect HTML content
    success: function (data) {
        const $targetElement = jQuery('#main'); // Use jQuery to select the element
        if ($targetElement.length) { // Check if the element exists using jQuery's .length
            jQuery(data).prependTo($targetElement);
            mega_menu();
            jQuery('#form').appendTo('#insert-form');
            jQuery('body').addClass('show-body');
        } else {
            console.warn(`Element with selector "${elementSelector}" not found.`);
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error fetching or inserting the HTML:', textStatus, errorThrown);
        const $targetElement = jQuery(elementSelector);
        if ($targetElement.length) {
            $targetElement.html('<p>Error loading content.</p>');
        }
    }
});


jQuery.ajax({
    url: 'https://newglossopacaravans.theprogressteam.co.uk/template/static-pages-footer/?static_template=true', // Path to the HTML file you want to insert
    method: 'GET', // Or 'POST' if applicable, but 'GET' is standard for fetching templates
    dataType: 'html', // Expect HTML content
    success: function (data) {
        const $targetElement = jQuery('#main'); // Use jQuery to select the element
        if ($targetElement.length) { // Check if the element exists using jQuery's .length
            jQuery(data).appendTo($targetElement);
        } else {
            console.warn(`Element with selector "${elementSelector}" not found.`);
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error fetching or inserting the HTML:', textStatus, errorThrown);
        const $targetElement = jQuery(elementSelector);
        if ($targetElement.length) {
            $targetElement.html('<p>Error loading content.</p>');
        }
    }
});


function search_stock() {
    jQuery('.edit-stock-filter').click(function (e) {
        jQuery(this).parents('.search-stock-mobile').toggleClass('filter--active');
        e.preventDefault();

    });
}
function mega_submenu() {
    setTimeout(function () {

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
    }, 100);

}
function mega_menu() {
    mega_submenu();
    $height = jQuery('#main-header').outerHeight();
    $main_header_inner_height = jQuery('#main-header > div').outerHeight();
    $admin_bar = jQuery('#wpadminbar').outerHeight();
    jQuery('body').css('--header-height', $height + 'px');
    jQuery('body').css('--header-inner-height', $main_header_inner_height + 'px');
    if (jQuery('#wpadminbar').length > 0) {
        jQuery('body').css('--header-distance', $admin_bar + 'px');

    }
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