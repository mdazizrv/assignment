<!DOCTYPE html>
<html>
<head>
  <title>Sign Up Form</title>
  <style>

  .error
  {
    color: #FF0000;
  }

  .container
  {
  	max-width:400px;
  	width:100%;
  	margin:0 auto;
  	position:relative;
    border:1px solid black;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
  }

  input[type=text], textarea
  {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    resize: vertical;
  }


  button[type=submit]
  {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .wrapper {
    text-align: center;
  }

  </style>
</head>
<body>

  <?php

  $nameErr = $emailErr = $passwordErr = $confirmErr = "";
  $name = $email = $password = $confirm = "";
  $output = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Name is required";
    } else {
      $name = test_input($_POST["name"]);

      if(!preg_match("/^[a-zA-Z ]*$/",$name))
      {
        $nameErr = "Name can contain only letters and white spaces";
      }
    }

    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } else {
      $email = test_input($_POST["email"]);

      if(!filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        $emailErr = "Invalid Email Format";
      }
    }

    if (empty($_POST["password"])) {
      $passwordErr = "Password is required";
    } else {
      $password = test_input($_POST["password"]);

      if(strlen($password) < 8)
      {
        $passwordErr = "Password must contain atleast 8 characters";
      }
    }

    if (empty($_POST["confirm"])) {
      $confirmErr = "Confirm Password is required";
    } else {
      $confirm = test_input($_POST["confirm"]);

      if($password != $confirm)
      {
        $confirmErr = "Passwords did not match";
      }
    }



  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <h3>Sign Up Form</h3>
      <h4>Please fill the following details</h4>
      <table cellspacing="15">
        <tr>
          <td>Name :</td>
          <td><input type="text" name="name" placeholder="Enter your name"><span class="error">* <?php echo $nameErr;?></span></td>
        </tr>
        <tr>
          <td>Email :</td>
          <td><input type="text" name="email" placeholder="Enter your email address"><span class="error">* <?php echo $emailErr;?></span></td>
        </tr>
        <tr>
          <td>Password :</td>
          <td><input type="password" name="password" placeholder="Enter Password"><span class="error"><?php echo $passwordErr;?></span></td>
        </tr>
        <tr>
          <td>Confirm Password:</td>
          <td><input type="password" name="confirm" placeholder="Re-enter Password"><span class="error"><?php echo $confirmErr;?></span></td>
        </tr>
      </table>
      <br><p><span class="error">* required field</span></p><br><br>
      <div class="wrapper">
        <button name="submit" type="submit">Submit</button>
      </div>
    </form>
    </div>
    <?php

    if(isset($_POST['submit']) && $nameErr == "" && $emailErr == "" && $passwordErr == "" && $confirmErr == "")
    {
      $name = test_input($_POST["name"]);
      $email = test_input($_POST["email"]);
      $password = test_input($_POST["password"]);

      $link = mysqli_connect("localhost", "admin", "adminspassword", "accounts");


      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      $name = "'".$name."'";
      $email = "'".$email."'";
      $password = "'".$password."'";

      $sql = "INSERT INTO acctable(name,email,password) VALUES ($name,$email,$password)";

      if(mysqli_query($link, $sql))
      {
          echo "<br><p>Thank You. Your ratings are recorded successfully.</p>";
      } else
      {
          echo "<br><p>ERROR: Could not able to execute $sql. " . mysqli_error($link) . "</p>";
      }

      mysqli_close($link);
    }

     ?>
</body>

</html>
