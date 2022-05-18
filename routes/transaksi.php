<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/transaksi', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM transaksi';

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
    $sql = "SELECT * FROM `transaksi` WHERE id = '$id'";

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
    $user_id = $request->getParam('user_id');
    $event_id = $request->getParam('event_id');
    $sesi = $request->getParam('sesi');
    $no_kursi = $request->getParam('no_kursi');
    $booktiket_id = $request->getParam('booktiket_id');
    $bukti_pembayaran = $request->getParam('bukti_pembayaran');

    $sql = "INSERT INTO transaksi (id, user_id, event_id, sesi, no_kursi, booktiket_id, bukti_pembayaran) 
            VALUES (:id, :user_id, :event_id, :sesi, :no_kursi, :booktiket_id, :bukti_pembayaran)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':sesi', $sesi);
        $stmt->bindParam(':no_kursi', $no_kursi);
        $stmt->bindParam(':booktiket_id', $booktiket_id);
        $stmt->bindParam(':bukti_pembayaran', $bukti_pembayaran);
        
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

    $sql = "DELETE FROM transaksi WHERE  `id` = '$id'";

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
        $user_id = $data["user_id"];
        $event_id = $data["event_id"];
        $sesi = $data["sesi"];
        $no_kursi = $data["no_kursi"];
        $booktiket_id = $data["booktiket_id"];
        $bukti_pembayaran = $data["bukti_pembayaran"];

        $sql = "UPDATE transaksi SET
            user_id = '$user_id',
            event_id = '$event_id',
            sesi = '$sesi',
            no_kursi = '$no_kursi',
            booktiket_id = '$booktiket_id',
            bukti_pembayaran = '$bukti_pembayaran'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->bindParam(':sesi', $sesi);
            $stmt->bindParam(':no_kursi', $no_kursi);
            $stmt->bindParam(':booktiket_id', $booktiket_id);
            $stmt->bindParam(':bukti_pembayaran', $bukti_pembayaran);

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