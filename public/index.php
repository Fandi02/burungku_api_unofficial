<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../config/guid.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello world!');
    return $response;
});

//jenisburung
require __DIR__ . '/../routes/jenis_burung.php';

//Data_bank
require __DIR__ . '/../routes/data_bank.php';

//event
require __DIR__ . '/../routes/event.php';

//lokasi
require __DIR__ . '/../routes/lokasi.php';


//book tiket
require __DIR__ . '/../routes/book_tiket.php';

//transaksi
require __DIR__ . '/../routes/transaksi.php';

//auth
require __DIR__ . '/../routes/auth.php';

//peserta
require __DIR__ . '/../routes/peserta.php';

$app->run();