<?php
session_start();
if(!isset($_SESSION['isAuthorized']))
  header('location: /');
include '../../connection.php';
$today = date("Y-m-d");

$total = mysqli_fetch_array(mysqli_query($connection,"select count(*) from candidates where interview_done = 1"))[0];
$total = $total > 0 ? $total : 1;
$accepted = floor((mysqli_fetch_array(mysqli_query($connection,"select count(*) from candidates where accepted = 'YES' and interview_done = 1"))[0] / $total) * 100);
$rejected = floor((mysqli_fetch_array(mysqli_query($connection,"select count(*) from candidates where accepted = 'NO' and interview_done = 1"))[0] / $total) * 100);
$remaining = mysqli_fetch_array(mysqli_query($connection,"select count(*) from candidates where interview_done = 0"))[0];
$scrutinize = mysqli_fetch_array(mysqli_query($connection,"select count(*) from candidates where interview_done = 1 and accepted is NULL"))[0];

$questions = mysqli_fetch_array(mysqli_query($connection,"select count(*) from questions"))[0];

$count = mysqli_fetch_array(mysqli_query($connection,"select count(*) from interview where date = '{$today}'"))[0];
$count = $count > 0 ? $count : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/styles/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/styles/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <title>HR Interview</title>
</head>
<body>
  <div class="container-fluid">
    <header>
      <h1>HR Interview</h1>
    </header>
    <main>
      <div class="col-12">
        <div class="box col-12 d-block">
          <div class="col-sm-12 col-md-4 d-block float-left row">
            <canvas id="stats"></canvas>
          </div>
          <div class="col-sm-12 col-md-6 offset-md-6 row">
            <button class="btn btn-dark my-3" onclick="window.location = 'questions'">Manage questions</button>
            <button class="btn btn-dark my-3" onclick="window.location = 'candidates'">Manage candidates</button>
            <button class="btn btn-dark my-3" onclick="window.location = 'interview'">Manage interviews</button>
          </div>
        </div>
        <div class="col-12 alert alert-info d-block mt-5">
          There're a total of <span style="color: red; text-decoration: none;"><?php echo $questions; ?></span> question(s) in the database
        </div>
        <div class="col-12 alert alert-info d-block my-3">
          <span style="color: red; text-decoration: none;"><?php echo $remaining; ?></span> candidate(s) is/are remaining to attempt the interview
        </div>
        <div class="col-12 alert alert-info d-block my-3">
          <span style="color: red; text-decoration: none;"><?php echo $count; ?></span> candidate(s) has/have attempted the interview today
        </div>
        <div class="col-12 alert alert-info d-block my-3">
          You've to scrutinize <span style="color: red; text-decoration: none;"><?php echo $scrutinize; ?></span> interview(s) yet
        </div>
      </div>
    </main>
    <form method="post" style="display: none;">
      <input type="hidden" id="accepted" value="<?php echo $accepted; ?>">
      <input type="hidden" id="rejected" value="<?php echo $rejected; ?>">
    </form>
    <footer>
      <h4 class="text-center">All Rights Reserved</h4>
    </footer>
  </div>
  <script src="script.js"></script>
</body>
</html>