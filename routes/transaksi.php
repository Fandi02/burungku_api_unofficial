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

  //route cek tiket
  $app->get('/cek/{event_id}', function (Request $request, Response $response,array $args) {
    $event_id = $args['event_id'];

    $sql = "SELECT COUNT(user_id) jml_tiket 
            FROM transaksi WHERE event_id = '$event_id'";

    $jml_tiket = "SELECT jml_tiket FROM event WHERE id = '$event_id'";

    try {
        $db = new db();
        $db = $db->connect();

        $db = null;

        if($sql < $jml_tiket){
            $print = "tersedia";
            $response->getBody()->write(json_encode($print));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }else{
            $print = "tidak tersedia";
            $response->getBody()->write(json_encode($print));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }
        
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

    //route by user
    $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $sql = "SELECT * FROM transaksi
                JOIN user ON transaksi.user_id = user.id
                WHERE user.id = '$id'";
  
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
    $metode_pembayaran = $request->getParam('metode_pembayaran');
    $status = 1;

    $sql = "INSERT INTO transaksi (id, user_id, event_id, sesi, no_kursi, metode_pembayaran, status) 
            VALUES (:id, :user_id, :event_id, :sesi, :no_kursi, :metode_pembayaran, :status)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':sesi', $sesi);
        $stmt->bindParam(':no_kursi', $no_kursi);
        $stmt->bindParam(':metode_pembayaran', $metode_pembayaran);
        $stmt->bindParam(':status', $status);
        
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