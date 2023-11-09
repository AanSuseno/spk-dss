<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('/projects', function ($routes) {
	$routes->get('(:alphanum)', 'Projects::index/$1');
});

// ahp
$routes->group('/ahp', function ($routes) {
	$routes->get('/', 'AnalyticalHierarchyProcess::index');
});

