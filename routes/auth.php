<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/auth', function(\Slim\Routing\RouteCollectorProxy $app){
    $app->group('/admin', function(\Slim\Routing\RouteCollectorProxy $app){
        
    });
    $app->group('/eo', function(\Slim\Routing\RouteCollectorProxy $app){
        //register
        $app->post('/register', function (Request $request, Response $response, array $args) {
            $id = create_guid();
            $nama = $request->getParam('nama');
            $username = $request->getParam('username');
            $email = $request->getParam('email');
            $password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
            $no_hp = $request->getParam('no_hp');
            $role = 2;

            $sql = "INSERT INTO user (id, nama, username, email, password, no_hp, role) 
                VALUES (:id, :nama, :username, :email, :password, :no_hp, :role)";

            try {
                $db = new db();
                $db = $db->connect();

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':no_hp', $no_hp);
                $stmt->bindParam(':role', $role);

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
        
        //login
        $app->post('/login', function (Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();
            $email = $request->getParam('email');
            $password = $request->getParam('password');

            $data = $this->db->prepare("SELECT * FROM user WHERE email = '$email'");

            if(count($data) > 0){
                $response->getBody()->write(json_encode($data));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(200);
            }else{
                $error = array(
                    'Message' => 'Email atau Password salah'
                );

                $response->getBody()->write(json_encode($error));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(500);
            }
        });
    });

    $app->group('/user', function(\Slim\Routing\RouteCollectorProxy $app){
        //register
        $app->post('/register', function (Request $request, Response $response, array $args) {
            $id = create_guid();
            $nama = $request->getParam('nama');
            $username = $request->getParam('username');
            $email = $request->getParam('email');
            $password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
            $no_hp = $request->getParam('no_hp');
            $role = 3;

            $sql = "INSERT INTO user (id, nama, username, email, password, no_hp, role) 
                VALUES (:id, :nama, :username, :email, :password, :no_hp, :role)";

            try {
                $db = new db();
                $db = $db->connect();

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':no_hp', $no_hp);
                $stmt->bindParam(':role', $role);

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
});