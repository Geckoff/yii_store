$(document).ready(function(){

    /* adding arrows to column title when sorting is enabled */
    if ($('#sort-name').data('name') !== 'no-sort' && $('div').is('#sort-name')) {
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
                $('.admin-checked-btn').removeClass('disabled');
                $('.admin-checked-btn').removeAttr('disabled');
                flag = true;
            }
        });
        if (!flag) {
            $('.admin-checked-btn').addClass('disabled');
            $('.admin-checked-btn').attr('disabled', 'disabled');
        }
    });

    /* no empty string search */
    $('.search_box form').on('submit', function(event){
        if ($(this).find('input').val().length == 0) {
            event.preventDefault();
            input = $(this).find('input')
            input.css('border', '1px solid red');
            setTimeout(function(){$('.search_box form input').css('border', 'none')}, 1000);

        }
    });

    /* Delete single item confirm */

    $('.delete-product').on('click', function(){
        if (!confirm('Are you sure you want to delete this item?')) {
            return false;
        }
    });


    /* Checked items change buttons*/

    $('.admin-checked-btn').on('click', function(){
        if ($(this).data('action') == 'delete-check') {
            if (!confirm('Are you sure you want to delete this item?')) {
                return false;
            }
        }
        var init_path = $('#grid-form').attr('action');
        var count = (init_path.split('/').length - 1)
        if (count > 2) {
            var last_slash = init_path.lastIndexOf("/");
            init_path = init_path.substring(0, last_slash);
        }
        var path = init_path + '/' + $(this).data('action');
        $('#grid-form').attr('action', path);
        $('#grid-form').trigger('submit');
    });

    /* delete gallery picture */
    $('.update-gallery').on('click', 'i', function(){
        $(this).parent().fadeOut(200);
        img_id = $(this).data('id');
        if (img_id == 'no'){
            fileName = $(this).data('name');
            files = $("#gallery-input")[0].files;

            for (i = 0; i < files.length; i++) {
                if (files[i].name == fileName) {
                    alert('asd');
                    delete files[i];
                }
                //console.log(files);
                //return true;
                /*console.log("Filename: " + files[i].name);
                console.log("Type: " + files[i].type);
                console.log("Size: " + files[i].size + " bytes");*/
            }
            console.log(files);
            return true;
        }
        item_id = $(this).parent().parent().data('itemid');
        $.ajax({
            url: '/admin/product/delete-image',
            data: {img_id: img_id, item_id: item_id},
            type: 'POST',
            success: function(res) {
            },
            error: function() {
                alert('error!');
            }
        });
    });

    /* add main image */
    $("#product-image").change(function() {
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.main-img-update img').attr('src', e.target.result).attr('width', '200');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                console.log('not an image');
            }
        } else {
            console.log('houston we\'ve got a problem');
        }
    });

    /*add gallery image*/
    $("#gallery-input").change(function() {
        $('.added').remove();

        if (this.files) $.each(this.files, readAndPreview);
        function readAndPreview(i, file) {

            if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                return alert(file.name +" is not an image");
            }

            var reader = new FileReader();
            $(reader).on("load", function() {
                $('.update-gallery').append('<div class="single-update-gallery added addjs-'+i+'"></div>');
                curBlock = $('.addjs-' + i);
                curBlock.prepend($("<img/>", {src:this.result, width:200}));
            });

            reader.readAsDataURL(file);

          }
    });

    /* New and Sale items checkboxes */
    $('#product-new').on('change', function(){
        if ($("#product-new").prop("checked")) $("#product-sale").prop("checked", false);
    });

    $('#product-sale').on('change', function(){
        if ($("#product-sale").prop("checked")) $("#product-new").prop("checked", false);
    });

    /* Euros and Pounds price */
    if ($('div').is('.field-product-price')) {
        $('.field-product-price').append('<div class="other-prices"></div>');
        var price = $('#product-price').val();
        $.ajax({
            url: '/ajax/pound-euro-price',
            data: {price: price},
            type: 'POST',
            beforeSend: function() {
                $('.other-prices').fadeOut(200);
            },
            success: function(res) {
                res = JSON.parse(res);
                $('.other-prices').html('<span>&euro;' + res['euro'] + ' &nbsp;&pound;' + res['pound'] + '</span>');
                $('.other-prices').fadeIn(200);
            },
            error: function() {
                alert('error!');
            }
        });
    }

    $('#product-price').focusout(function(){
        var price = $(this).val();
        if (!price.match(/^[\d]*$|^[\d]+\.[\d]+$/)) return false;
        $.ajax({
            url: '/ajax/pound-euro-price',
            data: {price: price},
            type: 'POST',
            beforeSend: function() {
                $('.other-prices').fadeOut(200);
            },
            success: function(res) {
                res = JSON.parse(res);
                $('.other-prices').html('<span>&euro;' + res['euro'] + ' &nbsp;&pound;' + res['pound'] + '</span>');
                $('.other-prices').fadeIn(200);
            },
            error: function() {
                alert('error!');
            }
        });
    });

    /* Rating change check */
    $('#product-rating').focusout(function(){
        if ($(this).val() == 0) {
            $('#product-voters').val(0);
            $('#product-current_rating').val(0);
            $('#product-current_rating').removeClass('wrong-value');
            $('#product-current_rating').css('border-color', '#ccc');
            $('#product-current_rating').css('color', '#555');
            $('label[for="product-current_rating"]').css('color', '#333');
            return false
        }
        if ($('#product-voters').val() == '0') $('#product-voters').val(1);
        getAverageRating();
    });

    $('#product-voters').focusout(function(){
        if ($(this).val() == 0) {
            $('#product-rating').val(0);
            $('#product-current_rating').val(0);
            $('#product-current_rating').removeClass('wrong-value');
            $('#product-current_rating').css('border-color', '#ccc');
            $('#product-current_rating').css('color', '#555');
            $('label[for="product-current_rating"]').css('color', '#333');
            return false
        }
        getAverageRating();
    });

    function getAverageRating() {
        $('#product-current_rating').removeClass('wrong-value');
        $('#product-current_rating').css('border-color', '#ccc');
        $('#product-current_rating').css('color', '#555');
        $('label[for="product-current_rating"]').css('color', '#333');
        var all_rating = $('#product-rating').val();
        if (!all_rating.match(/^[\d]*$/)) return false;
        var voters = $('#product-voters').val();
        if (!voters.match(/^[\d]*$/) || voters == '0') return false;
        var cur_rating = all_rating /  voters;
        cur_rating = cur_rating.toPrecision(2);
        if (cur_rating < 1 || cur_rating > 5) {
            $('#product-current_rating').css('border-color', '#a94442');
            $('#product-current_rating').css('color', '#a94442');
            $('label[for="product-current_rating"]').css('color', '#a94442');
            cur_rating += ' - wrong value!';
            $('#product-current_rating').val(cur_rating);
            $('#product-current_rating').addClass('wrong-value');
        }
        else {
            $('#product-current_rating').val(cur_rating);
        }
    }

    $('#product-form').on('submit', function(e){
        if ($('input').is('.wrong-value')) {
            e.preventDefault();
            document.location='#product-current_rating';
        }
    });

    if ($('form').is('#product-form')) {
        $("#product-image").after("<div class='upload-button'></div>");
    }

    /* New Order highlighting*/
    if ($('span').is('.new-admin-order')) {
        $('.new-admin-order').parent().parent().css('font-weight', 'bold');
    }

    /* Product choose category tooltip */
    if ($('span').is('#checked-span-tooltip')) {
        $('#checked-span-tooltip').tooltip();
    }

    /* Product choose category select */
    $('.admin-index-category').on('change', function(){
        id = $(this).val();
        document.location.href = document.location.protocol + '//' + document.location.host + '/admin/product/index?catid=' + id;
    });

    /* Product set order position */

    $('.order-item').on('focusout', function(){
        var controller = $(this).data('controller');
        var cur_order = $(this).data('cur_order');
        var cat_id = $(this).data('cat_id');
        var id = $(this).data('id');
        var order = $(this).val();
        if (order == cur_order) return false;
        $.ajax({
            url: '/admin/' + controller + '/set-certain-order',
            data: {cur_order: cur_order, cat_id: cat_id, id: id, order: order},
            type: 'POST',
            success: function(res) {
                //console.log(JSON.parse(res));
                location.reload();
            },
            error: function() {
                alert('error!');
            }
        });
    });

    /* Categories Order*/

    $('.category-products-admin').on('click', '.move-cat', function(){
        var moveBlock = $(this).parent().parent();
        if ($(this).is('.arrow-pos-block')) return false;

        $('.category-products-admin').addClass('block-blocked');

        var primBlock = $(this);
        var primId = $(this).data('id');
        var primOrder = $(this).data('order');

        if ($(this).data('direction') == 'up') {
            var primAnotherLink = $(this).next();
            var neighBlock = moveBlock.prev();
            var secBlock = neighBlock.find('.move-cat-up');
            var secAnotherLink = neighBlock.find('.move-cat-down');
            neighBlock.before(moveBlock);
        }
        if ($(this).data('direction') == 'down') {
            var primAnotherLink = $(this).prev();
            var neighBlock = moveBlock.next();
            var secBlock = neighBlock.find('.move-cat-down');
            var secAnotherLink = neighBlock.find('.move-cat-up');
            neighBlock.after(moveBlock);
        }


        var secId = secBlock.data('id');
        var secOrder = secBlock.data('order');

        console.log(primBlock.data('order'));
        console.log(secBlock.data('order'));

        primBlock.attr('data-order', secOrder);
        secBlock.attr('data-order', primOrder);
        primAnotherLink.attr('data-order', secOrder);
        secAnotherLink.attr('data-order', primOrder);

        primBlock.data('order', secOrder);
        secBlock.data('order', primOrder);
        primAnotherLink.data('order', secOrder);
        secAnotherLink.data('order', primOrder);

        $.ajax({
            url: '/admin/category/menu-order',
            data: {prim_id: primId, prim_order: primOrder, sec_id: secId, sec_order: secOrder},
            type: 'POST',
            success: function(res) {
            },
            error: function() {
                alert('error!');
                return false;
            }
        });

        setTimeout(function(){ $('.category-products-admin').removeClass('block-blocked');  }, 1000);

        disableArrowsCategoryOrder();
    });

    function disableArrowsCategoryOrder() {
        $('.move-cat').removeClass('arrow-pos-block');
        $('.ul-menu-admin-order > li:first-of-type > .arrow-pos-block > .move-cat-up').addClass('arrow-pos-block');
        $('.ul-menu-admin-order > li:last-of-type > .arrow-pos-block > .move-cat-down').addClass('arrow-pos-block');

    }

    if ($('ul').is('.category-products-admin')) disableArrowsCategoryOrder();

    /* Posts order */

    if ($('div').is('#postModal')) {
        $( "#sortable" ).sortable();
    }

    $('.save-post-order').on('click', function(){
        var sortedIDs = $( "#sortable" ).sortable( "toArray" );
        var IDarray = JSON.stringify(sortedIDs);
        //alert(IDarray);
        $.ajax({
            url: '/admin/post/post-order',
            data: {array: IDarray},
            type: 'POST',
            success: function(res) {
                $('#postModal').modal('hide')
            },
            error: function() {
                alert('error!');
                return false;
            }
        });
    });

    /* Update single slide */

    $('.graph-mat-container').on('click', '.graph-update-item', function(e){
        e.preventDefault();
        var initButton = $(this);

        var imgInput = $(this).parent().parent().find("input#graphic-img");
        var linkInput = $(this).parent().parent().find("input#graphic-link");
        var idInput = $(this).parent().parent().find("input[name=id]");
        var csrfInput = $(this).parent().parent().find("input[name=_csrf]");
        var fd = new FormData();

        fd.append('Graphic[img]', imgInput.prop('files')[0]);
        fd.append('Graphic[link]', linkInput.val());
        fd.append('id', idInput.val());
        fd.append('_csrf', csrfInput.val());

        if (idInput.val() == '0') {
            var url = '/admin/graphic/new-slide';
            var galId = $(this).parent().parent().parent().parent().parent().data('id');
            fd.append('gallery_id', galId);
        }
        else var url = '/admin/graphic/update-slide';

        $.ajax({
            url: url,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                console.log(data);
                if (idInput.val() == 0) {
                    initButton.removeClass('btn-success');
                    initButton.addClass('btn-primary');
                    initButton.text('Update');
                    initButton.parent().next().after('<button data-id="' + data + '" type="button" class="btn btn-danger delete-slide">Delete Slide</button>');
                    initButton.parent().parent().find('input[name=id]').val(data);

                    setTimeout(function(){ initButton.parent().parent().find('.image-success-notice').text('Slide was saved'); }, 1000);
                }
                var successText = initButton.parent().parent().parent().find('.image-success-notice');
                successText.fadeIn();
                setTimeout(function(){successText.fadeOut();}, 1500);
            }
        });
    });

    /* changing baner/slide image */
    $('.graph-mat-container').on('change', '.graphic-mat-img-btn', function() {
        var curBut = $(this);
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    curBut.parent().parent().find('.graphic-mat-img-disp img').attr('src', e.target.result).attr('height', '200');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                console.log('not an image');
            }
        } else {
            console.log('houston we\'ve got a problem');
        }
    });

    /* Deleting slide */

    $('.graph-mat-container').on('click', '.delete-slide', function(){
        var id = $(this).data('id');
        var delBut = $(this);
        delBut.parent().parent().fadeOut(200);
        setTimeout(function(){delBut.parent().parent().remove();}, 250);
        delBut.parent().parent().next().fadeOut(200);
        setTimeout(function(){delBut.parent().parent().next().remove();}, 250);
        delBut.parent().parent().next().next().fadeOut(200);
        setTimeout(function(){delBut.parent().parent().next().next().remove();}, 250);

        setTimeout(function(){
            $('.grahic-gallery-slide-block').each(function(indx, elem){
                console.log(indx);
                var num = indx + 1;
                console.log($(this).find('.slide-number'));
                $(this).find('.slide-number').text('Slide ' + num);
            });
        }, 350);


        $.ajax({
            url: '/admin/graphic/delete',
            data: {id: id},
            type: 'POST',
            success: function(res) {
            },
            error: function() {
                alert('error!');
                return false;
            }
        });
    });

    /* Adding new slide to gallery */
    $('.graph-mat-container').on('click', '.add-slide-btn', function(){
        //alert('asd');
        var csrf = $('meta[name = csrf-token]').attr('content');
        slideNumber = $('.grahic-gallery-slide-block').length + 1;
        var html = '<div class="grahic-gallery-slide-block">\
                        <form id="w3" action="/admin/graphic/update" method="post" enctype="multipart/form-data">\
                            <input type="hidden" name="_csrf" value="' + csrf + '">\
                            <p class="slide-number">Slide ' + slideNumber + '</p>\
                            <div class="form-group field-graphic-link">\
                                <label class="control-label" for="graphic-link">Link</label>\
                                <input type="text" id="graphic-link" class="form-control" name="Graphic[link]" value="" maxlength="255">\
                                <div class="help-block"></div>\
                            </div>\
                            <input type="hidden" name="id" value="0">\
                            <div class="graphic-mat-img-disp">\
                                <img src="/yii2images/images/image-by-item-and-alias?item=&amp;dirtyAlias=placeHolder_200x.png" alt="">\
                            </div>\
                            <div class="form-group gallery-submit-group">\
                                <button type="submit" class="btn btn-success slide-submit graph-update-item">Add Slide</button>\
                            </div>\
                            <div class="form-group field-graphic-img">\
                                <input type="hidden" name="Graphic[img]" value="">\
                                <input type="file" id="graphic-img" class="graphic-mat-img-btn" name="Graphic[img]">\
                                <div class="help-block"></div>\
                            </div>\
                            <div class="clearfix"></div>\
                            <div class="image-success-notice-block">\
                                <p class="text-success image-success-notice">Slide was created</p>\
                            </div>\
                        </form>\
                    </div>\
                    <div class="clearfix"></div>\
                    <hr>';
        $(this).parent().find('.grahic-gallery-block-slides').append(html);

    });



});