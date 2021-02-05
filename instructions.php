<?php
session_start();
if(!isset($_SESSION['isLoggedIn']))
  header('location: /');
include('connection.php');

$limit = mysqli_fetch_array(mysqli_query($connection,"select max(question_id) from questions"))[0];

function randomGen($min, $max, $quantity) {
  $numbers = range($min, $max);
  shuffle($numbers);
  return array_slice($numbers, 0, $quantity);
}

$num = randomGen(1000,$limit,5);
foreach($num as $k => $v) {
  $_SESSION["question[$k]"] = $v;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HR Interview | Instructions</title>
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
      <main style="margin-top: 40px;">
        <div class="col-sm-12">
          <ul class="list-group list-group-flush list-group-horizontal-md row">
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">Ensure you're seated in a place with ambient lighting, bad lighting configuration may make the scrutinization process cumbersome and may have you bear the brunt as a result</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">It is recommended to check the microphone and webcam of your device thoroughly before attempting the interview, Remember, <b style="text-decoration: underline;">only ONE chance</b> would be given to you to attempt the interview</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">You're not allowed to read out the answers and any malpractice would lead to disqualification, Remember, <b style="text-decoration: underline;">It's your interview and you alone should be attempting it!</b></li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">Any cheating/malpractice traced in your interview would have you disqualified immediately</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">We reserve the right to accept/reject/disqualify anyone and we are <b style="text-decoration: underline;">NOT</b> subjected to justification, However, we'll to the best of our ebility ensure that we prompt you with the reason for disapproval/disqualification</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">This is a strictly professional environment and we expect you to strongly use a professionally acceptable language, usage of linguistics and/or inappropriate language may affect your scrutinization process</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">As this is a remote interview we do not expect you to be dressed professionally, however, you are <b style="text-decoration: underline;">required</b> to be presentable while you attempt the interview</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">You will be informed your approval status by mail hence do not panic</li>
            <li class="list-group-item list-group-item-action list-group-item-dark text-center font-weight-bold">You do not have to be stressed about the interview as it isn't a very rigorous process and we'd be glad to extend assisstance in any matter, if you feel that you've read all the above instructions and despite following those you're facing issues then feel free to write to us <a href="mailto:taherlunawadi@gmail.com">here</a></li>
          </ul>
          <a href="interview.php" class="btn btn-dark row w-100 my-5 mx-auto">Start the interview</a>
        </div>
      </main>
      <footer>
        <h4 class="text-center">All Rights Reserved</h4>
      </footer>
    </div>
  </body>
</html>