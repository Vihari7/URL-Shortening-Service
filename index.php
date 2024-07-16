<?php
// Require the configuration file
require "config.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database connection 
    $host = "localhost";
    $dbname = "short-urls";
    $user = "root";
    $pass = "";

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        if ($_POST['url'] == '') {
            echo "The input is empty";
        } else {
            $url = $_POST['url'];

            // Check if the URL already exists
            $check = $conn->prepare("SELECT COUNT(*) FROM urls WHERE url = :url");
            $check->execute(["url" => $url]);
            $urlExists = $check->fetchColumn();

            if ($urlExists) {
                echo "The URL already exists";
            } else {
                // Prepare and execute the insert query
                $insert = $conn->prepare("INSERT INTO urls (url) VALUES (:url)");
                $insert->execute(["url" => $url]);
            }
        }
    }

    // Fetch URLs from the database
    $stmt = $conn->query("SELECT * FROM urls");
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body { overflow: hidden; }
        .margin { margin-top: 200px }
    </style>
</head>
<body>

<div class="container">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <form class="card p-2 margin" method="POST" action="index.php">
                <div class="input-group">
                    <input type="text" name="url" class="form-control" placeholder="Your URL">
                    <div class="input-group-append">
                        <button type="submit" name="submit" class="btn btn-success">Shorten</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Long URL</th>
                        <th scope="col">Short URL</th>
                        <th scope="col">Clicks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rows)) : ?>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?php echo $row->url; ?></td>
                                <td><a href="http://localhost/short-urls/u?id=<?php echo $row->id;?>" target="_blank">http://localhost/short-urls/<?php echo $row->id;?></a></td>
                                <td><?php echo $row->clicks; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="3">No URLs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
