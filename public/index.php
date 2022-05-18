<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello world!');
    return $response;
});

//jenisburung
require __DIR__ . '/../routes/jenis_burung.php';

//Data_bank
require __DIR__ . '/../routes/data_bank.php';

$app->run();