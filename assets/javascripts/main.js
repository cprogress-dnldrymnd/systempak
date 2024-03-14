jQuery(document).ready(function ($) {
    load_more_button_listener();
    ajax_form();
});


function product_sidebar_category() {
    jQuery('<div class="view-more-category"> View More </div>');
}

function ajax_form() {
    var typingTimer;
    var doneTypingInterval = 500;

    jQuery('input[name="post_type"]').change(function (e) {
        e.preventDefault();
        ajax();
    });
    jQuery('.search-section #search-input').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    jQuery('.search-section #search-input').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        ajax();
    }
}


function load_more_button_listener($) {
    jQuery(document).on("click", '#load-more', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        ajax(offset, 'append');
    });

}


function results_height() {
    if (jQuery('#results').length > 0) {
        $height = jQuery('#results .results-holder').outerHeight();
        jQuery('#results').css('height', $height + 'px');
    }
}


function ajax($offset, $event_type = 'html') {

    var $loadmore = jQuery('#load-more');

    var $archive_section = jQuery('.search-section');

    var $result_holder = jQuery('#results .results-holder');

    var $posts_per_page = 12;

    var $s = jQuery('#search-input').val();

    var $post_type = jQuery('input[name="post_type"]:checked').val();

    $loading = jQuery('<div class="loading-results"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg></div>');

    $archive_section.addClass('loading-post');

    if ($event_type == 'html') {
        jQuery('#results  .results-holder').html($loading);
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