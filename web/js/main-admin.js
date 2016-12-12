$(document).ready(function(){

    /* adding arrows to column title when sorting is enabled */
    if ($('#sort-name').data('name') !== 'no-sort') {
        var str = $('#sort-name').data('name');
        var sort = 'up';
        if (str.indexOf('-') + 1) {
            str = str.substring(1);
            sort = 'dn';
        }
        else {
            str = '-' + str;
        }
        if (sort == 'up') arrow = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
        else arrow = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
        a = $('a[data-sort=' + str + ']');
        sortName = a.text() + ' ' + arrow;
        a.html(sortName);
    }

    /* delete checked button disable */

    $('input[type=checkbox]').on('change', function(){
        flag = false;
        $('input[type=checkbox]').each(function(indx, elem){
            if ($(elem).prop('checked') == true){
                $('#del-checked').removeClass('disabled');
                $('#del-checked').removeAttr('disabled');
                flag = true;
            }
        });
        if (!flag) {
            $('#del-checked').addClass('disabled');
            $('#del-checked').attr('disabled', 'disabled');
        }
    });
});