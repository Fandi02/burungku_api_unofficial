<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//grup route
$app->group('/jenisBurung', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM jenisburung';

      try {
          $db = new db();
          $db = $db->connect();

          $stmt = $db->query($sql);
          $jenisburung = $stmt->fetchAll(PDO::FETCH_OBJ);

          $db = null;
          $response->getBody()->write(json_encode($jenisburung));
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
    $sql = "SELECT * FROM `jenisburung` WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $jenisburungid = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($jenisburungid));
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
    $id = create_guid();
    $nama = $request->getParam('nama');

    $sql = "INSERT INTO jenisburung (id, nama) VALUES (:id, :nama)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);

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

    $sql = "DELETE FROM jenisburung WHERE  `id` = $id";

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
  $app->put('/update/{id}',function (Request $request, Response $response, array $args) {
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $id = $data["id"];
    $nama = $data["nama"];

    $sql = "UPDATE jenisburung SET 
            id = '$id',
            nama = '$nama'
    WHERE id = $id";

    try {
    $db = new Db();
    $conn = $db->connect();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nama', $nama);

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