<?php
$data = $_POST;

if(empty($data['rfid']))
{
    die('RFID required!');
}

$rfid = $data['rfid'];
// $password = $data['password'];


// db Start ----------
$dsn = 'mysql:dbname=empattendanceci; host=localhost';
$dbUser = 'root';
$dbPassword = '';
try
{
    $connection = new PDO($dsn, $dbUser, $dbPassword);
}
catch(PDOException $exception)
{
    die('Connection failed: ' . $exception->getMessage());
}
// db Done ----------




// SQL --------------
$statement = $connection->prepare('SELECT * FROM student WHERE rfid = :rfid');
$statement->execute([':rfid' => $rfid]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(empty($result))
{
    die('RFID Invalid!');
}
$userRFID = array_shift($result);

die(
    $userRFID['first_name'].','.
    $userRFID['last_name'].','.
    $userRFID['srcode'].','.
    $userRFID['program'].','.
    $userRFID['rfid'].','.
    $userRFID['qrcode'].','.
    $userRFID['gender'].','.
    $userRFID['course'].','.
    $userRFID['schoolyear']
);



?>