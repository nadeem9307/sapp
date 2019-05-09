$(document).ready(function () {

    //Menu Look and feel
    $('#menu-top li a').attr('class', '');
    var data = window.location.href.split('/');
    if ($.inArray("index.php", data) != -1) {
        $('#mindex').addClass('menu-top-active');
    }
    if ($.inArray("menuplan.php", data) != -1) {
        $('#mplan').addClass('menu-top-active');
    }
    if ($.inArray("menumeals.php", data) != -1) {
        $('#mmeanls').addClass('menu-top-active');
    }
    if ($.inArray("pickuploactions.php", data) != -1) {
        $('#mpickup').addClass('menu-top-active');
    }
    if ($.inArray("thankyou.php", data) != -1) {
        $('#thankyou').addClass('menu-top-active');
    }
    if ($.inArray("storetime.php", data) != -1) {
        $('#storetime').addClass('menu-top-active');
    }
    //END//

    //Add Menal Plan
    $('.add_meal').click(function (event) {
        event.preventDefault();
        var unit = $('.m_units').val();
        if ($('#m_units').val() == '')
        {
            $(".msg").html("<div class='alert alert-danger'>Insert meal unit's please! </div>");
        } else {
            $.ajax({
                type: 'post',
                url: 'post.php',
                data: $('#add_meal_plan').serialize(),
                success: function (data) {
                    var rd = $.parseJSON(data);
                    console.log(rd);
                    if (rd.pro_id != '') {
                        $(".msg").html(rd.msg);
                        var pro_id = rd.pro_id;
                        get_row(pro_id, 'get_row');
                    } else {
                        $(".msg").html(rd.msg);
                    }
                }
            });
        }
    });

    //delete_meal from database
    $('.delete_meal').click(function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        delete_meal(id);
    });

    //Update_meal from database
    $('.update_meal').on('click', function (event) {
        event.preventDefault();
        $('.form_heading').html("<b>Please update data and click on save plan.</b>");
        var id = $(this).data('id');
        var meal_name = $(this).data('mealname');
        var arg = meal_name;
        $('.shopify_product_list > option').each(function () {
            if ($(this).text() == arg)
                $(this).parent('select').val($(this).val())
        });
    });
    //Add Weekly dished from admin 
    $('.add_dish_meal').click(function (event) {
        var id = $('#r_id').val();
        event.preventDefault();
        if ($('#sish_name').val() == '' || $('#dish_description').val() == '' || $('#dish_image').val() == '')
        {
            $(".msg_dish_error").html("<div class='alert alert-danger'>Insert all fields values please! </div>");
        }
        else {
            var formData = new FormData('#weekly_dishes');
            $.ajax({
                type: 'post',
                url: 'post.php',
                data: new FormData($('#weekly_dishes')[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    var rdata = $.parseJSON(data);
                    get_row_dishes(rdata.r_id, 'get_row_dishes');
                    $(".msg_dish_error").html(rdata.msg);

                }
            });
        }
    });
    /* update dish */
    $('.update_dish').click(function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        update_dish(id);
    });


    //delete_dishes from database
    $('.delete_dish').click(function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        delete_dish(id);
    });

    // save pickup pont location
    $('.save_pickup_point').click(function (event) {
        event.preventDefault();

        if ($('#per_day_limit').val() == '' || $('#pickup_point').val() == '' || $('#timezones').val() == '' || $('#pickup_location_day').val() == '')
        {
            $(".pickup_msg").html("<div class='alert alert-danger'>Insert all fields values please! </div>");
        } else {
            var id = $('#r_id').val();
            var perdaylimit = $('#per_day_limit').val();
            var pickuppoint = $('#pickup_point').val();
            var timezones = $('#timezones').val();
            var pickup_location_day = '';

            $('.pickup_location_day').each(function () {
                if ($(this).is(':checked')) {
                    pickup_location_day = $(this).val();
                }
            });

            $.ajax({
                type: 'post',
                url: 'post.php',
                data: {'id': id, 'per_day_limit': perdaylimit, 'timezones': timezones, 'pickup_point': pickuppoint, 'pickup_location_day': pickup_location_day, 'action': 'save_pickup_point'},
                success: function (data) {
                    // alert(data);
                    var rdata = $.parseJSON(data);
                    console.log(rdata);
                    get_row_pickup(rdata.last_insertid, 'get_row_pickup');
                    $(".pickup_msg").html(rdata.msg);
                }
            });
        }
    });


    $('.update_pickup').click(function (event) {

        event.preventDefault();
        var id = $(this).data('id');
        //alert(id);
        update_pickup(id);
    });

    //delete pickup point location//
    $('.delete_location').on('click', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        delete_location(id);
    });

    //***Here Is Thankyou page Js**//
    //Add thank you msg
    $('.add_thankyou_msg').click(function (event) {
        var check = this.id;
        event.preventDefault();
        if ($('#msg_description').val() == '' || $('#fileToUpload').val() == '')
        {
            $(".msg_dish_error").html("<div class='alert alert-danger'>Insert all fields values please! </div>");
        } else {

            var formData = new FormData('#thankyou_msg');

            $.ajax({
                type: 'post',
                url: 'post.php',
                data: new FormData($('#thankyou_msg')[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    var rd = $.parseJSON(data);
                    $(".loader").show();
                    $(".msg_dish_error").html(rd.msg);

                    //if(check=="update"){
                    setTimeout(location.reload.bind(location), 3000);
                    //}
                }
            });
        }

    });

      $('.save_store_time').on('click', function (event) {
        event.preventDefault();

        if ($('#open_day').val() == '' || $('#open_time').val() == '' || $('#close_day').val() == '' || $('#close_time').val() == '')
        {
            $(".pickup_msg").html("<div class='alert alert-danger'>Insert all fields values please! </div>");
        } else {
            var id = $('#r_id').val();
            var store_opening_day = $('#open_day').val();
            var store_opening_time = $('#open_time').val();
            var store_closing_day = $('#close_day').val();
            var store_closing_time = $('#close_time').val();

            $.ajax({
                type: 'post',
                url: 'post.php',
                data: {'store_id': id, 'open_day': store_opening_day, 'open_time': store_opening_time, 'close_day': store_closing_day, 'close_time': store_closing_time, 'action': 'save_store_time'},
                success: function (data) {
                    var rdata = $.parseJSON(data);
                    console.log(rdata);
                    $(".pickup_msg").html(rdata.msg);
                    window.location.reload();
                }
            });
        }
    });
       /***********  Time Picker Js            *******************/
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 30,
        minTime: '00',
        maxTime: '11:59pm',
        /*defaultTime: '11',*/
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    //End Of Thank You Page JS**//



});


