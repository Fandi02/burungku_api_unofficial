<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/event', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = "SELECT * FROM eventlokasi 
            join lokasi ON lokasi.id = eventlokasi.lokasi_id
            join kota ON kota.id = lokasi.kota_id
            join event ON event.id = eventlokasi.event_id";
        
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
    $sql = "SELECT * FROM `eventlokasi` 
            join lokasi ON lokasi.id = eventlokasi.lokasi_id
            join event ON event.id = eventlokasi.event_id
            join kota ON kota.id = lokasi.kota_id 
            WHERE eventlokasi.id = '$id'";

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

  //route get by eo
  $app->get('/eo/{role}', function (Request $request, Response $response, array $args) {
    $role = $args['role'];
    $email = $request->getParam('email');
    $sql = "SELECT * FROM eventlokasi 
            join lokasi ON event.id = lokasi.event_id 
            join user ON event.user_id = user.id
            WHERE user.role = '$role' AND user.email = '$email'";

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

    //route get by lokasi
  $app->get('/lokasi/{lokasi_id}', function (Request $request, Response $response, array $args) {
    $lokasi = $args['lokasi_id'];
    $sql = "SELECT * FROM eventlokasi 
            join lokasi ON lokasi.id = eventlokasi.lokasi_id
            join event ON event.id = eventlokasi.event_id
            WHERE lokasi.kota_id = '$lokasi'";

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

  $app->group('/nama', function(\Slim\Routing\RouteCollectorProxy $app){
    // get nama - nama event
    // $app->get('', function (Request $request, Response $response, $args) {
    //     $sql = "SELECT nama FROM event";
      
    //     try {
    //         $db = new db();
    //         $db = $db->connect();

    //         $stmt = $db->query($sql);
    //         $nama_event = $stmt->fetchAll(PDO::FETCH_OBJ);

    //         $db = null;
    //         $response->getBody()->write(json_encode($nama_event));
    //         return $response
    //         ->withHeader('content-type', 'application/json')
    //         ->withStatus(200);
    //     } catch(PDOException $e) {
    //         $error = array(
    //             'Message' => $e->getMessage()
    //         );

    //         $response->getBody()->write(json_encode($error));
    //         return $response
    //         ->withHeader('content-type', 'application/json')
    //         ->withStatus(500);
    //     }
    
    // });

      // get by nama
    $app->get('/{nama}', function (Request $request, Response $response, array $args) {
        $nama = $args['nama'];
        $sql = "SELECT * FROM eventlokasi 
            join lokasi ON lokasi.id = eventlokasi.lokasi_id
            join event ON event.id = eventlokasi.event_id
            WHERE event.nama = '$nama'";

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
  });

  $app->get('/search/{search}', function (Request $request, Response $response, array $args) {
    $search = $args['search'];
    $sql = "SELECT * FROM eventlokasi 
        join lokasi ON lokasi.id = eventlokasi.lokasi_id
        join event ON event.id = eventlokasi.event_id
        WHERE event.nama LIKE '%$search%'";

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

//route post event
  $app->post('/add', function (Request $request, Response $response, array $args) {
    $id = create_guid();
    $nama = $request->getParam('nama');
    $deskripsi = $request->getParam('deskripsi');
    $tgl = $request->getParam('tgl');
    $jam = $request->getParam('jam');
    $jml_tiket = $request->getParam('jml_tiket');
    $jml_sesi = $request->getParam('jml_sesi');
    $harga = $request->getParam('harga');
    $aturan = $request->getParam('aturan');
    $jenisburung_id = $request->getParam('jenisburung_id');
    $jml_kol = $request->getParam('jml_kol');
    $jml_baris = $request->getParam('jml_baris');

    $sql = "INSERT INTO `event` (`id`, `nama`, `tgl`, `jam`, `deskripsi`, 
    `jml_kol`, `jml_baris`, `jml_tiket`, `jml_sesi`, `harga`, `aturan`, `jenisburung_id`) 
    VALUES (:id, :nama, :tgl, :jam, :deskripsi, :jml_kol, :jml_baris, :jml_tiket,
    :jml_sesi, :harga, :aturan, :jenisburung_id)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':tgl', $tgl);
        $stmt->bindParam(':jam', $jam);
        $stmt->bindParam(':jml_tiket', $jml_tiket);
        $stmt->bindParam(':jml_sesi', $jml_sesi);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':aturan', $aturan);
        $stmt->bindParam(':jenisburung_id', $jenisburung_id);
        $stmt->bindParam(':jml_kol', $jml_kol);
        $stmt->bindParam(':jml_baris', $jml_baris);

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

    //route post eventlokasi
    $app->post('/evlok/add', function (Request $request, Response $response, array $args) {
        $id = create_guid();
        $event_id = $request->getParam('event_id');
        $lokasi_id = $request->getParam('lokasi_id');
    
        $sql = "INSERT INTO eventlokasi (id, event_id , lokasi_id) 
        VALUES (:id, :event_id, :lokasi_id)";
    
        try {
            $db = new db();
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->bindParam(':lokasi_id', $lokasi_id);
    
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

    $sql = "DELETE FROM eventlokasi WHERE  `id` = '$id'";

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
        $nama = $request->getParam('nama');
        $deskripsi = $request->getParam('deskripsi');
        $tgl = $request->getParam('tgl');
        $jam = $request->getParam('jam');
        $jml_tiket = $request->getParam('jml_tiket');
        $jml_sesi = $request->getParam('jml_sesi');
        $harga = $request->getParam('harga');
        $aturan = $request->getParam('aturan');
        $jenisburung_id = $request->getParam('jenisburung_id');
        $jenislomba_id = $request->getParam('jenislomba_id');
        $jml_kol = $request->getParam('jml_kol');
        $jml_baris = $request->getParam('jml_baris');

        $sql = "UPDATE event SET
            nama = '$nama',
            deskripsi = '$deskripsi',
            tgl = '$tgl',
            jml_tiket = '$jml_tiket',
            jml_sesi = '$jml_sesi',
            harga = '$harga',
            aturan = '$aturan',
            jenisburung_id = '$jenisburung_id',
            jam = '$jam',
            jml_kol = '$jml_kol',
            jml_baris = '$jml_baris'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam('id', $id);
            $stmt->bindParam('judul', $judul);
            $stmt->bindParam('deskripsi', $deskripsi);
            $stmt->bindParam('tgl', $tgl);
            $stmt->bindParam('jam', $jam);
            $stmt->bindParam('jml_tiket', $jml_tiket);
            $stmt->bindParam('jml_sesi', $jml_sesi);
            $stmt->bindParam('harga', $harga_tiket);
            $stmt->bindParam('aturan', $aturan);
            $stmt->bindParam('jenisburung_id', $jenisburung_id);
            $stmt->bindParam('jml_kol', $Jml_kol);
            $stmt->bindParam('jml_baris', $jml_baris);

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
    
    //route post eventlokasi
    $app->post('/full/add', function (Request $request, Response $response, array $args) {
        $id = create_guid();
        $nama = $request->getParam('nama');
        $deskripsi = $request->getParam('deskripsi');
        $tgl = $request->getParam('tgl');
        $jam = $request->getParam('jam');
        $jml_tiket = $request->getParam('jml_tiket');
        $jml_sesi = $request->getParam('jml_sesi');
        $harga = $request->getParam('harga');
        $aturan = $request->getParam('aturan');
        $jenisburung_id = $request->getParam('jenisburung_id');
        $jml_kol = $request->getParam('jml_kol');
        $jml_baris = $request->getParam('jml_baris');
    
        $sql = "INSERT INTO `event` (`id`, `nama`, `tgl`, `jam`, `deskripsi`, 
        `jml_kol`, `jml_baris`, `jml_tiket`, `jml_sesi`, `harga`, `aturan`, `jenisburung_id`) 
        VALUES (:id, :nama, :tgl, :jam, :deskripsi, :jml_kol, :jml_baris, :jml_tiket,
        :jml_sesi, :harga, :aturan, :jenisburung_id)";
    
        try {
            $db = new db();
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':tgl', $tgl);
            $stmt->bindParam(':jam', $jam);
            $stmt->bindParam(':jml_tiket', $jml_tiket);
            $stmt->bindParam(':jml_sesi', $jml_sesi);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':aturan', $aturan);
            $stmt->bindParam(':jenisburung_id', $jenisburung_id);
            $stmt->bindParam(':jml_kol', $jml_kol);
            $stmt->bindParam(':jml_baris', $jml_baris);
    
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
    
});