jQuery(document).ready(function ($) {
    load_more_button_listener();
    ajax_form();
    product_sidebar_category();
    sku();
});

function sku() {
    jQuery(document).on("click", '.woovr-variation-radio', function (event) {
        $sku = jQuery(this).attr('data-sku');
        $id = 'p_' + jQuery(this).attr('data-id');
        $gtin = gtin[$id];
        $price_per_unit = price_per_unit[$id];
        if ($gtin) {
            $gtin_html = jQuery('<p class="gtin-meta"><strong>GTIN: </strong><span class="gtin-val"> ' + $gtin + ' </span></p>');

            if (jQuery('.gtin-meta').length != 0) {
                jQuery('.gtin-val').text($gtin);
            } else {
                $gtin_html.appendTo('.product-meta');
            }
        } else {
            jQuery('.gtin-meta').remove();
        }

        if ($price_per_unit) {
            $price_per_unit_html = jQuery('<p class="price-per-unit-meta"><strong>Price Per Unit: </strong><span class="price-per-unit-val"> ' + $price_per_unit + ' </span></p>');

            if (jQuery('.price-per-unit-meta').length != 0) {
                jQuery('.price-per-unit-val').text($price_per_unit);
            } else {
                $price_per_unit_html.appendTo('.product-meta');
            }
        } else {
            jQuery('.price-per-unit-meta').remove();
        }

        jQuery('.sku-val').text($sku);
    });
}

function product_sidebar_category() {
    jQuery('<div class="view-more-category"> <span></span> <svg class="plus" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/> <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/> </svg><svg class="minus" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/> <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/> </svg></div>').appendTo('.widget.widget_product_categories');
    jQuery('.view-more-category').click(function (e) {
        jQuery('.widget.widget_product_categories').toggleClass('active');
        e.preventDefault();
    });
}

function ajax_form() {
    var typingTimer;
    var doneTypingInterval = 500;

    jQuery('input[name="post_type"]').change(function (e) {
        e.preventDefault();
        ajax();
    });
    jQuery('.search-section-default #search-input').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    jQuery('.search-section-default #search-input').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        ajax();
    }
}


function load_more_button_listener($) {
    jQuery(document).on("click", '.search-section-default #load-more', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        ajax(offset, 'append');
    });

}


function results_height() {
    if (jQuery('.search-section-default #results').length > 0) {
        $height = jQuery('.search-section-default #results .results-holder').outerHeight();
        jQuery('#results').css('height', $height + 'px');
    }
}


function ajax($offset, $event_type = 'html') {

    var $loadmore = jQuery('.search-section-default #load-more');

    var $archive_section = jQuery('.search-section-default');

    var $result_holder = jQuery('.search-section-default #results .results-holder');

    var $posts_per_page = 12;

    var $s = jQuery('.search-section-default #search-input').val();

    var $post_type = jQuery('input[name="post_type"]:checked').val();

    $loading = jQuery('<div class="loading-results"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg></div>');

    $archive_section.addClass('loading-post');

    if ($event_type == 'html') {
        jQuery('.search-section-default #results  .results-holder').html($loading);
        $loadmore.addClass('d-none');
    } else {
        $loadmore.addClass('loading');
        $loadmore.find('span').text('Loading');
    }


    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'search_ajax',

            posts_per_page: $posts_per_page,

            s: $s,

            offset: $offset,

            post_type: $post_type,

        },

        success: function (response) {
            if ($event_type == 'append') {
                $result_holder_row = $result_holder.find('.post-item-holder');
                jQuery(response).appendTo($result_holder_row);
            } else {
                $result_holder.html(response);
                jQuery('#pagination').html('');
                jQuery('.pagination').appendTo('#pagination');
            }
            $loadmore.removeClass('d-none loading');

            $loadmore.find('span').text('Load more');

            $archive_section.removeClass('loading-post');

            //results_height();
        },
        error: function (e) {
            console.log(e);
        }

    });
}