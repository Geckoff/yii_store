


/*price range*/
$('#sl2').slider();

$('.catalog').dcAccordion({
    speed: 300
});

if ($('div').is('#slider-range')) {
    $( "#slider-range" ).slider({
      range: true,
      min: $('.price-range .pull-left').text() * 1,
      max: $('.price-range .pull-right').text() * 1,
      values: $('.price-range input').data('slider-value'),
      slide: function( event, ui ) {
        $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );

    $( "#slider-range" ).on( "slidestop", function( event, ui ) {

    } );
}


/*cart operations */

function clearCart() {
    ajaxCart('/cart/clear');
}

function showCart(cart) {
$('#cart .modal-body').html(cart);
$('#cart').modal();
}

function getCart() {
    ajaxCart('/cart/show');
    return false;
}

$('#cart .modal-body').on('click', '.del-item', function(){
    var id = $(this).data('id');
    ajaxCart('/cart/del-item', {id: id});
});

$('.add-to-cart').on('click', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var qty = $('#qty').val();
    ajaxCart('/cart/add', {id: id, qty: qty});
});

function ajaxCart(url, data = '') {
    $.ajax({
        url: url,
        data: data,
        type: 'GET',
        success: function(res) {
            if (!res) alert('Error');
            showCart(res);
        },
        error: function() {
            alert('error!');
        }
    });
}

$('#cart-view').on('click', '.del-item', function(){
    var id = $(this).data('id');
    var button = $(this);
    $.ajax({
        url: '/cart/del-item-view',
        data: {id: id},
        type: 'GET',
        success: function(res) {
            if (!res) alert('Error');
            button.parent().parent().fadeOut();
            res = JSON.parse(res)
            $('#all-items').text(res['qty']);
            $('#full-price').text(res['sum']);
        },
        error: function() {
            alert('error!');
        }
    });
});

/*setting up currency*/

$('#currency').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var currency = this.value;   // currency 3 sign international designation
    gets = document.location.search;
    path = document.location.pathname;
    host = document.location.host;
    /**
    * If another currency was selected while user is on page where filters (get parameters) for ranging price were applied,
    * we need to change cookies currency info as well as to change url min and max price parameters using seleted currency differential.
    * Page is refreshing with applying of new ranging price parameters.
    **/
    if (gets.indexOf('max=') + 1) {

        keys = {};
        gets = gets.substring(1);
        getNum = gets.split('&').length;
        gets.split('&').forEach(function(item) {
        	item = item.split('=');
        	keys[item[0]] = item[1];
        });
        max = keys['max'];
        min = keys['min'];
        $.ajax({
            url: '/ajax/convert-currency',
            data: {currency: currency, min: min, max: max},
            type: 'GET',
            success: function(res) {
                res = JSON.parse(res);

                keys['max'] = res['max'];
                keys['min'] = res['min'];
                newGet = '?';
                i = 1;
                for (var key in keys) {
                    if (i == getNum) {
                        newGet = newGet + key + '=' + keys[key];
                    }
                    else {
                        newGet = newGet + key + '=' + keys[key] + '&';
                    }
                    i++;
                }
                url = 'http://' + host + path + newGet;  // composing new url
                window.location.href = url;
            },
            error: function() {
                alert('error!');
            }
        });
    }
    /**
    * If page where new currency was selected does not have get parameters in its url, just cookies changing would work fine.
    **/
    else {
        $.ajax({
            url: '/ajax/currency-rate',
            data: {currency: currency},
            type: 'GET',
            success: function(res) {
                location.reload()
                //alert(res);
            },
            error: function() {
                alert('error!');
            }
        });
    }
});

