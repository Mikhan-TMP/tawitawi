<?php
$data = $_POST;

if(empty($data['username']) || empty($data['password']))
{
    die('Username or Password are required!');
}

$username = $data['username'];
$password = $data['password'];

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

$statement = $connection->prepare('SELECT * FROM users WHERE username = :username');
$statement->execute([':username' => $username]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(empty($result))
{
    die('No such user with the username!');
}
$user = array_shift($result);

if($user['username'] === $username && $user['password'] === $password)
{
    // $statement = $connection->prepare('SELECT userID FROM usersloggedin WHERE userID = :userID');
    // $statement->execute([':userID' => $user['ID']]);
    // $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // if(empty($result))
    // {
    //     $statement = $connection->prepare('INSERT INTO usersloggedin(userID) VALUES (:userID)');
    //     $statement->execute([':userID' => $user['ID']]);
        

    //     die('You have been successfully logged in!');
    // }
    // else
    // {
    //     $statement = $connection->prepare('DELETE FROM usersloggedin WHERE userID = :userID');
    //     $statement->execute([':userID' => $user['ID']]);
    //     die('User already logged in!');
    // }
    die('You have been successfully logged in!');
}
else
{
    die('Incorrect username or password!');
}

?>