<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//grup route
$app->group('/admin', function(\Slim\Routing\RouteCollectorProxy $app){
    
    //route delete by id
    $app->delete('/delete', function (Request $request, Response $response, array $args) {
        $email = $request->getParam('email');

        $sql = "DELETE FROM user 
                WHERE  `email` = '$email' AND role = 1";

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

    //route konfirmasi    
    $app->put('/confirm',function (Request $request, Response $response, array $args) {
        $email = $request->getParam('email');

        $sql = "UPDATE user SET
            is_verified = 1
            WHERE  `email` = '$email' AND role = 1";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
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

    //login admin
    $app->get('/login', function (Request $request, Response $response, array $args) {
        $email = $request->getParam('email');
        $token = create_guid();

        $sql = "SELECT * FROM user WHERE email = '$email' AND is_verified = 1 AND role = 0";

        $userID = "SELECT id FROM user WHERE email = '$email' AND is_verified = 1 AND role = 0";

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
});