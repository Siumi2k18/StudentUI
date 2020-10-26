<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RateMyLab1</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>
<body>
    <?php
        session_start();
        echo "All" . $_SESSION['total_questions'] . " Questions Rated";
        echo "<br>Thank you for rating the lab";
        session_unset();
        session_destroy();
    ?>
</body>
</html>
