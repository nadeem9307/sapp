<?php
include 'header.php';
?>
<script src="assets/js/jquery-3.2.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="{{ 'api.js' | asset_url }}" async="async"></script>
{{ 'bootstrap.css' | asset_url | stylesheet_tag }} 
{{ 'custom_choosecart_css.css' | asset_url | stylesheet_tag }} 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 


<!-- layout section -->
<script type="text/javascript">
var cart_data = [];
var cart_data_monday = [];
var location_data_monday = [];
var cart_data_wednesday = [];
var location_data_wednesday = [];
var total_limit = '';
var product_id = {{ product.id }};

$(document).ready(function () {
//    var product_id = '477178691627';
    $.get("https://u46234.shellit.org/dev/api.php?key=25934472&id=" + product_id, {action: "get_store_data"})
            .done(function (data) {

                var get_date = data;
                console.log(get_date);

                //append no of meals
                var meal_unit = get_date.plan[0].meal_units;
                $('.total_meal_unit').html(meal_unit);

                $('.next_mon_date').html(get_date.next_wednesday);
                $('.next_wed_date').html(get_date.next_wednesday);

                var m_location_option = '';
                $.each(get_date.location.Monday, function (val, data1) {
                    m_location_option += '<option value="' + data1.id + '">' + data1.address + '</option>';
                });
                var mon_loc = '<select class="form_control" id="monday_location" onchange="getLocation(this)">' + m_location_option + '</select>';
                $('#monday_location_div').html(mon_loc);

                var w_location_option = '';
                $.each(get_date.location.Wednesday, function (val, data1) {
                    w_location_option += '<option value="' + data1.id + '">' + data1.address + '</option>';
                });
                var w_loc = '<select class="form_control" id="wednesday_location" onchange="getLocation(this)">' + w_location_option + '</select>';
                $('#wednesday_location_div').html(w_loc);

                var monday_meal = '';

                $.each(get_date.meals.Monday, function (val, data1) {

                    var dish_name = "'" + data1.name + "'";
                    monday_meal += '<div class="col-md-3 ingredients">';
                    monday_meal += '<div class="pickup-box">';
                    monday_meal += '<img src="https://u46234.shellit.org/dev/uploads/' + data1.image_url + '" height="50px" />';
                    monday_meal += '</div>';
                    monday_meal += '<p>' + data1.description + '</p>';
                    monday_meal += '<button type="button" class="btn" id="this_' + data1.id + '" onclick="cartitem(' + dish_name + ' , ' + data1.id + ',this,0)" >Add to cart</button></div>';

                });
                $('#monday_meal_div').html(monday_meal);

                var wednesday_meal = '';
                $.each(get_date.meals.Wednesday, function (val, data1) {

                    var dish_name = "'" + data1.name + "'";
                    wednesday_meal += '<div class="col-md-3 ingredients">';
                    wednesday_meal += '<div class="pickup-box">';
                    wednesday_meal += '<img src="https://u46234.shellit.org/dev/uploads/' + data1.image_url + '" height="50px" />';
                    wednesday_meal += '</div>';
                    wednesday_meal += '<p>' + data1.description + '</p>';
                    wednesday_meal += '<p>Description:<br>' + data1.description + '</p>';
                    wednesday_meal += '<button type="button" class="btn" id="this_' + data1.id + '" onclick="cartitem(' + dish_name + ', ' + data1.id + ',this,1)">Add to cart</button></div>';

                });
                $('#wednesday_meal_div').html(wednesday_meal);

            });
});

var counter = 0;
var day_counter_mon = 0;
var day_counter_wed = 0;
var next_date="";

function removeItem(array, item) {
    for (var i in array) {
        if (array[i] == item) {
            array.splice(i, 1);
            break;
        }
    }
}

