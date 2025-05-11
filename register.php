<?php
    require_once('config.php');
?>
 
<html>
<head>
<!--<link rel="stylesheet" href="styles.css">-->
</head>
<body>
 
<?php
    $fnameErr = $mnameErr = $lnameErr = $addressErr = $emailErr = $usernameErr = $passwordErr = $cpasswordErr = $dateofbirthErr = $genderErr = $phoneErr = "";
    $fname = $mname = $lname = $address = $email = $username = $password = $cpassword = $dateofbirth = $gender = $phone = "";

 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["fname"])) {
            $fnameErr = "Please enter your first name.";
        } else {
            $name = trim($_POST["fname"]);
            if (!preg_match('/^[A-Z a-z\s]+$/', $fname)) {
                $fnameErr = "Only alphabetic characters and spaces are allowed.";
            }
        }

        if (empty($_POST["mname"])) {
            $mnameErr = "Please enter your middle name.";
        } else {
            $mname = trim($_POST["mname"]);
            if (!preg_match('/^[A-Z a-z\s]+$/', $mname)) {
                $mnameErr = "Only alphabetic characters and spaces are allowed.";
            }
        }

        if (empty($_POST["lname"])) {
            $lnameErr = "Please enter your last name.";
        } else {
            $lname = trim($_POST["lname"]);
            if (!preg_match('/^[A-Z a-z\s]+$/', $lname)) {
                $lnameErr = "Only alphabetic characters and spaces are allowed.";
            }
        }

        if (empty($_POST["address"])) {
            $addressErr = "Please enter your current address.";
        } else {
            $address = trim($_POST["address"]);
            if (!preg_match('/^[A-Z a-z\s]+$/', $address)) {
                $addressErr = "Only alphabetic characters and spaces are allowed.";
            }
        }
   
        if (empty($_POST["email"])) {
            $emailErr = "Please enter a valid email address.";
        } else {
            $email = trim($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = trim($_POST["username"]);
            if (
                strlen($username) < 5 || strlen($username) > 20 ||
                !preg_match('/^[A-Za-z0-9_-]+$/', $username)
            ) {
                $usernameErr =  "Username must be between 5 and 20 characters and cannot 
                contain spaces.";                
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr =  "Password is required.";
        } else {
            $password = trim($_POST["password"]);
            if (
                strlen($password) < 8 || strlen($password) > 20 ||
                !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[a-z]/', $password) ||
                !preg_match('/[0-9]/', $password) ||
                !preg_match('/[\W]/', $password)
            ) {
                $passwordErr =  "Password must be at least 8 characters long and include one 
                uppercase letter, one lowercase letter, one number, and one special character.";
            }
        }

        if (empty($_POST["cpassword"])) {
            $cpasswordErr = "Confirm Password is required";
        } else {
            $cpassword = trim($_POST["cpassword"]);
            if ($cpassword !== $password) {
                $cpasswordErr = "Passwords do not match.";
            }
        }

        if (empty($_POST["dateofbirth"])) {
            $dateofbirthErr = "Date of Birth is required";
        } else {
            $dateofbirth = trim($_POST["dateofbirth"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = trim($_POST["gender"]);
        }

        if (!empty($_POST["phone"])) {
            $phone = trim($_POST["phone"]);
            if (!preg_match('/^\+?[0-9]{0,3}?\d{11}$/' , $phone)){
                $phoneErr = "Please enter a valid phone number.";
            }
        }
   
 
        if (empty($nameErr) && empty($emailErr) && empty($usernameErr) && empty($passwordErr) && empty($cpasswordErr) && empty($dateofbirthErr) && empty($genderErr) && empty($phoneErr)) {
            $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, cpassword, dateofbirth, gender, phone) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssss", $name, $email, $username, $password, $cpassword, $dateofbirth, $gender, $phone);
 
            if ($stmt->execute()) {
                $name = $email = $username = $password = $cpassword = $dateofbirth = $gender = $phone = "";
                header("Location: success.php");
                exit();
            } else {
                echo "<p style='color: red;'> Error: ". $stmt->error . "</p>";
            }
 
            $stmt->close();
        }
    }
 
$conn->close();
?>

<div class="container1" id="signUp">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<h2 name="title" id="title">Create an Account</h2>

<label>First Name:</label><br>
<input type="text" name="fname" placeholder="---" value="<?php echo htmlspecialchars($fname);?>">
<span style="color: red;" id="fnameerror"><?php  echo $fnameErr; ?></span><br><br>

<label>Middle Name: (Optional)</label><br>
<input type="text" name="mname" placeholder="---" value="<?php echo htmlspecialchars($mname);?>">
<span style="color: red;" id="mnameerror"><?php  echo $mnameErr; ?></span><br><br>

<label>Last Name:</label><br>
<input type="text" name="lname" placeholder="---" value="<?php echo htmlspecialchars($lname);?>">
<span style="color: red;" id="lnameerror"><?php  echo $lnameErr; ?></span><br><br>

<label>Current Address:</label><br>
<input type="text" name="address" placeholder="---" value="<?php echo htmlspecialchars($address);?>">
<span style="color: red;" id="addresserror"><?php  echo $addressErr; ?></span><br><br>
 
<label>E-mail:</label><br>
<input type="email" name="email" placeholder="youremail@example.com" value="<?php echo htmlspecialchars($email);?>">
<span style="color: red;" id="emailerror"><?php echo $emailErr; ?></span><br><br>

<label>Username:</label><br>
<input type="text" name="username" placeholder="Choose a username" value="<?php echo htmlspecialchars($username);?>">
<span style="color: red;" id="usernameerror"><?php echo $usernameErr; ?></span><br><br>

<label>Password:</label><br>
<input type="password" name="password" placeholder="Enter a password" value="<?php echo htmlspecialchars($password);?>">
<span style="color: red;" id="passworderror"><?php echo $passwordErr; ?></span><br><br>

<label>Confirm Password:</label><br>
<input type="password" name="cpassword" placeholder="Re-enter your password" value="<?php echo htmlspecialchars($cpassword);?>">
<span style="color: red;" id="cpassworderror"><?php echo $cpasswordErr; ?></span><br><br>

<label>Date of Birth:</label><br>
<input type="date" name="dateofbirth" value="<?php echo htmlspecialchars($dateofbirth);?>">
<span style="color: red;" id="dateofbirtherror"><?php echo $dateofbirthErr; ?></span><br><br>

<label>Gender:</label><br>
<div class="radio-options">
    <label>Male<input type="radio" name="gender" id="male"  value="male"<?php ($gender == "male");?>></label>
    <label>Female<input type="radio" name="gender" id="female"  value="female"<?php ($gender == "female")?>></label>
    <label>Others<input type="radio" name="gender" id="others"  value="others"<?php ($gender == "others");?>></label>
    <span style="color: red;" id="gendererror"><?php echo $genderErr; ?></span><br>
</div>

<label>Phone Number: (Optional)</label><br>
<input type="text" name="phone" placeholder= "Enter your phone number" value="<?php echo htmlspecialchars($phone);?>"><br>
<span style="color: red;" id="phoneerror"><?php echo $phoneErr; ?></span>

<br><label><input type="checkbox" name="box" id="box" required> I agree to the terms and conditions</label>
 
<button type="submit" id="btn">Create Account</button>

<div class="or">
<p>Already Have Account?</p> 
<u id="signin">Log In</u>
</div>
</div>
</form>
</body>
</html>