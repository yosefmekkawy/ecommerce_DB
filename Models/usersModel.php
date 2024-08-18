<?php

include_once '../helpers/DBConnect.php';


function get_users($order = 'asc')
{
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM users ORDER BY id ". strtoupper($order));
    return $data->fetchAll();
}