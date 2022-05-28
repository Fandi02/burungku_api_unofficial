<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/transaksi', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
  $app->get('', function (Request $request, Response $response, $args) {
      $sql = "SELECT t.id, e.nama nama_event, k.nama kota, e.tgl, s.jam_start 
            FROM transaksi t
            JOIN eventlokasi el ON el.id=t.eventlokasi_id
            JOIN event e ON e.id=el.event_id
            JOIN lokasi l ON l.id=el.lokasi_id
            JOIN kota k ON k.id=l.kota_id
            JOIN user u ON u.id=t.user_id
            JOIN sesi s ON s.id=t.sesi
            WHERE t.status = 1";

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
  $app->group('/cek', function(\Slim\Routing\RouteCollectorProxy $app){

    //cek kuota
    $app->get('/kuota/{event_id}', function (Request $request, Response $response,array $args) {
        $event_id = $args['event_id'];
    
        $sql = "SELECT COUNT(user_id) jml_daftar 
                FROM transaksi WHERE event_id = '$event_id'";
    
        $tiket = "SELECT jml_tiket FROM event WHERE id = '$event_id'";
    
        try {
            $db = new db();
            $db = $db->connect();
            
            $stmt = $db->query($sql);
            $cek_jml_daftar = $stmt->fetchAll(PDO::FETCH_OBJ);

            $stmt1 = $db->query($tiket);
            $cek_jml_tiket = $stmt1->fetchAll(PDO::FETCH_OBJ);

            $db = null;

            $cek_tiket = $cek_jml_tiket[0]->jml_tiket;
            $cek_daftar = $cek_jml_daftar[0]->jml_daftar;

            if($cek_daftar < $cek_tiket){
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

    //cek tanggal pendaftran
    $app->get('/tgl/{event_id}', function (Request $request, Response $response,array $args) {
        $event_id = $args['event_id'];
    
        $sql = "SELECT tgl_start, tgl_end, jam_start, jam_end FROM event WHERE id = '$event_id'";

        $tgl_now = date("Y-m-d");
        date_default_timezone_set('Asia/Jakarta');
        $jam_now = date("H:i:s");

        try {
            $db = new db();
            $db = $db->connect();

            $stmt = $db->query($sql);
            $cek = $stmt->fetchAll(PDO::FETCH_OBJ);

            $db = null;

            $cek_tgl_s = $cek[0]->tgl_start;
            $cek_tgl_e = $cek[0]->tgl_end;
            $cek_jam_s = $cek[0]->jam_start;
            $cek_jam_e = $cek[0]->jam_end;

            if($tgl_now <= $cek_tgl_e && $tgl_now >= $cek_tgl_s){
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
  });

    //route by user
    $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $sql = "SELECT t.id, e.nama nama_event, k.nama kota, e.tgl, s.jam_start 
                FROM transaksi t
                JOIN eventlokasi el ON el.id = t.eventlokasi_id
                JOIN event e ON e.id = t.eventl.event_id
                JOIN lokasi l ON l.id = el.lokasi_id
                JOIN kota k ON k.id = l.kota_id
                JOIN user u ON u.id = t.user_id
                JOIN sesi s ON s.id = t.sesi
                WHERE u.id='$id' AND t.status = 1";
  
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
    $sql = "SELECT t.id, e.nama nama_event, k.nama kota, e.tgl, s.jam_start, 
            j.nama jenis_burung, e.deskripsi, t.bukti, t.metode_pembayaran, t.no_kursi 
            FROM transaksi t
            JOIN eventlokasi el ON el.id = t.eventlokasi_id
            JOIN event e ON e.id = el.event_id
            JOIN lokasi l ON l.id = el.lokasi_id
            JOIN jenisburung j ON j.id = e.jenisburung_id
            JOIN kota k ON k.id = l.kota_id
            JOIN user u ON u.id = t.user_id
            JOIN sesi s ON s.id = t.sesi
            WHERE t.id = '$id'";

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
    $eventlokasi_id = $request->getParam('eventlokasi_id');
    $sesi = $request->getParam('sesi');
    $no_kursi = $request->getParam('no_kursi');

    $sql = "INSERT INTO transaksi (id, user_id, eventlokasi_id, sesi, no_kursi) 
            VALUES (:id, :user_id, :eventlokasi_id, :sesi, :no_kursi)";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':eventlokasi_id', $eventlokasi_id);
        $stmt->bindParam(':sesi', $sesi);
        $stmt->bindParam(':no_kursi', $no_kursi);
        
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
  $app->delete('/batal/{id}', function (Request $request, Response $response, array $args) {
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

    //pilih metode pembayaran   
    $app->put('/metode/{id}',function (Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $metode_pembayaran = $request->getParam('metode_pembayaran');

        $sql = "UPDATE transaksi SET
            metode_pembayaran = '$metode_pembayaran'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':metode_pembayaran', $metode_pembayaran);

            $result = $stmt->execute();

            $db = null;
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

    //Upload bukti pembayaran  
    $app->put('/bukti/{id}',function (Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $bukti = $request->getParam('bukti');

        $sql = "UPDATE transaksi SET
            bukti = '$bukti'
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bukti', $bukti);

            $result = $stmt->execute();

            $db = null;
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

    //pilih konfirmasi   
    $app->put('/konfirmasi/{id}',function (Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');

        $sql = "UPDATE transaksi SET
            status = 1
            WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();

            $db = null;
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