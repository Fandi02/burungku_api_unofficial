<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//grup route
$app->group('/lokasi', function(\Slim\Routing\RouteCollectorProxy $app){
    //route get
  $app->get('', function (Request $request, Response $response, $args) {
    $sql = 'SELECT * FROM lokasi';

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $lokasi = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($lokasi));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch(PDOException $e) {
        $error = array(
            'Message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    });

    //route get by id
  $app->get('/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM lokasi WHERE id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $lokasiid = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($lokasiid));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch(PDOException $e) {
        $error = array(
            'Message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
  });

  //route post by id
  $app->post('/add', function (Request $request, Response $response, array $args) {
    $id = com_create_guid();
    $kota = $request->getParam('kota');
    $longitude = $request->getParam('longitude');
    $latitude = $request->getParam('latitude');

    $sql = "INSERT INTO lokasi (id, kota, longitude, latitude) VALUES (:id, :kota, :longitude, :latitude)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':kota', $kota);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':latitude', $latitude);

        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch(PDOException $e) {
        $error = array(
            'Message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
  });

  //route delete by id
  $app->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $sql = "DELETE FROM lokasi WHERE  id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch(PDOException $e) {
        $error = array(
            'Message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
  });

  //route update by id   
    $app->put('/update/{id}',function (Request $request, Response $response, array $args) 
  {
  $id = $request->getAttribute('id');
  $data = $request->getParsedBody();
  $id = $data["id"];
  $kota = $data["kota"];
  $longitude = $data["longitude"];
    $latitude = $data["latitude"];

  $sql = "UPDATE lokasi SET 
            id = '$id',
            kota = '$kota',
            longitude = '$longitude',
            latitude = '$latitude'
  WHERE id = '$id'";

  try {
    $db = new Db();
    $conn = $db->connect();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':kota', $kota);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':latitude', $latitude);

    $result = $stmt->execute();

    $db = null;
    echo "Update successful! ";
    $response->getBody()->write(json_encode($result));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  } catch (PDOException $e) {
    $error = array(
      "message" => $e->getMessage()
    );

    $response->getBody()->write(json_encode($error));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(500);
  }
  }); 
});