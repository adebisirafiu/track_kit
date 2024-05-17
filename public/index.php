<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Request;
use App\Controllers\EmployeeController;

// Create a router instance
$router = new Router();
$request = new Request();

// Define routes
$router->add('/provider1', 'POST', [new EmployeeController(), 'handleProvider1']);
$router->add('/provider2', 'POST', [new EmployeeController(), 'handleProvider2']);

// Dispatch the request
$router->dispatch($request);
