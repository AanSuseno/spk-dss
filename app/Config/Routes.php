<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::index');
$routes->get('/logout', 'Home::logout');

$routes->get('/dashboard', 'Home::dashboard_user', ['filter' => 'loginUser']);

$routes->group('/projects', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('(:alphanum)', 'Projects::index/$1');
	$routes->post('create/(:alphanum)', 'Projects::create/$1');
	$routes->post('delete/(:alphanum)/(:num)', 'Projects::delete/$1/$2');
});

// ahp
$routes->group('/ahp', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('/', 'AnalyticalHierarchyProcess::index');
	$routes->get('detail/(:num)', 'AnalyticalHierarchyProcess::detail/$1');
	$routes->get('(:num)/criteria', 'AnalyticalHierarchyProcess::criteria/$1');
	$routes->post('(:num)/criteria/create', 'AnalyticalHierarchyProcess::criteria_create/$1');
	$routes->post('(:num)/criteria/delete/(:num)', 'AnalyticalHierarchyProcess::criteria_delete/$1/$2');
	$routes->get('(:num)/criteria_weight', 'AnalyticalHierarchyProcess::criteria_weight/$1');
	$routes->post('(:num)/criteria_weight/update', 'AnalyticalHierarchyProcess::criteria_weight_update/$1');
	$routes->get('(:num)/sub_criteria', 'AnalyticalHierarchyProcess::sub_criteria/$1');
	$routes->post('(:num)/sub_criteria/create/(:num)', 'AnalyticalHierarchyProcess::sub_criteria_create/$1/$2');
	$routes->post('(:num)/sub_criteria/delete/(:num)', 'AnalyticalHierarchyProcess::sub_criteria_delete/$1/$2');
	$routes->get('(:num)/sub_criteria_weight/', 'AnalyticalHierarchyProcess::sub_criteria_weight/$1');
	$routes->get('(:num)/sub_criteria_weight/(:num)', 'AnalyticalHierarchyProcess::sub_criteria_weight_json/$1/$2');
	$routes->post('(:num)/sub_criteria_weight/update', 'AnalyticalHierarchyProcess::sub_criteria_weight_update/$1');
	$routes->get('(:num)/alternatives', 'AnalyticalHierarchyProcess::alternatives/$1');
	$routes->post('(:num)/alternatives/create', 'AnalyticalHierarchyProcess::alternatives_create/$1');
	$routes->post('(:num)/alternatives/delete/(:num)', 'AnalyticalHierarchyProcess::alternatives_delete/$1/$2');
	$routes->get('(:num)/alternatives/sub_c/(:num)', 'AnalyticalHierarchyProcess::alternatives_sub_criteria/$1/$2');
	$routes->post('(:num)/alternatives/update/(:num)', 'AnalyticalHierarchyProcess::alternatives_update/$1/$2');
	$routes->get('(:num)/result', 'AnalyticalHierarchyProcess::result/$1');
	$routes->post('(:num)/random_index/update', 'AnalyticalHierarchyProcess::random_index_update/$1');
});

// saw
$routes->group('/saw', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('/', 'SimpleAdditiveWeighting::index');
	$routes->get('detail/(:num)', 'SimpleAdditiveWeighting::detail/$1');
	$routes->get('(:num)/criteria', 'SimpleAdditiveWeighting::criteria/$1');
	$routes->post('(:num)/criteria/create', 'SimpleAdditiveWeighting::criteria_create/$1');
	$routes->post('(:num)/criteria/delete/(:num)', 'SimpleAdditiveWeighting::criteria_delete/$1/$2');
	$routes->get('(:num)/alternatives', 'SimpleAdditiveWeighting::alternatives/$1');
	$routes->post('(:num)/alternatives/create', 'SimpleAdditiveWeighting::alternatives_create/$1');
	$routes->post('(:num)/alternatives/delete/(:num)', 'SimpleAdditiveWeighting::alternatives_delete/$1/$2');
	$routes->get('(:num)/normalized', 'SimpleAdditiveWeighting::normalized/$1');
	$routes->post('(:num)/sub_criteria/create/(:num)', 'SimpleAdditiveWeighting::sub_criteria_create/$1/$2');
	$routes->get('(:num)/sub_criteria/(:num)', 'SimpleAdditiveWeighting::sub_criteria_json/$1/$2');
	$routes->get('(:num)/sub_criteria/delete/(:num)', 'SimpleAdditiveWeighting::sub_criteria_delete/$1/$2');
});

