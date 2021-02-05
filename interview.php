<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['isLoggedIn']))
  header('location: /');
include 'connection.php';

if(isset($_POST['url'])) {
  echo $_POST['url'];
}

$placeholders = [];
for($i=0;$i<5;$i++) {
  array_push($placeholders,$_SESSION["question[$i]"]);
}

mysqli_query($connection,"insert into interview(candidate_id,question_1,question_2,question_3,question_4,question_5) values(" .$_SESSION['candidateId']. ",$placeholders[0],$placeholders[1],$placeholders[2],$placeholders[3],$placeholders[4])");

$questions = [];
foreach($placeholders as $k => $v) {
  array_push($questions,mysqli_fetch_array(mysqli_query($connection,"select content from questions where question_id = ". $v))[0]);
}
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="./assets/styles/bootstrap/css/bootstrap.min.css"
  />
  <link rel="stylesheet" href="./assets/styles/style.css" />
  <script src="./assets/styles/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://sdk.amazonaws.com/js/aws-sdk-2.727.1.min.js"></script>
  <title>HR Interview</title>
</head>
<body onload="recordVideo()">
  <div class="container-fluid overflow-hidden">
    <header>
      <h1>HR Interview</h1>
    </header>
    <section>
      <div class="alert alert-warning">If you face any technical issue then feel free to immediately write to us <a href="mailto:taherlunawadi@gmail.com">here</a></div>
      <div class="row">
        <div class="card col-sm-12 col-md-3 mx-md-4 my-3 p-0">
          <div class="card-header">
            <h3>Your video</h3>
          </div>
          <div class="card-body">
            <span class="text-danger text-right">REC</span>
            <video></video>
          </div>
        </div>
        <div class="card col-sm-12 col-md-8 mx-md-4 my-3 p-0">
          <div class="card-header">
            <h3>Question 1</h3>
          </div>
          <div class="card-body">
            <h4>
              <?php
                echo $questions[0];
              ?>
            </h4>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="card col-sm-12 col-md-6 mx-md-4 my-3 p-0">
          <div class="card-header">
            <h3>Question 2</h3>
          </div>
          <div class="card-body">
            <h4>
              <?php
                echo $questions[1];
              ?>
            </h4>
          </div>
        </div>
        <div class="card col-sm-12 col-md-6 mx-md-4 my-3 p-0">
          <div class="card-header">
            <h3>Question 3</h3>
          </div>
          <div class="card-body">
            <h4>
              <?php
                echo $questions[2];
              ?>
            </h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="card col-sm-12 col-md-5 mx-md-4 my-3 p-0">
            <div class="card-header">
              <h3>Question 4</h3>
            </div>
            <div class="card-body">
              <h4>
                <?php
                  echo $questions[3];
                ?>
              </h4>
            </div>
        </div>
        <div class="card col-sm-12 col-md-5 mx-md-4 my-3 p-0">
          <div class="card-header">
            <h3>Question 5</h3>
          </div>
          <div class="card-body">
            <h4>
              <?php
                echo $questions[4];
              ?>
            </h4>
          </div>
        </div>
      </div>
      <div class="row">
          <button name="submit" id="done" class="btn btn-primary col-sm-12 col-md-4 offset-md-4">Submit</button>
        </div>
      <form method="post" style="background: none; box-shadow: none;">
        <input type="hidden" name="key" id="key" value="<?php echo $_SESSION['candidateId'] ?>" />
      </form>
    </section>
    <footer>
      <h4 class="text-center">All Rights Reserved</h4>
    </footer>
  </div>

  <!-- Modal for cautioning -->
  <div
    class="modal fade"
    id="warn"
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Caution!</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            onclick="recordVideo()"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          This interview isn't possible if you keep your webcam and your microphone off
          <br>
          Please turn them on to ensure a smooth and successful interview
          <br>
          If problem persists, please write us <a href="mailto:t@taher.com">here</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success col" data-dismiss="modal" onclick="recordVideo()">I Understand</button>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js" defer></script>
</body>