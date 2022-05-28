<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/sesi', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = "SELECT * FROM sesi";

      try {
          $db = new db();
          $db = $db->connect();

          $stmt = $db->query($sql);
          $event = $stmt->fetchAll(PDO::FETCH_OBJ);

          $db = null;
          $response->getBody()->write(json_encode($event));
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

    //route post event
    $app->post('/add', function (Request $request, Response $response, array $args) {
        $id = create_guid();
        $no = $request->getParam('no');
        $jam_start = $request->getParam('jam_start');
        $jam_end = $request->getParam('jam_end');
        $id_event = $request->getParam('id_event');
    
        $sql = "INSERT INTO sesi (id, no, jam_start, jam_end, id_event) 
                VALUES (:id, :no, :jam_start, :jam_end, :id_event)";
    
        try {
            $db = new db();
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':no', $no);
            $stmt->bindParam(':jam_start', $jam_start);
            $stmt->bindParam(':jam_end', $jam_end); 
            $stmt->bindParam(':id_event', $id_event);
    
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

    $sql = "DELETE FROM sesi WHERE  `id` = '$id'";

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
    $no = $data["no"];
    $jam_start = $data["jam_start"];
    $jam_end = $data["jam_end"];

    $sql = "UPDATE sesi SET 
            no = '$no',
            jam_start = '$jam_start',
            jam_end = '$jam_end'
            WHERE id = '$id'";

    try {
    $db = new Db();
    $conn = $db->connect();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':no', $no);
    $stmt->bindParam(':jam_start', $jam_start);
    $stmt->bindParam(':jam_end', $jam_end);

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