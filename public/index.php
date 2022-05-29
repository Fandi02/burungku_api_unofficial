<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../config/guid.php';
require __DIR__ . '/../config/otp.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello world!');
    return $response;
});

//eo
require __DIR__ . '/../routes/eo.php';

//jenis burung
require __DIR__ . '/../routes/jenis_burung.php';

//event
require __DIR__ . '/../routes/event.php';

//lokasi
require __DIR__ . '/../routes/lokasi.php';

//transaksi
require __DIR__ . '/../routes/transaksi.php';

//profil
require __DIR__ . '/../routes/profil.php';

//admin
require __DIR__ . '/../routes/admin.php';

//user
require __DIR__ . '/../routes/user.php';

//sesi
require __DIR__ . '/../routes/sesi.php';

//login oauth
require __DIR__ . '/../routes/social-login.php';
require __DIR__ . '/../routes/auth.php';

// $app->add(function ($req, $res, $next) {
//     $response = $next($req, $res);
//     return $response
//             ->withHeader('Access-Control-Allow-Origin', 'http://127.0.0.1:5000')
//             ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
//             ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
// });

$app->run();
