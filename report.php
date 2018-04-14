<?php
$error = null;

if (isset($_GET["uuid"])) {

    $host = "192.168.64.2";
    $username = "serveronly";
    $password = "";
    $dbname = "dev_database";

    $database = new mysqli($host, $username, $password, $dbname);
    if ($database->connect_errno) {
        echo "Failed to connect to database! (" . $database->connect_errno . ") " . $database->connect_error;
        exit();
    }
    $uuid = $database->real_escape_string($_GET['uuid']);
    $res = mysqli_query($database, "SELECT * FROM chat_reports WHERE uuid='" . $uuid . "';");
    $row = mysqli_fetch_assoc($res);

    $messages = htmlspecialchars($row['messages']);

    if ($row['uuid'] == null) {
        $error = "Invalid report!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Chat Reports</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Online Chat Logs</a>
    </nav>
        <div class="container" style="margin-top: 200px">
            <div class="row">
                <div class="col-sm-10 offset-sm-1">
                    <h1 class="display-4" style="margin-bottom: 20px; text-align:center">
                        <?php
                        if (isset($_GET["uuid"])) {
                            if ($error != null) {
                                echo $error . "</h1>";
                                    echo "<div class=\"form-row\"";
                                        echo "<div>";
                                    echo "<button style=\"margin: 0 auto;\" class=\"btn btn-primary\" onclick='location.href=\"index.html\"'>Go back</button>";
                                    echo "</div>";
                                echo "</div>";
                            } else {
                                echo $row['name'] . "'s chat logs</h1>";
                                echo "<a style=\"white-space: pre-line;\">$messages</a>";
                                echo "<div>";
                                    echo "<button style=\"margin-top: 20px;\" class=\"btn btn-primary\" onclick='location.href=\"index.html\"'>Go back</button>";
                                echo "</div>";
                            }
                        } else {
                        if ($error != null) {
                            echo $error . "</h1>";
                                echo "<div class=\"form-row\"";
                                    echo "<div>";
                                echo "<button style=\"margin: 0 auto;\" class=\"btn btn-primary\" onclick='location.href=\"index.html\"'>Go back</button>";
                                echo "</div>";
                            echo "</div>";
                            }
                        }
                        ?>
                </div>
            </div>
        </div>
        <footer style="border-top: 0.1rem solid #c0c0c0; margin-top: 30px; position: absolute; right: 0; bottom: 0; left: 0; padding: 1rem; background-color: #efefef;">
            <a>Copyright &copy; 2018 JustDontDie</a>
        </footer>
    </body>
</html>