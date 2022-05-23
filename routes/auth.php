<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//grup route
$app->group('/auth', function(\Slim\Routing\RouteCollectorProxy $app){

    //verifikasi 
    $app->put('/verify/{otp}',function (Request $request, Response $response, array $args) {
        $otp = $request->getAttribute('otp');
        $data = $request->getParsedBody();
        $email = $request->getParam('email');
        $is_verified = 1;

        $sql = "UPDATE user SET
            is_verified = '$is_verified'
            WHERE otp = '$otp' AND email='$email'";

        try {
            $db = new Db();
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':otp', $otp);
            $stmt->bindParam(':is_verified', $is_verified);
            $stmt->bindParam(':email', $email);

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

    $app->group('/admin', function(\Slim\Routing\RouteCollectorProxy $app){

    });

    $app->group('/eo', function(\Slim\Routing\RouteCollectorProxy $app){

    //register
    $app->post('/register', function (Request $request, Response $response, array $args) {
        $id = create_guid();
        $nama = $request->getParam('nama');
        $email = $request->getParam('email');
        $role = 2;
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
            // email
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'projectburung01@gmail.com';                     //SMTP username
            $mail->Password   = 'Adminburung01';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('projectburung01@gmail.com', 'kode OTP');
            $mail->addAddress($email, $nama);     //Add a recipient
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Kode OTP';
            $mail->Body    = 'Kode OTP <b>'.$otp.'</b>';
            $mail->AltBody = 'Kode otp';
            $mail->send();

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

    $app->get('/login', function (Request $request, Response $response, array $args) {
            $email = $request->getParam('email');

            $sql = "SELECT * FROM user WHERE email = '$email' AND is_verified = 1 AND role = 2";

            try {
                $db = new db();
                $db = $db->connect();

                $stmt = $db->query($sql);
                $loginid = $stmt->fetch(PDO::FETCH_OBJ);

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
    });


    $app->group('/user', function(\Slim\Routing\RouteCollectorProxy $app){
    //register
    $app->group('/register', function(\Slim\Routing\RouteCollectorProxy $app){

        $app->post('/google', function (Request $request, Response $response, array $args) {
            $id = create_guid();
            $token = create_guid();
            $nama = $request->getParam('nama');
            $email = $request->getParam('email');
            $role = 3;
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

                $creteToken = "INSERT INTO token (token, user_id) VALUES (:token :user_id)";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':otp', $otp);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':is_verified', $is_verified);

                $result = $stmt->execute();

                $creteToken = "INSERT INTO usersecret (token, user_id) VALUES ('$token', '$id')";

                //$stmt = $db->prepare($sql);
                //$stmt->bindParam(':token', $token);
                //$stmt->bindParam(':user_id', $id);

                $tokenresult = $stmt->execute();

                $db = null;

                // email
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'projectburung01@gmail.com';                     //SMTP username
                $mail->Password   = 'Adminburung01';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('projectburung01@gmail.com', 'kode OTP');
                $mail->addAddress($email, $nama);     //Add a recipient
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Kode OTP';
                $mail->Body    = 'Kode OTP <b>'.$otp.'</b>';
                $mail->AltBody = 'Kode otp';
                $mail->send();

                $response->getBody()->write(json_encode($result, $tokenresult));
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
            $role = 3;
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
                // email
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'projectburung01@gmail.com';                     //SMTP username
                $mail->Password   = 'Adminburung01';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('projectburung01@gmail.com', 'kode OTP');
                $mail->addAddress($email, $nama);     //Add a recipient
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Kode OTP';
                $mail->Body    = 'Kode OTP <b>'.$otp.'</b>';
                $mail->AltBody = 'Kode otp';
                $mail->send();

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

        $sql = "SELECT * FROM user WHERE email = '$email' AND is_verified = 1 AND role = 3";

        $userID = "SELECT id FROM user WHERE email = '$email' AND is_verified = 1 AND role = 3";

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
    });
});

  