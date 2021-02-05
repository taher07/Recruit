<?php
$url = parse_url(getenv("CLEARDB_NAVY_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$connection = mysqli_connect($server, $username, $password, $db);

if(!$connection)
  $error = "Connection issue!";
?>