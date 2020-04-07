<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            width: 1rem;
        }
    </style>
</head>
<?php
include("config.php");
include("connect.php");
include("libery.php");

$result_count = $mysqli->query('SELECT count(*) FROM guests'); //считаем количество строк в таблице
$count = $result_count->fetch_array(MYSQLI_NUM)[0];
echo "количество записей: " . $count;
$result_count->free();

$pagecount = ceil($count / $pagesize);
$currientpage = $_GET['page'] ?? 1;
$startrow = ($currientpage - 1) * $pagesize;
$pagenation = "<div class='pagenation>";
for ($i = 1; $i <= $pagecount; $i++) {
    $pagenation .= "<a href = '?page=$i'>$i</a>";
}
$pagenation .= "</div>";


$result = $mysqli->query("SELECT * FROM guests LIMIT $startrow, $pagesize");
echo $pagenation;
echo "<table border='1'>\n";
while ($row = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>" . smile($row->text) . "</td>";
    echo "<td>" . $row->name . "</td>";
    echo "</tr>";
}
echo "</table>\n";
echo $pagenation;
$result->free();

$mysqli->close();
?>

<body>

    <form action="add.php" method="POST">
        <textarea name="text" cols="30" rows="10"></textarea><br>
        <input type="text" name="name"><br>
        <button type="submit">отправить</button>
    </form>


</body>

</html>