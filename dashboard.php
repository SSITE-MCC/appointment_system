<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); 
        exit();
    }
    $username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dbstyle.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1> Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        </header>

        <div class="topbar">
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
