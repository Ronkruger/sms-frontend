<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'richwell_db';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_NAME, $DATABASE_PASS, $DATABASE_USER);

if(mysqli_connect_error()) {
    exit('Error connecting to the database'. mysqli_connect_error());
}
if(!isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['account_type'])) {
    exit('Empty Field(s)');
}
if(empty($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['account_type'])) {
    exit('Values Empty');
}
if(stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?')){
    $stmt->bind_param('s',$_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows>0){
        echo 'email Already exist, Try again.';
    } else {
        if($stmt = $con->prepare('INSERT INTO users (firstname,lastname,email,password,accout_type) VALUES (?,?,?,?,?)')){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param('sss', $_POST['firstname'], $_POST['lastname'], $_POST['email'], $password, $_POST['account_type']);
        $stmt->execute();
        echo 'Successfully Registered';
        } else {
            echo 'Error Occured';
        }
    }
    $stmt->close();
} else {
    echo 'Error occured';
}
$con->close();
?>