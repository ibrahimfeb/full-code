<?php

// CRUD = Create => Retrieve => Update => Delete

// Create Operation

if (isset($_POST["sb"])) {

    include_once "database.php";
    $db = new Database;
    $pdo = $db->connect();

    // get data from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $priority = $_POST['priority'];

    // inserting query
    $q = "INSERT INTO try(title,description,link,priority) values(?,?,?,?)";
    $st = $pdo->prepare($q);
    if ($st->execute([
        "$title",
        "$description",
        "$link",
        $priority
    ])) {
        header("location:display.php");
        exit();
    } else
        echo "faield!";
}

// Retrieve Operation

include_once "database.php";
$db = new Database;
$pdo = $db->connect();


$qu = "SELECT * FROM try";
$st = $pdo->prepare($qu);
$st->execute();



echo "<a href='form.php'>Add</a><hr>";
$count = $st->rowCount();
echo "Rows $count";

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Link</th><th>Priority</th><th>Delete</th><th>Update</th>";
echo "</tr>";


while ($r = $st->fetch()) {

    echo "<tr>";
    echo "<td>" . $r["id"] . "</td>";
    echo "<td>" . $r["title"] . "</td>";
    echo "<td>" . $r["description"] . "</td>";
    echo "<td>" . $r["link"] . "</td>";
    echo "<td>" . $r["priority"] . "</td>";
    echo "<td><a href='delete.php?iid=" . $r["id"] . "'>Delete</a></td>";
    echo "<td><a href='update.php?iid=" . $r["id"] . "'>Update</a></td>";




    echo "</tr>";
}
echo "</table>";

// Update Operation

include_once "./database.php";
$db = new Database;
$pdo = $db->connect();

$i_d = $_GET['iid'];

if (isset($_POST["sb"])) {
    $title = $_POST["title"];
    $des = $_POST["description"];
    $link = $_POST["link"];
    $pr = $_POST["priority"];
    $st = $pdo->prepare("UPDATE try SET title=? , description=? , link=? ,priority=? WHERE id=?");
    if ($st->execute(["$title", "$des", "$link", $pr, $i_d])) {
        header("location:display.php");
        exit();
    } else echo "Failed to update!";
}

?>
<form method="post">
    <?php
    $q = "SELECT * FROM try WHERE id=$i_d LIMIT 1";
    $st = $pdo->prepare($q);
    $st->execute();
    $row = $st->fetch();

    ?>

    <h1>Registration Form</h1>
    Title<br> <input type="text" name="title" <?php if (isset($row["title"])) echo "value='" . $row["title"] . "'"; ?>>
    <br><br>
    descraption <br> <input type="text" name="description" <?php if (isset($row["description"])) echo "value='" . $row["description"] . "'"; ?>>
    <br><br>
    link <br><input type="text" name="link" <?php if (isset($row["link"])) echo "value='" . $row["link"] . "'"; ?>>
    <br><br>
    priority <br><input type="text" name="priority" <?php if (isset($row["priority"])) echo "value='" . $row["priority"] . "'"; ?>>
    <br><br>
    <input type="submit" value="Submit" name="sb" class="submit" id="submit">
</form>

<!-- Delete Opeation -->

<?php
include_once "./database.php";
$db = new Database;
$pdo = $db->connect();

$i_d = $_GET['iid'];
$q = "DELETE FROM try WHERE id ='$i_d'";
$st = $pdo->prepare($q);
$st->execute();

if ($st) {
    echo "Row deleted";
    header("location: display.php");
    exit();
} else {
    echo "Do not deleted";
}
