jQuery(document).ready(function ($) {
    load_more_button_listener();
    ajax_form();
});

function ajax_form() {
    var typingTimer;
    var doneTypingInterval = 500;

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


    jQuery(document).on("click", '.pagination .page-numbers', function (event) {
        event.preventDefault();
        $page = jQuery(this).text();
        jQuery('#results').addClass('pagination-trigger');
        ajax($page, 'html');
        return false;
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

    $loading = jQuery('<div class="loading-results"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/> <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/> </svg></div>');

    $archive_section.addClass('loading-post');

    if ($event_type == 'html') {
        jQuery('#results  .results-holder').html($loading);
        $loadmore.addClass('d-none');
    } else {
        $loadmore.addClass('loading');
        $loadmore.find('span').text('Loading');
    }

    var $page = 1;

    if (!$offset) {
        $page = 1;
    } else {
        $page = $offset;
    }

    if ($page == 1) {
        var $offset_val = 0;
    } else {
        var $offset_val = ($page * $posts_per_page) + 1;
    }



    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'search_ajax',

            posts_per_page: $posts_per_page,

            page: $page,

            s: $s,

            offset: $offset_val,


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

            results_height();
        },
        error: function (e) {
            console.log(e);
        }

    });
}