//***Get row for plans section table**/
function get_row(id, action) {

    jQuery.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': action},
        success: function (data) {

            var data_row_set = jQuery.parseJSON(data);
            console.log(data_row_set);
            var id = data_row_set.shopify_product_id;

            $('.empty').remove();
            $('.' + id).remove();
            var a_row = '<tr class="' + id + '"><td>'
                    + id + '</td>'
                    + '<td>' + data_row_set.meal_name + '</td>'
                    + '<td>' + data_row_set.meal_units + '</td>'
                    + '<td><button name="edit" value="Edit" data-id="' + id + '" data-mealname="' + data_row_set.meal_name + '" class="btn btn-primary btn-xs update_meal" onClick="update_meal(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
                    + '<button name="delete" value="Delete" data-id="' + id + '" class="btn btn-primary btn-xs delete_meal" onClick="delete_meal(' + id + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                    + '</td>'
                    + '</tr>';
            console.log(a_row);

            $('.output_menu_plans table tbody').append(a_row);
        }
    });

}

function get_row_pickup(id, action) {

    jQuery.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': action},
        success: function (data) {
            //alert(data);

            var data_row_set = jQuery.parseJSON(data);
            console.log(data_row_set);
            var id = data_row_set.id;
            $('.no_data').remove();
            $('.' + id).remove();
            var tid = $("table tbody tr").length;
            tid = tid + 1;
            var a_row = '<tr class="' + id + '"><td>#'
                    + id + '</td>'
                    + '<td>' + data_row_set.address + '</td>'
                    + '<td>' + data_row_set.perdaylimit + '</td>'
                    + '<td>' + data_row_set.pickup_location_day + '</td>'
                    + '<td>' + data_row_set.timezones + '</td>'
                    + '<td><button name="delete" value="Delete" data-id="' + id + '" class="btn btn-primary  btn-xs delete_location" onclick="delete_location(' + id + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                    + '<button name="edit" value="Edit" data-id="' + id + '" class="btn btn-primary btn-xs update_pickup" onclick="update_pickup(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><br>'
                    + '</td>'
                    + '</tr>';
            console.log(a_row);

            $('.output_menu_meals table tbody').append(a_row);

        }
    });

}

