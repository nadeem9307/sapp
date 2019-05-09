<?php
require __DIR__ . '/vendor/autoload.php';
use phpish\shopify;
require __DIR__ . '/conf.php';
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'get_store_data') {
        get_store_data();
    }
}

function get_product_type_shopify() {
    try {
        $shopify = shopify\client(SHOPIFY_SHOP, SHOPIFY_APP_API_KEY, SHOPIFY_APP_PASSWORD, true);
        $shop_content = $shopify('GET /admin/products.json?fields=id,title&product_type=Meal+Batch');
        return $shop_content;
    } catch (shopify\ApiException $e) {
        # HTTP status code was >= 400 or response contained the key 'errors'
        echo $e;
        print_R($e->getRequest());
        print_R($e->getResponse());
    } catch (shopify\CurlException $e) {
        # cURL error
        echo $e;
        print_R($e->getRequest());
        print_R($e->getResponse());
    }
}

function get_store_data() {
    try {
        $shopify = shopify\client(SHOPIFY_SHOP, SHOPIFY_APP_API_KEY, SHOPIFY_APP_PASSWORD, true);
        $shop_content = $shopify('GET /admin/shop.json?fields=id,name,domain');
        $shop_json = json_encode($shop_content, true);
        echo $shop_json;
    } catch (shopify\ApiException $e) {
        # HTTP status code was >= 400 or response contained the key 'errors'
        echo $e;
        print_R($e->getRequest());
        print_R($e->getResponse());
    } catch (shopify\CurlException $e) {
        # cURL error
        echo $e;
        print_R($e->getRequest());
        print_R($e->getResponse());
    }
}
