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
    $sql = "SELECT * FROM event join lokasi ON event.id = lokasi.event_id WHERE event.id = '$id'";

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
    $id_lokasi = create_guid();
    $judul = $request->getParam('judul');
    $deskripsi = $request->getParam('deskripsi');
    $tanggal = $request->getParam('tanggal');
    $jam = $request->getParam('jam');
    $jml_tiket = $request->getParam('jml_tiket');
    $jml_sesi = $request->getParam('jml_sesi');
    $harga_tiket = $request->getParam('harga_tiket');
    $aturan = $request->getParam('aturan');
    $jenisburung_id = $request->getParam('jenisburung_id');
    $kota = $request->getParam('kota');
    $jenislomba_id = $request->getParam('jenislomba_id');
    $jml_kol = $request->getParam('jml_kol');
    $jml_baris = $request->getParam('jml_baris');

    $sql = "INSERT INTO event (id, judul, deskripsi, tanggal, jam, jml_tiket, jml_sesi, harga_tiket, aturan, jenisburung_id, jenislomba_id, jml_kol, jml_baris) 
    VALUES (:id, :judul, :deskripsi, :tanggal, :jam, :jml_tiket, :jml_sesi, :harga_tiket, :aturan, :jenisburung_id, :jenislomba_id, :jml_kol, :jml_baris)";

    $lokasi = "INSERT INTO lokasi (id, kota, event_id) 
    VALUES (:id_lokasi, :kota, :event_id)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':jam', $jam);
        $stmt->bindParam(':jml_tiket', $jml_tiket);
        $stmt->bindParam(':jml_sesi', $jml_sesi);
        $stmt->bindParam(':harga_tiket', $harga_tiket);
        $stmt->bindParam(':aturan', $aturan);
        $stmt->bindParam(':jenisburung_id', $jenisburung_id);
        $stmt->bindParam(':jenislomba_id', $jenislomba_id);
        $stmt->bindParam(':jml_kol', $jml_kol);
        $stmt->bindParam(':jml_baris', $jml_baris);

        $stmt2 = $db->prepare($lokasi);
        $stmt2->bindParam(':id_lokasi', $id_lokasi);
        $stmt2->bindParam(':kota', $kota);
        $stmt2->bindParam(':event_id', $id);

        //$result2 = $stmt2->execute();
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
        $judul = $request->getParam('judul');
        $deskripsi = $request->getParam('deskripsi');
        $tanggal = $request->getParam('tanggal');
        $jam = $request->getParam('jam');
        $jml_tiket = $request->getParam('jml_tiket');
        $jml_sesi = $request->getParam('jml_sesi');
        $harga_tiket = $request->getParam('harga_tiket');
        $aturan = $request->getParam('aturan');
        $jenisburung_id = $request->getParam('jenisburung_id');
        $kota = $request->getParam('lokasi');
        $jenislomba_id = $request->getParam('jenislomba_id');
        $jml_kol = $request->getParam('jml_kol');
        $jml_baris = $request->getParam('jml_baris');

        // $sql = "UPDATE event SET
        //     judul = '$judul',
        //     deskripsi = '$deskripsi',
        //     tanggal = '$tanggal',
        //     jml_tiket = '$jml_tiket',
        //     jml_sesi = '$jml_sesi',
        //     harga_tiket = '$harga_tiket',
        //     aturan = '$aturan',
        //     jenisburung_id = '$jenisburung_id',
        //     kota = '$kota',
        //     jenislomba_id = '$jenislomba_id'
        //     jam = '$jam'
        //     jml_kol = '$jml_kol'
        //     jml_baris = '$jml_baris'
        //     WHERE id = '$id'";

        $update = "UPDATE event, lokasi SET
        event.judul = '$judul',
        event.deskripsi = '$deskripsi',
        event.tanggal = '$tanggal',
        event.jml_tiket = '$jml_tiket',
        event.jml_sesi = '$jml_sesi',
        event.harga_tiket = '$harga_tiket',
        event.aturan = '$aturan',
        event.jenisburung_id = '$jenisburung_id',
        event.kota = '$kota',
        event.jenislomba_id = '$jenislomba_id'
        event.jam = '$jam'
        event.jml_kol = '$jml_kol'
        event.jml_baris = '$jml_baris'
        lokasi.kota = '$kota'
        WHERE event.id = lokasi.event_id and event.id = '$id'
        ";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($update);
            $stmt->bindParam('event.id', $id);
            $stmt->bindParam('event.judul', $judul);
            $stmt->bindParam('event.deskripsi', $deskripsi);
            $stmt->bindParam('event.tanggal', $tanggal);
            $stmt->bindParam('event.jam', $jam);
            $stmt->bindParam('event.jml_tiket', $jml_tiket);
            $stmt->bindParam('event.jml_sesi', $jml_sesi);
            $stmt->bindParam('event.harga_tiket', $harga_tiket);
            $stmt->bindParam('event.aturan', $aturan);
            $stmt->bindParam('event.jenisburung_id', $jenisburung_id);
            $stmt->bindParam('event.jenislomba_id', $jenislomba_id);
            $stmt->bindParam('event.jml_kol', $Jml_kol);
            $stmt->bindParam('event.jml_baris', $jml_baris);
            $stmt->bindParam('lokasi.kota', $kota);

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