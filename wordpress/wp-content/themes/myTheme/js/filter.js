let $ = jQuery.noConflict();

$(document).ready(function(){
    $('#cat_filter').on('change', function() {
        let filter = $(this);
        $.ajax({
            url : cat_filter.ajaxurl,
            data: {
                'action': 'filter',
                'cat_filter': $('#cat_filter').val(),
            },
            type: 'POST',
        }).done((data) => {
            $('main').html(data);
        }).error((jqXHR) => {
            console.log(jqXHR);
        });
        return false;
    });
});