<?php
session_start();
if(isset($_POST['submit'])) {
  include('../connection.php');
  $candidateId = $_POST['candidateId'];
  $accessKey = $_POST['accessKey'];
  
  $result = mysqli_query($connection,"select first_name from administrators where id = $candidateId and access_key = '$accessKey'");
  
  $res = mysqli_fetch_array($result)[0];
  
  if(isset($res)) {
    $_SESSION['admin'] = $candidateId;
    $_SESSION['isAuthorized'] = true;
    header('location: dashboard');
  }
  else {
    header('location: /');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/styles/style.css">
  <title>HR Interview</title>
</head>
<body>
  <div class="container-fluid">
    <header>
      <h1>HR Interview</h1>
    </header>
    <main>
      <form class="col-md-4" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php
        if(isset($error) != '') {
         echo "<div class='alert-danger rounded p-2'>
                {$error}
              </div>";
        }
        ?>
        <div class="form-row">
          <label class="col text-center">Candidate ID</label>
          <input type="text" class="col form-control" name="candidateId" required>
        </div>
        <div class="form-row">
          <label class="col text-center">Secret key</label>
          <input type="password" class="col form-control" name="accessKey" required>
        </div>
        <div class="form-row">
          <button class="btn btn-dark col-12" name="submit">
            Next
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-8.354 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L9.793 7.5H5a.5.5 0 0 0 0 1h4.793l-2.147 2.146z"/>
            </svg>
          </button>
        </div>
      </form>
    </main>
    <footer>
      <h4 class="text-center">All Rights Reserved</h4>
    </footer>
  </div> 
</body>
</html>