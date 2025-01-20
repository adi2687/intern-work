<?php
function generateOwnerId() {
    // Use a combination of a random string and the current timestamp
    $timestamp = time(); // Get current Unix timestamp
    $randomString = bin2hex(random_bytes(8)); // Generate 16-character random string

    // Combine them to form the owner ID
    $ownerId = strtoupper("OWN-" . $timestamp . "-" . $randomString);
    
    return $ownerId;
}


try {
    DB::connect();

    if (isset($_POST['signup'])) {
        if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email'])) {
            
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $userId=generateOwnerId();
            $data = [
                'userId'=>$userId,
                'name' => $_POST['name'],
                'password' => $hashedPassword, 
                'email' => $_POST['email'],
                'phone'=>$_POST['phone']
            ];

           
            DB::insert('users', $data);
            session_start();
            $_SESSION['userId']=$userId;
            header("Location: profile");
            echo "User successfully registered!";
        } else {
            echo "Please fill in all fields!";
        }
    }

    // Close the connection
    DB::close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Selling</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f9;
  margin: 0;
  padding: 0;
}

.container {
  width: 80%;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  color: #333;
}

.add-car-form,
.car-listing {
  margin-bottom: 40px;
}

form input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
}

form button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

form button:hover {
  background-color: #0056b3;
}

ul {
  list-style-type: none;
  padding: 0;
}

.car-item {
  background-color: #f9f9f9;
  padding: 15px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.car-item h3 {
  margin: 0;
  font-size: 20px;
  color: #333;
}

.car-item p {
  margin: 5px 0;
  color: #555;
}

.login {
  cursor: pointer;
}

.loginform {
  display: none;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
  max-width: 400px;
  margin: 0 auto;
}

label {
  margin-top: 10px;
  font-size: 14px;
}

input {
  padding: 10px;
  margin-top: 5px;
  font-size: 14px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

button {
  margin-top: 20px;
  padding: 10px;
  font-size: 16px;
  background-color: #86363B;
  color: white;
  border: none;
  border-radius: 5px;
}

button:hover {
  background-color: #722D2A;
}

nav {
  background-color: #86363B;
  padding: 10px 0;
  text-align: center;
}

nav ul {
  list-style-type: none;
  padding: 0;
}

nav ul li {
  display: inline;
  margin-right: 20px;
}

nav ul li {
  color: white;
  text-decoration: none;
  font-size: 16px;

}

.theme {
  display: flex;
  margin-bottom: 20px;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.theme img {
  width: 200px;
  height: 150px;
  object-fit: cover;
  border-radius: 10px;
}

.theme-details {
  margin-left: 20px;
  display: flex;
  flex-direction: column;
}

.theme-details h3 {
  font-size: 18px;
  margin: 0;
}

.theme-details p {
  margin: 5px 0;
}

nav ul li a {
  cursor: pointer;
  color: white;

}
    </style>
</head>


<body>

    <nav>
        <ul>
            <li> <a href="">Home</a></li>
            <li><a href="cars">See cars</a></li>
        </ul>
    </nav>
    <div class="container">
        <form method="POST" action="" class="signupform">
        <h2>Sign Up</h2>

            <label for="username">Username</label>
            <input type="text" id="username" name="name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" required>
            <button type="submit" name="signup">Sign Up</button>
            <p>Already have an account ?
            <p class="login">Login</p>
            </p>
        </form>



        <form method="POST" action="login.php" class="loginform">
            <h2>Login</h2>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
            <p>Don't have an account?
            <p class="sign">Sign Up</p>
            </p>

        </form>
    </div>
</body>

</html>

</div>
<script>
    document.querySelector(".login").addEventListener("click", () => {
        document.querySelector(".loginform").style.display = "block"
        document.querySelector(".signupform").style.display = "none"
    })
    document.querySelector(".sign").addEventListener("click", () => {
        document.querySelector(".loginform").style.display = "none"
        document.querySelector(".signupform").style.display = "block"
    })
</script>
</body>

</html>