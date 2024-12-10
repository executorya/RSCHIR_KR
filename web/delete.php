<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление информации о студенте</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            text-align: center;
            position: relative;
        }

        h1 {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            margin: 0;
            border-bottom: 4px solid #007BFF;
        }

        form {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
            margin: 40px auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .button-back {
            background-color: #dc3545; /* Красный цвет для кнопки "Назад" */
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px; 
            position: absolute; 
            top: 20px; 
            left: 20px; 
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button-back:hover {
            background-color: #c82333; /* Темнее при наведении */
            transform: translateY(-2px);
        }

        p {
            font-size: 18px;
            margin: 20px 0;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<h1>Удаление информации о студенте</h1>
<a href="admin.html" class="button-back">Назад</a>

<form method="GET" action="delete.php">
    <label for="id">ID студента для удаления:</label>
    <input type="number" id="id" name="id" required>

    <input type="submit" value="Удалить">
</form>

<?php
$servername = "db";
$username = "root";
$password = "example";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $id = $conn->real_escape_string($id);

    $sql = "DELETE FROM products WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Запись успешно удалена</p>";
    } else {
        echo "<p class='error'>Ошибка: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<footer>
    &copy; 2024 Недбай Егор Дмитриевич
</footer>

</body>
</html>