<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/peserta', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM peserta';

      try {
          $db = new db();
          $db = $db->connect();

          $stmt = $db->query($sql);
          $transaksi = $stmt->fetchAll(PDO::FETCH_OBJ);

          $db = null;
          $response->getBody()->write(json_encode($transaksi));
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
    $sql = "SELECT * FROM `peserta` WHERE id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $databankid = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($databankid));
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
    $user_id = $request->getParam('user_id');
    $event_id = $request->getParam('event_id');
    $transaksi_id = $request->getParam('transaksi_id');

    $sql = "INSERT INTO peserta (id, nama, user_id, event_id, transaksi_id) 
            VALUES (:id, :nama, :user_id, :event_id, :transaksi_id)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':transaksi_id', $transaksi_id);
        
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

    $sql = "DELETE FROM peserta WHERE  `id` = '$id'";

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
        $nama = $data["nama"];
        $user_id = $data["user_id"];
        $event_id = $data["event_id"];
        $transaksi_id = $data["transaksi_id"];
        

        $sql = "UPDATE peserta SET
            nama = '$nama',
            user_id = '$user_id',
            event_id = '$event_id',
            transaksi_id = '$transaksi_id'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->bindParam(':transaksi_id', $transaksi_id);

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