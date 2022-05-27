<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/profil', function(\Slim\Routing\RouteCollectorProxy $app){
  //route get
    $app->get('', function (Request $request, Response $response, $args) {
      $sql = 'SELECT * FROM profile 
            join user on profile.user_id = user.id';

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

    //route by eo
    $app->get('/eo', function (Request $request, Response $response, $args) {
        $sql = "SELECT * FROM `profile` 
                join user ON profile.user_id = user.id
                WHERE user.role = 1";
    
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

    //route by eo
    $app->get('/user', function (Request $request, Response $response, $args) {
            $sql = "SELECT * FROM `profile` 
                    join user ON profile.user_id = user.id
                    WHERE user.role = 2";
        
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

    //route get by id
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $id = $args['id'];
            $sql = "SELECT * FROM `profile` p 
                    JOIN user u ON u.id = p.user_id
                    WHERE u.id = '$id'";
    
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

    //route delete by id
    $app->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM profile WHERE  `id` = '$id'";

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
        $jkel = $request->getParam('jkel');
        $no_hp = $request->getParam('no_hp');
        $alamat = $request->getParam('alamat');

        $sql = "UPDATE profile SET
            jkel = '$jkel',
            no_hp = '$no_hp',
            alamat = '$alamat'
        WHERE id = '$id'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':jkel', $jkel);
            $stmt->bindParam(':no_hp', $no_hp);
            $stmt->bindParam(':alamat', $alamat);

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