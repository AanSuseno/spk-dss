<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('/projects', function ($routes) {
	$routes->get('(:alphanum)', 'Projects::index/$1');
	$routes->post('create/(:alphanum)', 'Projects::create/$1');
	$routes->post('delete/(:alphanum)/(:num)', 'Projects::delete/$1/$2');
});

// ahp
$routes->group('/ahp', function ($routes) {
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
});