function cartitem(name, id, event, day) {
    //day 0=monday 1=wednesday
    if (day == 0) {
        if ($(event).text() == "Added on cart") {
            day_counter_mon--;
        } else {
            day_counter_mon++;
        }
    } else {
        if ($(event).text() == "Added on cart") {
            day_counter_wed--;
        } else {
            day_counter_wed++;
        }
    }


    var meal_unit = $('.total_meal_unit').text();


    /***Add Item on the cart page ***/
    var n = name;
    var id = id;

    if ($(event).text() == "Added on cart") {
        // removeItem(cart_data,name);	

        if (day == 0) {
            removeItem(cart_data_monday, name);
            $('.monday_dishes #'+id).remove();
        } else {
            removeItem(cart_data_wednesday, name);
            $('.wednesday_dishes #'+id).remove();
        }



        counter--;
    } else {
        if (counter == meal_unit - 1 && day_counter_mon == 0) {
            alert("Please Pick at least one on Monday");
            return true;
        }

        if (counter == meal_unit - 1 && day_counter_wed == 0) {
            alert("Please Pick at least one on Wednesday");
            return true;
        }

        if (counter >= meal_unit) {
            alert("You have permision only add " + meal_unit + " meals");
            return true;
        } else {
            if (day == 0) {
                cart_data_monday.push(name);
                $('.monday_dishes').append('<li id='+id+'>'+name+'</li>');
            } else {
                cart_data_wednesday.push(name);
                $('.wednesday_dishes').append('<li id='+id+'>'+name+'</li>');
            }
            // cart_data.push(name);
            counter++;
        }
    }

    //console.log(counter);

    //Change text
    $(event).text($(event).text() == 'Add to cart' ? 'Added on cart' : 'Add to cart');

    var r = $(event).css('background-color');

    if (r == 'rgb(221, 221, 221)') {
        $(event).css('background-color', 'rgb(255, 202, 52)');
    } else {
        $(event).css('background-color', 'rgb(221, 221, 221)');
    }

    console.log(cart_data_monday);
    console.log(cart_data_wednesday);
}

function check_out(){
	var next_date = [$('.next_mon_date').text(),$('.next_wed_date').text()];
	location_data_monday=$('#monday_location option:selected').text();
	location_data_wednesday=$('#wednesday_location option:selected').text();
	data={cart_data_monday:cart_data_monday,location_data_monday:location_data_monday,cart_data_wednesday:cart_data_wednesday,location_data_wednesday:location_data_wednesday,next_date:next_date};
	
	jQuery.post('/cart/add.js', {
	  quantity: 1,
	  id: product_id,
	  properties: data
	});

}

function getLocation(event) {
    var value = $('#' + event.id).val();
    var location = $('#' + event.id + ' option:selected').text();
    //value contain location is and location containt full location
    //console.log(value,location);
    if (event.id == "wednesday_location") {
        $('.put_wednesday_address').html(location);

        if ((location_data_wednesday.length > 0)) {
            location_data_wednesday = [];
            location_data_wednesday.push(location);
        } else {
            location_data_wednesday.push(location);
        }
        console.log(location_data_wednesday);
    } else {
        $('.put_monday_address').html(location);
        if ((location_data_monday.length > 0)) {
            location_data_monday = [];
            location_data_monday.push(location);
        } else {
            location_data_monday.push(location);
        }

        console.log(location_data_monday);
    }
}

</script>

