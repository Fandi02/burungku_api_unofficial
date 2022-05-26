<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/eo', function(\Slim\Routing\RouteCollectorProxy $app){
 
    $app->group('/register', function(\Slim\Routing\RouteCollectorProxy $app){

        $app->post('/google', function (Request $request, Response $response, array $args) {
            $id = create_guid();
            $iduser = create_guid();
            $nama = $request->getParam('nama');
            $email = $request->getParam('email');
            $role = 1;
            $is_verified = 0;

            $cek = "SELECT * FROM user WHERE email='$email' AND role='$role'";

            $db = new db();
            $db = $db->connect();
            $stmt_cek = $db->query($cek);
            $cek_email = $stmt_cek->fetch(PDO::FETCH_OBJ);

            if($cek_email == null){
            try {

                $sql = "INSERT INTO user (id, nama, email,  role, is_verified) 
                    VALUES (:id, :nama, :email, :role, :is_verified)";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':is_verified', $is_verified);

                $user = "INSERT INTO profile (id, user_id) VALUES (:id, :user_id)";

                $stmt_user = $db->prepare($user);
                $stmt_user->bindParam(':id', $iduser);
                $stmt_user->bindParam(':user_id', $id);

                $result = $stmt->execute();
                $result_user = $stmt_user->execute();

                $db = null;

                $response->getBody()->write(json_encode($result, $result_user));
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

            }else{
                $error = array(
                'Message' => 'Email sudah terdaftar'
                );

                $response->getBody()->write(json_encode($error));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(500);
            }
        });

        $app->post('/manual', function (Request $request, Response $response, array $args) {
            $id = create_guid();
            $nama = $request->getParam('nama');
            $email = $request->getParam('email');
            $password = $request->getParam('password');
            $role = 1;
            $otp = otp();
            $is_verified = 0;

            $cek = "SELECT * FROM user WHERE email='$email' AND role='$role'";

            $db = new db();
            $db = $db->connect();
            $stmt = $db->query($cek);
            $cek_email = $stmt->fetch(PDO::FETCH_OBJ);

            if($cek_email == null){
            try {

                $sql = "INSERT INTO user (id, nama, email, otp, role, is_verified) 
                    VALUES (:id, :nama, :email, :otp, :role, :is_verified)";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':otp', $otp);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':is_verified', $is_verified);

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
            }else{
                $error = array(
                    'Message' => 'Email sudah terdaftar'
                );

                $response->getBody()->write(json_encode($error));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(500);
            }
        });
    });

    $app->get('/login', function (Request $request, Response $response, array $args) {
        $email = $request->getParam('email');
        $token = create_guid();

        $sql = "SELECT * FROM user WHERE email = '$email' AND is_verified = 1 AND role = 1";

        $userID = "SELECT id FROM user WHERE email = '$email' AND is_verified = 1 AND role = 1";

        try {
            $db = new db();
            $db = $db->connect();

            $stmt = $db->query($sql);
            $loginid = $stmt->fetch(PDO::FETCH_OBJ);

            $stmt_user = $db->query($userID);
            $user = $stmt_user->fetch(PDO::FETCH_OBJ);

            $creteToken = "INSERT INTO usersecret (token, user_id) VALUES (:token, :user_id)";
            $stmt_token = $db->prepare($creteToken);
            $stmt_token->bindParam(':token', $token);
            $stmt_token->bindParam(':user_id', $user->id);
            $token = $stmt_token->execute();

            $db = null;
            $response->getBody()->write(json_encode($loginid));
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

    //route logout by token
    $app->delete('/logout/{token}', function (Request $request, Response $response, array $args) {
            $token = $args['token'];
    
            $sql = "DELETE FROM usersecret WHERE  `token` = '$token'";
    
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
    
    $app->get('', function (Request $request, Response $response, array $args) {

        $sql = "SELECT * FROM user k 
                JOIN profile p ON k.id = p.user_id 
                WHERE k.role = 1";

        try {
            $db = new db();
            $db = $db->connect();
  
            $stmt = $db->query($sql);
            $getall = $stmt->fetchAll(PDO::FETCH_OBJ);
  
            $db = null;
            $response->getBody()->write(json_encode($getall));
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
