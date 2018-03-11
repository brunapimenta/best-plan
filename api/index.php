<?php

use Phalcon\Mvc\Micro;
use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
       'BestPlan' => 'vendor/'
    ]
);

// Register autoloader
$loader->register();

$app = new Micro();

// Retrieves all bundles
$app->get(
    '/list-all-broadband',
    function () {
        // Operation to fetch all the broadbands
        $objBroadband = new BestPlan\Broadbands();
        echo json_encode($objBroadband->getAll());
    }
);

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
});

$app->handle();
