<?php

$users = file_get_contents("./assets/data/users.json");
$users = json_decode($users, true);

$products = file_get_contents("./assets/data/books.json");
$products = json_decode($products, true);

?>