// wp
$routes->group('/wp', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('/', 'WeightedProduct::index');
	$routes->get('detail/(:num)', 'WeightedProduct::detail/$1');
	$routes->get('(:num)/criteria', 'WeightedProduct::criteria/$1');
	$routes->post('(:num)/criteria/create', 'WeightedProduct::criteria_create/$1');
	$routes->post('(:num)/criteria/delete/(:num)', 'WeightedProduct::criteria_delete/$1/$2');
	$routes->post('(:num)/sub_criteria/create/(:num)', 'WeightedProduct::sub_criteria_create/$1/$2');
	$routes->get('(:num)/sub_criteria/(:num)', 'WeightedProduct::sub_criteria_json/$1/$2');
	$routes->get('(:num)/sub_criteria/delete/(:num)', 'WeightedProduct::sub_criteria_delete/$1/$2');
	$routes->get('(:num)/alternatives', 'WeightedProduct::alternatives/$1');
	$routes->post('(:num)/alternatives/create', 'WeightedProduct::alternatives_create/$1');
	$routes->post('(:num)/alternatives/delete/(:num)', 'WeightedProduct::alternatives_delete/$1/$2');
});


// topsis
$routes->group('/topsis', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('/', 'Topsis::index');
	$routes->get('detail/(:num)', 'Topsis::detail/$1');
	$routes->get('(:num)/criteria', 'Topsis::criteria/$1');
	$routes->post('(:num)/criteria/create', 'Topsis::criteria_create/$1');
	$routes->post('(:num)/criteria/delete/(:num)', 'Topsis::criteria_delete/$1/$2');
	$routes->post('(:num)/sub_criteria/create/(:num)', 'Topsis::sub_criteria_create/$1/$2');
	$routes->get('(:num)/sub_criteria/(:num)', 'Topsis::sub_criteria_json/$1/$2');
	$routes->get('(:num)/sub_criteria/delete/(:num)', 'Topsis::sub_criteria_delete/$1/$2');
	$routes->get('(:num)/alternatives', 'Topsis::alternatives/$1');
	$routes->post('(:num)/alternatives/create', 'Topsis::alternatives_create/$1');
	$routes->post('(:num)/alternatives/delete/(:num)', 'Topsis::alternatives_delete/$1/$2');
	$routes->get('(:num)/normalized', 'Topsis::alternatives/$1/normalized');
	$routes->get('(:num)/normalized-weight', 'Topsis::alternatives/$1/normalized_weight');
	$routes->get('(:num)/ideal_solutions', 'Topsis::alternatives/$1/ideal_solutions');
	$routes->get('(:num)/preference_score', 'Topsis::alternatives/$1/preference_score');
});

// smart
$routes->group('/smart', ['filter' => 'loginUser'], function ($routes) {
	$routes->get('/', 'Smart::index');
	$routes->get('detail/(:num)', 'Smart::detail/$1');
	$routes->get('(:num)/criteria', 'Smart::criteria/$1');
	$routes->post('(:num)/criteria/create', 'Smart::criteria_create/$1');
	$routes->post('(:num)/criteria/delete/(:num)', 'Smart::criteria_delete/$1/$2');
	$routes->get('(:num)/alternatives', 'Smart::alternatives/$1');
	$routes->get('(:num)/alternatives/(:alpha)', 'Smart::alternatives/$1/$2');
	$routes->post('(:num)/alternatives/create', 'Smart::alternatives_create/$1');
	$routes->post('(:num)/alternatives/delete/(:num)', 'Smart::alternatives_delete/$1/$2');
});

