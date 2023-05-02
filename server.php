<?php
session_start();


$username = "";
$email    = "";
$id    = "";
$name   = "";
$subject   = "";
$errors = array(); 

$pass = "Myf@mily621";
$dbname = "attendance";
 


// $db = mysqli_connect('localhost', 'root', '', 'registration');
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,"DigiCertGlobalRootCA.crt.pem",NULL,NULL);
mysqli_real_connect($conn, "yashvisql.mysql.database.azure.com", "yashvidhar", $pass, $dbname, 3306, MYSQLI_CLIENT_SSL);

// if($conn){
//   echo 'connected';
// }


if (isset($_POST['reg_user'])) {
 
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  // $id = mysqli_real_escape_string($conn, $_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $subject=  mysqli_real_escape_string($conn, $_POST['subject']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

 
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  // if (empty($id)) { array_push($errors, "ID is required"); }
  if (empty($name)) { array_push($errors, "Name is required"); }
  if (empty($subject)) { array_push($errors, "Subject is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  
  $user_check_query = "SELECT * FROM teacher_database WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
     
    // if ($user['id'] === $id) {
    //   array_push($errors, "ID number already exists");
    // }
  }

  
  if (count($errors) == 0) {
  	$password = $password_1;
    
  	$query = "INSERT INTO teacher_database (name, username, email, subject, password) 
  			  VALUES('$name', '$username', '$email', '$subject', '$password')";
  	mysqli_query($conn, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index1.php');
  }
}

if(isset($_POST['att_user'])){
  $date = date('d/m/Y');
  $username=$_SESSION['username'];
  // $db = mysqli_connect('localhost', 'root', '');
  // mysqli_select_db($db,'registration'); 



// $db = mysqli_connect('localhost', 'root', '', 'registration')

  $sql = "SELECT subject FROM teacher_database WHERE (username = '$username')";
  $retval = mysqli_query($conn , $sql );
  $sqlq = "SELECT id FROM teacher_database WHERE (username = '$username')";
  $id_t = mysqli_query($conn , $sqlq );
  if(! $retval )
  {
      die('Could not get data: ' . mysqli_error());
   }
  $c = mysqli_real_escape_string($conn, $_POST['at']);
  if (empty($c)) {
  	array_push($errors, "Choose an option");
  }
  if (count($errors) == 0) {
    $query = "INSERT INTO teacher_att (username, date, attendance) 
            VALUES('$username', '$date', '$c');";
            mysqli_query($conn, $query);
  }
}


if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = $password;
  	$query = "SELECT * FROM teacher_database WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($conn, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index1.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}


?>