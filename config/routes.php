<?php

/** @var \App\Core\Router $router */

$router->get('', 'HomeController@index');
$router->get('about', 'AboutController@index');
$router->get('products', 'ProductController@index');
$router->get('products/{slug}', 'ProductController@category');
$router->get('product/{slug}', 'ProductController@show');
$router->get('compare', 'CompareController@index');
$router->post('compare/add', 'CompareController@add');
$router->post('compare/remove', 'CompareController@remove');
$router->get('blog', 'BlogController@index');
$router->get('blog/{slug}', 'BlogController@show');
$router->get('faq', 'FaqController@index');
$router->get('contact', 'ContactController@index');
$router->post('contact', 'ContactController@submit');
$router->get('dealer-inquiry', 'DealerController@index');
$router->post('dealer-inquiry', 'DealerController@submit');
$router->get('track-delivery', 'TrackDeliveryController@index');
$router->post('track-delivery', 'TrackDeliveryController@submit');
$router->get('sitemap.xml', 'SeoController@sitemap');
$router->get('search', 'BlogController@search');
