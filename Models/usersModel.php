<?php

include_once __DIR__ . '/../helpers/DBConnect.php';



function get_users($name, $order = 'asc',$type='')
{
    $conn = connectToDB();
    // Correcting the query string
    $sql = "SELECT * FROM users WHERE username LIKE :name AND type LIKE :type  ORDER BY id " . strtoupper($order);
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => "%$name%",
        ':type' => "%$type%"
    ]);
    return $stmt->fetchAll();
}

function get_specific_user($email, $password){
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM users WHERE email = '$email' AND pass = '$password'");
    return $data->fetch();
}

function register($username, $email, $password, $phone) {
    $conn = connectToDB();

    $sql = 'INSERT INTO users(username, email, pass, phone, type) 
            VALUES (:username, :email, :pass, :phone, "client")';


    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $password);
    $stmt->bindParam(':phone', $phone);


    $stmt->execute();
}
function check_exist_email($email) {
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM users WHERE email = '$email'");
    return $data->fetch();
}
