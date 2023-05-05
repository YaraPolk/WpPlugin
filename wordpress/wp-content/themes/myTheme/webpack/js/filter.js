let $ = jQuery.noConflict();
let sort = false;

$(document).ready(function(){
    $('#cat_filter').on('change', function() {
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
    $('#sort button').on('click', function() {
        if ($(this).text() === 'ASC'){
            $(this).text('DESC');
        } else {
            $(this).text('ASC');
        }
        $.ajax({
            url : cat_filter.ajaxurl,
            data: {
                'action': 'filter',
                'cat_filter': $('#cat_filter').val(),
                'sort' : $(this).text(),
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