var RGBChange = function() {
$('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
};

/*Price Range Slider and Sorting Select*/

$(document).ready(function(){

    $('.features_items').on('change', '#filters', function(){
        sort = $(this).val();
        maxVal = $('#max-val').data('val');
        minVal = $('#min-val').data('val');
        ajaxFilter(minVal, maxVal, sort);
    });

    $( "#slider-range" ).on( "slidestop", function( event, ui ){
        min = ui.values[0];
        max = ui.values[1];
        sort = $('#sort-val').data('val');
        ajaxFilter(min, max, sort);
    });

    function ajaxFilter(min, max, sort) {
        path = document.location.pathname;
        data = {};
        if (min != 'undefined' && max != 'undefined') {
            data.min = min;
            data.max = max;
        }
        if (sort != 'undefined') data.sort = sort;
        if (path == '/search') {
            url = path;
            q = $('#search-string').data('search');
            data.q = q;
        }
        else {
            path = path.split('/');
            if (path[1] == 'category' || path[1] == 'brand') {
                url = '/' + path[1] + '/' + path[2];
                slug = path[2];
            }
            else {
                if (path[1] == 'ajax') {
                    url = '/ajax/range';
                    slug = true;
                }
                else {
                    window.location.href = "http://" + document.location.host + "/ajax/range" + "?min=" + min + "&max=" + max;
                }
            }
            //data = {min: min, max: max, slug: slug, sort: sort};
            data.slug = slug;
        }

        $('.features_items').fadeOut(200);
        $.ajax({
            url: url,
            data: data,
            type: 'GET',
            success: function(res) {
                if (!res) alert('Error');
                $('.features_items').fadeIn(200);
                $('.features_items').html(res);
                cardRating();
            },
            error: function() {
                alert('error!');
            }
        });
    }

/*Star Rating for item page*/

    cur = $('#cur-rating').data('cur');
    id = $('#cur-rating').data('id');

    /**
    * Sending request to change rating of current item
    **/
    $('#example-fontawesome-o').barrating({
        theme: 'fontawesome-stars-o',
        showSelectedRating: false,
        initialRating: cur,
        onSelect: function(value, text) {
            $.ajax({
                url: '/product/rate',
                data: {value: value, id: id},
                type: 'GET',
                success: function(res) {
                    getRating(id);
                },
                error: function() {
                    alert('404 not found!');
                }
            });
        }
    });

    /**
    * Changing rating of the item on current page
    **/
    function getRating(id) {
        $.ajax({
            url: '/product/get-rating',
            data: {id: id},
            type: 'GET',
            success: function(res) {
                res = JSON.parse(res);
                if ($('p').is('#no-rating')) {
                    $('#no-rating').fadeOut(150);
                    setTimeout(function(){
                        $('#display-rating-block').html("<p id='disp-rating-details' style='display: none'>Rating: <span id='rating-disp'>" + res['rating'] + "</span> Voters: <span id='voters-disp'>" + res['voters'] + "</span></p>");
                        $('#display-rating-block #disp-rating-details').fadeIn(150);
                    }, 200);
                }
                else {
                    $('#rating-disp').fadeOut(150);
                    $('#voters-disp').fadeOut(150);
                    setTimeout(function(){
                        $('#rating-disp').text(res['rating']);
                        $('#voters-disp').text(res['voters']);
                    }, 160)
                    $('#rating-disp').fadeIn(150);
                    $('#voters-disp').fadeIn(150);
                }
            },
            error: function() {
                alert('error!!!');
            }
        });
    }

/*Star Rating for catalog pages*/

    function cardRating() {
        $('.card-rating').each(function(){
            currate = $(this).find('.rating-data').data('cur');
            $(this).find('.example-fontawesome-o').barrating({
                theme: 'fontawesome-stars-o',
                initialRating: currate,
                readonly: true
            });
        });
    }
    cardRating();

/*Adding active class to categoreies menu*/
    setTimeout(menuMod, 1);
    function menuMod() {
        $('.category-products a').removeClass('active');
        $('li.dcjq-parent-li ul').css('display', 'none');
        $('.category-products a').each(function(indx, element){
            //$('.category-products a').removeClass('active');
            if ($(element).data('id') == $('#add-active').data('id')) {
                $(element).addClass("active");
                $(element).parent().parent().css('display', 'block');
            }
            if ($('#add-active').data('id') == 0) $('.category-products a').removeClass('active');
        });
    }


/* Item zoomer */
 $('#img_01').elevateZoom({ gallery:'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true });

/*scroll to top*/

	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
