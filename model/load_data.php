<?php
require_once dirname(__DIR__).'/config/db.php';

$pdo = null;
try{
    $pdo = new PDO("mysql:host=" . DB_HOST . ":" . DB_PORT . ";dbname=" . DB_NAME, USER, PASS,
    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exp){
    echo "Something  went wrong " . $exp->getMessage();
}

// JSON WAY
//$users = file_get_contents("./assets/data/users.json");
//$users = json_decode($users, true);
//
//$products = file_get_contents("./assets/data/books.json");
//$products = json_decode($products, true);

$users_query = "SELECT * FROM users;";
$stmtUsers = $pdo->prepare($users_query);
$stmtUsers->execute();
$users = [];

while ($usersRow = $stmtUsers->fetch(PDO::FETCH_ASSOC)){
    $users[] = $usersRow;
}

$books_query = "SELECT b.id, b.name , b.price, b.quantity, b.img_url,
a.name AS author_id , c.name AS category_id  
FROM books AS b
JOIN authors AS a ON a.id = b.author_id
JOIN categories AS c ON b.category_id = c.id ORDER BY b.name";

$stmt = $pdo->prepare($books_query);
$stmt->execute();
$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $products[] = $row;
}


try {
    $authors_query = "SELECT name FROM authors";
    $stmt = $pdo->prepare($authors_query);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_COLUMN)) {
        $resultAuthors[] = $row;
    }
} catch (PDOException $exp) {
    return "Oops, something went wrong " . $exp->getMessage();
}


try {
    $categories_query = "SELECT name FROM categories";
    $stmt = $pdo->prepare($categories_query);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_COLUMN)) {
        $resultCategories[] = $row;
    }
}
catch (PDOException $exp) {
    return "Oops, something went wrong " . $exp->getMessage();
}

?>
