<?php
$servername = "db";
$username = "root";
$password = "example";
$dbname = "mydb";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "admin" && $password === "admin") {
        session_start();
        $_SESSION["username"] = $username;
        header("Location: admin.html"); 
        exit();
    } elseif ($username === "student" && $password === "student") {
        session_start();
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
}
?>
