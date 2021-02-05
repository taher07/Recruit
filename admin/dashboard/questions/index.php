<?php
session_start();
if(!isset($_SESSION['isAuthorized']))
  header('location: /');
include '../../../connection.php';
$values = [];

if(isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $result = mysqli_query($connection,"delete from questions where question_id = $delid");
  if(!$result) {
    $error = "Question $delid could not be deleted!";
    exit();
  }
  header('location: index.php');
}

$result = mysqli_query($connection,"select * from questions");
while($res = mysqli_fetch_array($result)) {
  array_push($values,[$res[0],$res[1]]);
}

if(isset($_POST['btnSubmit'])) {
  $id = $_POST['txtId'];
  $question = $_POST['txtQuestion'];
  if(isset($_POST['txtId']))
    $finalRes = mysqli_query($connection,"insert into questions(question_id,content) values($id,'$question')");
  else
    $finalRes = mysqli_query($connection,"insert into questions(content) values('$question')");
  if(!$finalRes)
    $error = "There is an error here!";
  header('location: index.php');
}

if(isset($_POST['btnUpdate'])) {
  $edid = $_GET['edid'];
  $question = $_POST['txtQuestionUpdate'];
  $finalRes = mysqli_query($connection,"update questions set content = '$question' where question_id = $edid");
  if(!$finalRes) {
    $error = "There is an error here!";
    exit();
  }
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../assets/styles/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../../../assets/styles/style.css">
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
              <th>ID</th>
              <th>Question</th>
              <th></th>
              <th></th>
            </tr>
            <?php
            foreach($values as $value) {
              if(isset($_GET['edid']) and $_GET['edid'] == $value[0]) {
                echo "<tr>";
                echo "<td>$value[0]</td>";
                echo "<td><input type='text' class='form-control' value='$value[1]' name='txtQuestionUpdate'></td>";
                echo "
                <td colspan='2'>
                <button type='submit' class='btn btn-success col-sm-12' name='btnUpdate'>
                  Save
                </button>
              </td>";
                echo "</tr>";
              }
              else {
                echo "<tr>";
                echo "<td>$value[0]</td>";
                echo "<td>$value[1]</td>";
                echo "<td><button class='btn btn-danger col-sm-12'><a href='index.php?delid=$value[0]' style='text-decoration: none; color: #fff;'>Remove</button></td>";
                echo "<td><button class='btn btn-info col-sm-12'><a href='index.php?edid=$value[0]' style='text-decoration: none; color: #fff;'>Edit</button></td>";
                echo "</tr>";
              }
            }
            ?>
            <tr>
              <td class="form-row"><input type="text" class="form-control" name="txtId" placeholder="Optional"></td>
              <td class="form-row"><input type="text" class="form-control" name="txtQuestion" placeholder="Required"></td>
              <td colspan="2">
                <button type="submit" class="btn btn-warning col-sm-12" name="btnSubmit">
                  Submit
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-8.354 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L9.793 7.5H5a.5.5 0 0 0 0 1h4.793l-2.147 2.146z"/>
                  </svg>
                </button>
              </td>
            </tr>
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