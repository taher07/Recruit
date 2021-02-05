<?php
session_start();
if(!isset($_SESSION['isLoggedIn']))
  header('location: /');
include 'connection.php';
$today = date("Y-m-d");
$token = bin2hex(random_bytes(10));
$res = mysqli_query($connection,"update interview set token = '" .$token ."' where candidate_id = " .$_SESSION['candidateId']);

$res = mysqli_query($connection,"update candidates set interview_done = 1 where candidate_id = " .$_SESSION['candidateId']);

$res = mysqli_query($connection,"update interview set date = '{$today}' where candidate_id = " .$_SESSION['candidateId']);

$to = mysqli_fetch_array(mysqli_query($connection,"select email from candidates where candidate_id = ". $_SESSION['candidateId']))[0];
$subject = 'Your interview has been recorded!';
$body = '
<html>
<head>
  <title>Interview acknowledgement</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap");
    * {
      padding: 0;
      margin: 0;
    }
    body {
      height: 100vh;
      width: 100%;
      background: #11998e;
      background: -webkit-linear-gradient(to right, #38ef7d, #11998e);
      background: linear-gradient(to right, #38ef7d, #11998e);
      color: #000;
    }
    h1 {
      font-family: "Cinzel", serif;
      font-size: 25px;
    }
    main {
      height: 80vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    hr {
      background-color: #000000;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <header>
      <h1>HR Interview</h1>
    </header>
    <main>
      <div class="col-sm-12">
        <h2 class="text-center text-dark">
          Thank you for appearing for the interview, your interview has been recorded and is under scrutiny
        </h2>
        <hr class="w-70 my-3">
        <h2 class="text-center text-dark">
          Your scrutinity number is <span style="color:#dc143c;">' .$token. '</span>
        </h2>
        <h3 class="text-center text-dark">
          Save your scrutiny number for future reference
        </h3>
      </div>
    </main>
    <footer>
      <h4 class="text-center">Taher Lunavadi</h4>
    </footer>
  </div>
</body>
</html>
';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = "taherlunawadi@gmail.com";
$mail->Password = $_ENV['password'];
$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->From = "taherlunawadi@gmail.com";
$mail->FromName = "Taher Lunavadi";

$mail->addAddress($to);

$mail->isHTML(true);

$mail->Subject = $subject;
$mail->Body = $body;
$mail->AltBody = "Thank you for appearing for the interview, your interview has been recorded and is under scrutiny;  Your scrutinity number is " .$token. ", save it for future reference";

try {
    $mail->send();
    $message = "We've sent you a mail, please check your mailbox";
} catch (Exception $e) {
    $message = "Mailer Error: " . $mail->ErrorInfo;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Interview | Thank You</title>
  <link
      rel="stylesheet"
      href="./assets/styles/bootstrap/css/bootstrap.min.css"
    />
  <link rel="stylesheet" href="./assets/styles/style.css" />
</head>
<body>
  <div class="container-fluid">
    <header>
      <h1>HR Interview</h1>
    </header>
    <main class="d-flex align-items-center">
      <div class="col-sm-2 col-md-4">
        <h3 class="text-center">Thank you for interviewing with us!</h3>
        <hr class="row w-100">
        <h3 class="text-center"><?php echo $message; ?></h3>
      </div>
    </main>
    <footer>
      <h4 class="text-center">All Rights Reserved</h4>
    </footer>
  </div>
</body>
</html>