<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Retrieves all bundles
$app->get(
    '/list-all-broadband',
    function () {
        // Operation to fetch all the broadbands
        $broadbands = [
            [
                'title' => 'Test1',
                'price' => '60',
                'bundles' => ['A', 'B', 'C']
            ],
            [
                'title' => 'Test2',
                'price' => '15',
                'bundles' => ['C', 'D', 'E']
            ],
            [
                'title' => 'Test3',
                'price' => '23',
                'bundles' => ['A', 'E', 'C']
            ],
            [
                'title' => 'Test4',
                'price' => '60',
                'bundles' => ['D', 'B', 'C']
            ]
        ];
        echo json_encode($broadbands);
    }
);

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
});

$app->handle();
