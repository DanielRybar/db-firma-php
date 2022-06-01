<!DOCTYPE html>
<html>
  
<head>
    <title>Vlozeni</title>
</head>
  
<body>
<?php
$conn = new mysqli("localhost", "root", "");
try {
  $sql = "CREATE Database IF NOT EXISTS firma";
  if ($conn->query($sql) === TRUE) {
    echo "";
  } 
}
catch (Exception $exc)
{
  echo "Nepovedlo se vytvořit databázi.";
}
$conn = new mysqli("localhost", "root", "", "firma");
  
$Jmeno = $_REQUEST['Jmeno'];
$Prijmeni = $_REQUEST['Prijmeni'];
$Email = $_REQUEST['Email'];
$Telefon = $_REQUEST['Telefon'];

$JmenoErr = $PrijmeniErr = $EmailErr = $TelefonErr = "";
$Jmeno = $Prijmeni = $Email = $Telefon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["Jmeno"])) {
    $JmenoErr = "Jmeno musi byt zadano.";
    echo $JmenoErr;
  } 
  elseif (!empty($_POST["Jmeno"])) {
    if (!preg_match("/^[A-Ž[a-ž ]+(?:[ ]+[a-žA-Ž][a-ž]+)*$/",$_POST["Jmeno"])) {
      $JmenoErr = "Jmeno: muzes zadat jen pismena.";
      echo $JmenoErr;
    } 
    else {
      $Jmeno = test_input($_POST["Jmeno"]);
      //echo $Jmeno;
    }
  }
  if (empty($_POST["Prijmeni"])) {
    $PrijmeniErr = "Prijmeni musi byt zadano.";
    echo $PrijmeniErr;
  } 
  elseif (!empty($_POST["Prijmeni"])) {
    if (!preg_match("/^[A-Ž[a-ž ]+(?:[ ]+[a-žA-Ž][a-ž]+)*$/",$_POST["Prijmeni"])) {
      $PrijmeniErr = "Prijmeni: muzes zadat jen pismena.";
      echo $PrijmeniErr;
    }
    else {
      $Prijmeni = test_input($_POST["Prijmeni"]);
      //echo $Prijmeni;
    }
  }
  if (empty($_POST["Email"])) {
    $EmailErr = "Email musi byt zadan.";
    echo $EmailErr;
  } 
  elseif (!empty($_POST["Email"])) {
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST["Email"])) {
      $EmailErr = "Spatny format emailu.";
      echo $EmailErr;
    }
    else {
      $Email = test_input($_POST["Email"]);
      //echo $Email;
    }
  }
  if (empty($_POST["Telefon"])) {
    $TelefonErr = "Telefonni cislo musi byt zadano.";
    echo $TelefonErr;
  } 
  elseif (!empty($_POST["Telefon"])) {
    if (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[- \s\.]?[0-9]{3}[-\s\.]?[0-9 ]{3}$/",$_POST["Telefon"])) {
      $TelefonErr = "Spatny format telefonniho cisla.";
      echo $TelefonErr;
    }
    else {
      $Telefon = test_input($_POST["Telefon"]);
      //echo $Telefon;
    }
  }
}

if(!$conn->connect_error and $JmenoErr == "" and $PrijmeniErr == "" and $EmailErr == "" and $TelefonErr == "") 
{
  try {
    $sql = "CREATE TABLE IF NOT EXISTS zakaznici (
      ID INT(11) AUTO_INCREMENT PRIMARY KEY,
      Jmeno VARCHAR(20) NOT NULL,
      Prijmeni VARCHAR(30) NOT NULL,
      Email VARCHAR(50) NOT NULL,
      Telefon TEXT(20) NOT NULL
      )";
    if ($conn->query($sql) === TRUE) {
      //echo "Tabulka vytvořena.";
      $sql = "INSERT INTO `zakaznici` (Jmeno, Prijmeni, Email, Telefon) 
      VALUES ('".$Jmeno."', '".$Prijmeni."', '".$Email."', '".$Telefon."')";
      if ($conn->query($sql) === TRUE) {
        echo " Data přidána.";
      }
      else {
        echo "Vložení nebylo úspěšné.";
      }
    }
  }
  catch (Exception $ex)
  {
    echo "Vložení nebylo úspěšné.";
  } 
}

else {
  //echo "Chyba: " . $sql . "<br><br>" . $conn->error;
  echo " Data nebyla vložena";
}

$conn->close();

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
</body>
</html>