function get_row_dishes(id, action) {
    jQuery.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': action},
        success: function (data) {
            var data_row_set = jQuery.parseJSON(data);
            console.log(data_row_set);
            var id = data_row_set.id;
            $('.no_dish_er').remove();
            $('.' + id).remove();
            var tid = $("table tbody tr").length;
            tid = tid + 1;

            // <button name="edit" value="Edit" data-id="' + id + '" data-mealname="' + data_row_set.meal_name + '"class="btn btn-primary btn-xs update_dish"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><br>//
            var a_row = '<tr class="' + id + '"><td>#' + id + '</td>'
                    + '<td><img src="http://' + window.location.hostname + '/dev/uploads/' + data_row_set.image_url + '" width="80px"></td>'
                    + '<td>' + data_row_set.name + '</td>'
                    + '<td>' + data_row_set.description + '</td>'
                    + '<td>' + data_row_set.week_day + '</td>'
                    + '<td><button name="delete" value="Delete" data-id="' + id + '" class="btn btn-primary btn-xs delete_dish" onClick="delete_dish(' + id + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                    + '<button name="edit" value="Edit" data-id="' + id + '" class="btn btn-primary btn-xs update_dish" onclick="update_dish(' + id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><br>'
                    + '</td>'
                    + '</tr>';

            console.log(a_row);
            $('.output_menu_plans_dishes table tbody').append(a_row);
        }
    });

}

/**********************************************************/
function update_pickup(id) {
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': 'update_location'},
        success: function (data) {

            var rdata = $.parseJSON(data);

            console.log(rdata);

            $('.pickup_ins').html('<b>Please edit fileds you want to update and click Save pickup location</b>');
            $('#per_day_limit').val(rdata.perdaylimit);
            $('#pickup_point').val(rdata.address);

            var timezones_name = rdata.timezones;
            $('#timezones > option').each(function () {
                if ($(this).val() == timezones_name)
                    $(this).parent('select').val($(this).val())
            });

            var pickup_location_day = rdata.pickup_location_day;
            $('.pickup_location_day').each(function () {
                if ($(this).val() == pickup_location_day) {
                    $(this).prop('checked', 'true');
                }
            });
            $('#r_id').val(rdata.id);

        }
    });

}
function delete_location(id) {
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': 'delete_location'},
        success: function (data) {
            $(".pickup_msg").html(data);
            window.location.reload();
        }
    });
}
function update_meal() {
    $('.form_heading').html("<b>Please update data and click on save plan.</b>");
    var unit = $('.m_units').val();
    if ($('#m_units').val() == '')
    {
        $(".msg").html("<div class='alert alert-danger'>Insert meal unit's please! </div>");
    } else {
        $.ajax({
            type: 'post',
            url: 'post.php',
            data: $('#add_meal_plan').serialize(),
            success: function (data) {
                var rd = $.parseJSON(data);
                console.log(rd);
                if (rd.pro_id != '') {
                    $(".msg").html(rd.msg);
                    var pro_id = rd.pro_id;
                    get_row(pro_id, 'get_row');
                } else {
                    $(".msg").html(rd.msg);
                }
            }
        });

    }
}
function delete_meal(id) {
    //alert(id);
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': 'delete_meals_plan'},
        success: function (data) {
            $(".msg").html(data);
            window.location.reload();
        }
    });
}
function update_dish(id) {
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': 'get_row_dishes'},
        success: function (data) {

            var rdata = $.parseJSON(data);

            console.log(rdata);

//            $('.pickup_ins').html('<b>Please edit fileds you want to update and click Save Dish</b>');
            $('#sish_name').val(rdata.name);
            $('#dish_description').val(rdata.description);
            $('#new_image_url').val(rdata.image_url);
            

            var week_day = rdata.week_day;
            $('#week_day').each(function () {
                if ($(this).val() == week_day) {
                    $(this).prop('checked', 'true');
                }
            });
            $('#r_id').val(rdata.id);

        }
    });
}
function delete_dish(id) {
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: {'id': id, 'action': 'delete_dish'},
        success: function (data) {
            $(".msg_dish_error").html(data);
            window.location.reload();
        }
    });
}