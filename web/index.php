<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Электронная зачетная книжка</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            position: relative; 
            text-align: center;
        }

        h1 {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            margin: 0;
            border-bottom: 4px solid #007BFF;
        }

        h1 a {
            text-decoration: none;
            color: #ffffff;
            font-size: 24px;
        }

        form {
            text-align: center;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
        }

        label {
            font-size: 18px;
            margin-right: 10px;
        }

        select {
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 10px 0;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .button-logout {
            background-color: #dc3545; /* Красный цвет для кнопки выхода */
            color: #ffffff;
            border-radius: 5px;
            padding: 10px 20px; 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button-logout:hover {
            background-color: #c82333; /* Темнее при наведении */
            transform: translateY(-2px);
        }

        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <h1>Электронная зачетная книжка</h1>
    <a href="login.html" class="button-logout">Выйти</a>

    <form method="GET" action="index.php">
        <label for="semester">Выберите семестр:</label>
        <select id="semester" name="semester">
            <option value="1">Семестр 1</option>
            <option value="2">Семестр 2</option>
            <option value="3">Семестр 3</option>
            <option value="4">Семестр 4</option>
        </select>

        <label for="sort">Сортировка:</label>
        <select id="sort" name="sort">
            <option value="id_asc">По ID (по возрастанию)</option>
            <option value="id_desc">По ID (по убыванию)</option>
            <option value="name_asc">По ФИО (А-Я)</option>
            <option value="name_desc">По ФИО (Я-А)</option>
            <option value="description_asc">По дисциплине (А-Я)</option>
            <option value="description_desc">По дисциплине (Я-А)</option>
        </select>
        <input type="submit" value="Применить">
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

    $sort = "id_asc";
    $semester = "1"; 

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["sort"])) {
            $sort = $_GET["sort"];
        }
        if (isset($_GET["semester"])) {
            $semester = $_GET["semester"];
        }
    }

    $orderField = "price";
    $orderDirection = "ASC";
    
    if ($sort == "name_asc") {
        $orderField = "name";
    } elseif ($sort == "name_desc") {
        $orderDirection = "DESC";
        $orderField = "name";
    } elseif ($sort == "description_asc") {
        $orderField = "description";
    } elseif ($sort == "description_desc") {
        $orderDirection = "DESC";
        $orderField = "description";
    } elseif ($sort == "id_asc") {
        $orderField = "id";
    } elseif ($sort == "id_desc") {
        $orderDirection = "DESC";
        $orderField = "id";
    }

    $sql = "SELECT * FROM products";
    if ($semester !== "") {
        $sql .= " WHERE semestr = ?";
    }
    $sql .= " ORDER BY $orderField $orderDirection";

    $stmt = $conn->prepare($sql);
    if ($semester !== "") {
        $stmt->bind_param("i", $semester);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>ФИО</th><th>Наименование дисциплины</th><th>Вид контроля</th><th>Оценка(балл)</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"]. "</td>";
            echo "<td>" . $row["name"]. "</td>";
            echo "<td>" . $row["description"]. "</td>";
            echo "<td>" . $row["control"]. "</td>";
            echo "<td>" . $row["price"]. "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>Нет записей в базе данных</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <footer>
        &copy; 2024 Недбай Егор Дмитриевич
    </footer>
</body>
</html>