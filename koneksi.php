<?php
class dbObj
{
  var $host = "localhost";
  var $username = "root";
  var $pass = "";
  var $dbname = "pw12";
  var $conn;

  function getConString()
  {
    $con = mysqli_connect(
      $this->host,
      $this->username,
      $this->pass,
      $this->dbname
    ) or die("Koneksi gagal: " . mysqli_connect_error());

    if (mysqli_connect_errno()) {
      printf("Koneksi gagal: %s\n", mysqli_connect_error());
      exit();
    } else {
      $this->conn = $con;
    }
    return $this->conn;
  }
}
