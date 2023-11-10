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
});

