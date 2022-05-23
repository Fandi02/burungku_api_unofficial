<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/event', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM event';
        
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

  //route get by id
  $app->get('/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM `event` WHERE id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $eventid = $stmt->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($eventid));
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
    $judul = $request->getParam('judul');
    $deskripsi = $request->getParam('deskripsi');
    $jadwal = $request->getParam('jadwal');
    $jml_tiket = $request->getParam('jml_tiket');
    $jml_sesi = $request->getParam('jml_sesi');
    $harga_tiket = $request->getParam('harga_tiket');
    $aturan = $request->getParam('aturan');
    $jenisburung_id = $request->getParam('jenisburung_id');
    $lokasi_id = $request->getParam('lokasi_id');
    $jenislomba_id = $request->getParam('jenislomba_id');

    $sql = "INSERT INTO event (id, judul, deskripsi, jadwal, jml_tiket, jml_sesi, harga_tiket, aturan, jenisburung_id, lokasi_id,jenislomba_id) 
    VALUES (:id, :judul, :deskripsi, :jadwal, :jml_tiket, :jml_sesi, :harga_tiket, :aturan, :jenisburung_id, :lokasi_id, :jenislomba_id)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':jadwal', $jadwal);
        $stmt->bindParam(':jml_tiket', $jml_tiket);
        $stmt->bindParam(':jml_sesi', $jml_sesi);
        $stmt->bindParam(':harga_tiket', $harga_tiket);
        $stmt->bindParam(':aturan', $aturan);
        $stmt->bindParam(':jenisburung_id', $jenisburung_id);
        $stmt->bindParam(':lokasi_id', $lokasi_id);
        $stmt->bindParam(':jenislomba_id', $jenislomba_id);

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

    $sql = "DELETE FROM event WHERE  `id` = '$id'";

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
        $judul = $data["judul"];
        $deskripsi = $data["deskripsi"];
        $jadwal = $data["jadwal"];
        $jml_tiket = $data["jml_tiket"];
        $jml_sesi = $data["jml_sesi"];
        $harga_tiket = $data["harga_tiket"];
        $aturan = $data["aturan"];
        $jenisburung_id = $data["jenisburung_id"];
        $lokasi_id = $data["lokasi_id"];
        $jenislomba_id = $data["jenislomba_id"];

        $sql = "UPDATE event SET
            judul = '$judul',
            deskripsi = '$deskripsi',
            jadwal = '$jadwal',
            jml_tiket = '$jml_tiket',
            jml_sesi = '$jml_sesi',
            harga_tiket = '$harga_tiket',
            aturan = '$aturan',
            jenisburung_id = '$jenisburung_id',
            lokasi_id = '$lokasi_id',
            jenislomba_id = '$jenislomba_id'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':judul', $judul);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':jadwal', $jadwal);
            $stmt->bindParam(':jml_tiket', $jml_tiket);
            $stmt->bindParam(':jml_sesi', $jml_sesi);
            $stmt->bindParam(':harga_tiket', $harga_tiket);
            $stmt->bindParam(':aturan', $aturan);
            $stmt->bindParam(':jenisburung_id', $jenisburung_id);
            $stmt->bindParam(':lokasi_id', $lokasi_id);
            $stmt->bindParam(':jenislomba_id', $jenislomba_id);

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