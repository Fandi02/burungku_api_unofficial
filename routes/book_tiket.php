<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/bookTiket', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM booktiket';

      try {
          $db = new db();
          $db = $db->connect();

          $stmt = $db->query($sql);
          $booktiket = $stmt->fetchAll(PDO::FETCH_OBJ);

          $db = null;
          $response->getBody()->write(json_encode($booktiket));
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
    $sql = "SELECT * FROM `booktiket` WHERE id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $booktiketid = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($booktiketid));
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
    $event_id = $request->getParam('event_id');
    $user_id = $request->getParam('user_id');
    $nomer_tiket = $request->getParam('nomer_tiket');
    $is_canceled = $request->getParam('is_canceled');

    $sql = "INSERT INTO booktiket (id, event_id, user_id, nomer_tiket, is_canceled) 
            VALUES (:id, :event_id, :user_id, :nomer_tiket, :is_canceled)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':nomer_tiket', $nomer_tiket);
        $stmt->bindParam(':is_canceled', $is_canceled);

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

    $sql = "DELETE FROM booktiket WHERE  `id` = '$id'";

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
        $event_id = $data["event_id"];
        $user_id = $data["user_id"];
        $nomer_tiket = $data["nomer_tiket"];
        $is_canceled = $data["is_canceled"];

        $sql = "UPDATE booktiket SET
            event_id = '$event_id',
            user_id = '$user_id',
            nomer_tiket = '$nomer_tiket',
            is_canceled = '$is_canceled'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':nomer_tiket', $nomer_tiket);
            $stmt->bindParam(':is_canceled', $is_canceled);

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