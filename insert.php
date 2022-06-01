<!DOCTYPE html>
<html>
  
<head>
    <title>Vlozeni</title>
</head>
  
<body>
<?php
  $conn = new mysqli("localhost", "root", "", "firma");

  if($conn->connect_error) {
      die("ERROR: Pripojeni selhalo. " . $conn->connect_error);
  }
    
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
    if (!preg_match("/^[A-Z][a-z ]+(?:[ ]+[a-zA-Z][a-z]+)*$/",$_POST["Jmeno"])) {
      $JmenoErr = "Muzes zadat jen pismena.";
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
    if (!preg_match("/^[A-Z][a-z ]+(?:[ ]+[a-zA-Z][a-z]+)*$/",$_POST["Prijmeni"])) {
      $PrijmeniErr = "Muzes zadat jen pismena.";
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
  $sql = "INSERT INTO `zakaznici` (Jmeno, Prijmeni, Email, Telefon) 
  VALUES ('".$Jmeno."', '".$Prijmeni."', '".$Email."', '".$Telefon."')";
  
  if ($conn->query($sql) === TRUE) {
    echo "Data vložena do tabulky";
  } 
  else {
    echo "Chyba: " . $sql . "<br><br>" . $conn->error;
    //echo "Data nebyla vložena";
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