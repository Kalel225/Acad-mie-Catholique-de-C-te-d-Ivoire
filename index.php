<?php
include('db_connect.php');

$query = "SELECT * FROM publications ORDER BY date DESC";
$result = mysqli_query($conn, $query);

while ($publication = mysqli_fetch_assoc($result)) {
    echo "<h2>" . $publication['title'] . "</h2>";
    echo "<p>" . $publication['content'] . "</p>";
    echo "<hr>";
}
?>