<div class="product-template__container page-width" itemscope itemtype="http://schema.org/Product" id="ProductSection-{{ section.id }}" data-section-id="{{ section.id }}" data-section-type="product" data-enable-history-state="true">
    <meta itemprop="name" content="{{ product.title }}">
    <meta itemprop="url" content="{{ shop.url }}{{ product.url }}">
    <meta itemprop="image" content="{{ product.featured_image.src | img_url: '800x' }}">

    {% comment %}
    Get first variant, or deep linked one
    {% endcomment %}

    {%- assign current_variant = product.selected_or_first_available_variant -%}
    {%- assign product_image_zoom_size = '1024x1024' -%}
    {%- assign product_image_scale = '2' -%}
    {%- assign enable_zoom = section.settings.enable_zoom -%}


    <div class="layout" itemscope itemtype="http://schema.org/Product" id="ProductSection-{{ section.id }}" data-section-id="{{ section.id }}" data-section-type="product" data-enable-history-state="true" >

        <!-- Product meta uesed ny shopify Id -->
        <meta itemprop="name" content="{{ product.title }}">
        <meta itemprop="url" content="{{ shop.url }}{{ product.url }}">
        <meta itemprop="image" content="{{ product.featured_image.src | img_url: '800x' }}">
        <!-- Product meta uesed ny shopify Id Ends -->

        <div class="warpper clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 meals-monday">
                        <div class="col-md-9 border-right">

                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="{{ shop.currency }}">
                                <link itemprop="availability" href="http://schema.org/{% if product.available %}InStock{% else %}OutOfStock{% endif %}">
                            </div>
                            <div class="delivered-meals">
                                <h1 itemprop="name" class="product-single__title">{{ product.title }}</h1>
                                <div class="product-single__description rte" itemprop="description">
                                    {{ product.description }}
                                </div>

                                <h1>Meals Monday</h1>
                                <span>Delivered on Monday:<p class="next_mon_date"></p></span>
                                <p class="choose">Choose pickup point</p>
                                <div id="monday_location_div">

                                </div>


                                <div class="row" id="monday_meal_div">


                                </div>
                            </div>
                            <div class="delivered-meals meals-wednesday">
                                <h1>Meals Wednesday</h1>
                                <span>Delivered on Wednesday:<p class="next_wed_date"></p></span>
                                <p class="choose">Choose pickup point</p>
                                <div id="wednesday_location_div">

                                </div>
                                <div class="row" id="wednesday_meal_div">
                                </div>
                            </div>

                            <div class="delivered-meals x-male">
                                <h1>X meals selected of Z</h1>
                                <button type="button" class="btn">Go to checkout</button>
                            </div>

                        </div>
                        <div class="col-md-3 shopping-cart">

                            <div><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
                            <h2>Shopping Cart</h2>
                            <p>Items List:</p>
                            <h4>Monday delivery@</h4><h4 class="put_monday_address"></h4>
                            <ul class="monday_dishes">

                            </ul>
                            <hr>
                            <h4>Wednesday delivery@</h4><h4 class="put_wednesday_address"></h4>
                            <ul class="wednesday_dishes">

                            </ul>
                            <p>Total meals:<span class="total_meal_unit"></span></p>
                            <meta itemprop="priceCurrency" content="{{ shop.currency }}">
                            <p class="total_price_section">Total Price <span class="price" id="ProductPrice-{{ section.id }}" itemprop="price" content="{{ current_variant.price | divided_by: 100.00 }}">
                                    {{ current_variant.price | money }}
                                </span>
                            </p>

                            <button type="button" class="btn" onclick="check_out()">Go to checkout</button>
                            <br>
                            <br>
                            {% if section.settings.show_share_buttons %}
                            {% include 'social-sharing', share_title: product.title, share_permalink: product.url, share_image: product %}
                            {% endif %}
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{% if collection %}
<div class="text-center return-link-wrapper">
    <a href="{{ collection.url }}" class="btn btn--secondary btn--has-icon-before return-link">
        {% include 'icon-arrow-left' %}
        {{ 'products.product.back_to_collection' | t: title: collection.title }}
    </a>
</div>
{% endif %}

{% unless product == empty %}
<script type="application/json" id="ProductJson-{{ section.id }}">

    {{ product | json }}
</script>








{% endunless %}

{% schema %}
{
"name": "Product pages",
"settings": [
{
"type": "select",
"id": "image_size",
"label": "Image size",
"options": [
{
"value": "small",
"label": "Small"
},
{
"value": "medium",
"label": "Medium"
},
{
"value": "large",
"label": "Large"
},
{
"value": "full",
"label": "Full-width"
}
],
"default": "medium"
},
{
"type": "checkbox",
"id": "show_quantity_selector",
"label": "Show quantity selector",
"default": false
},
{
"type": "checkbox",
"id": "show_variant_labels",
"label": "Show variant labels",
"default": true
},
{
"type": "checkbox",
"id": "show_vendor",
"label": "Show vendor",
"default": false
},
{
"type": "checkbox",
"id": "enable_zoom",
"label": "Enable image zoom",
"default": true
},
{
"type": "checkbox",
"id": "show_share_buttons",
"label": "Show social sharing buttons",
"default": true
}
]
}
{% endschema %}
