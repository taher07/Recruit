<?php
session_start();
if(!isset($_SESSION['isAuthorized']))
  header('location: /');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "../../../vendor/autoload.php";

include '../../../connection.php';
$values = [];

$result = mysqli_query($connection,"select a.* from interview a, candidates b where token is not null and a.candidate_id = b.candidate_id and b.interview_done = 1 and b.accepted is null");
while($res = mysqli_fetch_array($result)) {
  array_push($values,[$res[0],$res[1],$res[2],$res[3],$res[4],$res[5],$res[6],$res[7],$res[8]]);
}

function displayQuestion($param) {
  include '../../../connection.php';
  return mysqli_fetch_array(mysqli_query($connection,"select content from questions where question_id = $param"))['content'];
}

if(isset($_GET['acceptId'])) {
  $id = $_GET['acceptId'];
  $res = mysqli_query($connection,"update candidates set accepted = 'YES', interview_done = 1 where candidate_id = $id");
  $to = mysqli_fetch_array(mysqli_query($connection,"select email from candidates where candidate_id = ". $id))[0];
  $subject = 'Interview Result';
  $body = '
  <html>
  <head>
    <title>Interview result</title>
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
            Thank you for appearing for the interview
          </h2>
          <hr class="w-70 my-3">
          <h2 class="text-center text-dark">
            We\'re glad to inform that you\'ve been selected for the role, our HRM would call you in a day or two and give you information about the role and our company\'s policies and TOS
          </h2>
          <h3 class="text-center text-dark">
            We welcome you onboard and wish you luck for your new role
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
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = "taherlunawadi@gmail.com";
  $mail->Password = "zzyq jqtr humr bmet";
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;

  $mail->From = "taherlunawadi@gmail.com";
  $mail->FromName = "Taher Lunavadi";

  $mail->addAddress($to);

  $mail->isHTML(true);

  $mail->Subject = $subject;
  $mail->Body = $body;

  try {
      $mail->send();
      header('location: index.php');
  } catch (Exception $e) {
      $message = "Mailer Error: " . $mail->ErrorInfo;
  }
}

if(isset($_GET['rejectId'])) {
  $id = $_GET['rejectId'];
  $res = mysqli_query($connection,"update candidates set accepted = 'NO', interview_done = 1 where candidate_id = $id");
  $to = mysqli_fetch_array(mysqli_query($connection,"select email from candidates where candidate_id = ". $id))[0];
  $subject = 'Interview Result';
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
            Thank you for appearing for the interview
          </h2>
          <hr class="w-70 my-3">
          <h2 class="text-center text-dark">
            Unfortunately you weren\'t selected for the role!
          </h2>
        </div>
      </main>
      <footer>
        <h4 class="text-center">Taher Lunavadi</h4>
      </footer>
    </div>
  </body>
  </html>
  ';
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = "taherlunawadi@gmail.com";
  $mail->Password = "zzyq jqtr humr bmet";
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;

  $mail->From = "taherlunawadi@gmail.com";
  $mail->FromName = "Taher Lunavadi";

  $mail->addAddress($to);

  $mail->isHTML(true);

  $mail->Subject = $subject;
  $mail->Body = $body;
  
  try {
      $mail->send();
      header('location: index.php');
  } catch (Exception $e) {
      $message = "Mailer Error: " . $mail->ErrorInfo;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../assets/styles/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../../../assets/styles/style.css">
  <script src="https://sdk.amazonaws.com/js/aws-sdk-2.727.1.min.js"></script>
  <script src="../../../script.js"></script>
  <title>HR Interview</title>
  <style>
    @media screen and (max-width: 700px) {
      form {
        background-color: transparent;
        box-shadow: none;
      }
      tbody, .btn {
        font-size: 10px;
      }
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
      <a href="../index.php" class="col-sm-12 btn btn-info mb-5">Go to Dashboard</a>
        <form method="post">
          <?php
          if(isset($error))
            echo "<div class='alert alert-danger col-sm-12'>$error</div>";
          ?>
          <table class="table table-dark table-striped table-responsive col-sm-12">
            <tr>
              <th>Scrutinity ID</th>
              <th>Date</th>
              <th>Question 1</th>
              <th>Question 2</th>
              <th>Question 3</th>
              <th>Question 4</th>
              <th>Question 5</th>
              <th>Video</th>
              <th>Accept</th>
              <th>Reject</th>
            </tr>
            <?php
            foreach($values as $value) {
                echo "<tr>";
                echo "<td class='align-middle'>". $value[7] ."</td>";
                echo "<td class='align-middle'>". $value[8] ."</td>";
                echo "<td class='align-middle'>". displayQuestion($value[2]) ."</td>";
                echo "<td class='align-middle'>". displayQuestion($value[3]) ."</td>";
                echo "<td class='align-middle'>". displayQuestion($value[4]) ."</td>";
                echo "<td class='align-middle'>". displayQuestion($value[5]) ."</td>";
                echo "<td class='align-middle'>". displayQuestion($value[6]) ."</td>";
                echo "<td class='align-middle'><video controls src='' onclick='getItem($value[1])' id='$value[1]'></video></td>";
                echo "<td class='align-middle'><button class='btn btn-success col-sm-12'><a href='index.php?acceptId=$value[1]' style='text-decoration: none; color: #fff;'>Accept</a></button></td>";
                echo "<td class='align-middle'><button class='btn btn-danger col-sm-12'><a href='index.php?rejectId=$value[1]' style='text-decoration: none; color: #fff;'>Reject</a></button></td>";
                echo "</tr>";
              }
            ?>
          </table>
        </form>
      </div>
    </main>
    <footer>
      <h4 class="text-center">All Rights Reserved</h4>
    </footer>
  </div>
</body>
</html>