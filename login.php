<?php
    require_once('config.php');
    session_start();
?>

<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
$emailErr = $passwordErr = $loginErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $loginErr = "Invalid email or password.";
            }
        } else {
            $loginErr = "Invalid email or password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<div class="container2" id="login">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<h2 name="title" id="title">Log In</h2>

<?php if (!empty($loginErr)) echo "<p style='color: red; text-align: center;'>$loginErr</p>"; ?>

<label>Email:</label><br>
<input type="text" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
<span style="color: red;" id="emailerror"><?php echo $emailErr; ?></span><br><br>

<label>Password:</label><br>
<input type="password" name="password" placeholder="Enter your password">
<span style="color: red;" id="passworderror"><?php echo $passwordErr; ?></span><br><br>

<button type="submit" id="btn">Log In</button>

<div class="or">
<p>Don't have an Account?</p> 
<a href="register.php" id="signin" style="text-decoration: underline; cursor: pointer;">Sign Up</a>
</div>
</form>
</div>

</body>
</html>
