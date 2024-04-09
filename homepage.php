<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AIIMS KALYANI OPD</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="full-page">
        <div class="navbar">
            <img title="Aiims Logo" src="logo.png" id="logo">
            <div id="KA">
                <a href='https://aiimskalyani.edu.in/'>AIIMS KALYANI</a>
                <P>Out Patient Department</P>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><button class='loginbtn' onclick="document.getElementById('login-form').style.display='block'" style="width:auto;">User</button></li>
                    <li><a href='admin.php' target="_blank">Admin</a></li>
                    <li><a href='Doctors List.pdf' target="_blank">Check Availability</a></li>
                </ul>
            </nav>
        </div>
        <div id='login-form' class='login-page'>
        </div>
        <div class="form-box">
            <div class='button-box'>
                <div id='btn'></div>
                <button type='button' onclick='login()' class='toggle-btn'>Log In</button>
                <button type='button' onclick='register()' class='toggle-btn'>Register</button>
            </div>
            <form id='login' class='input-group-login' action="sign_in.php" method="post">
                <ion-icon name="person-circle-outline" id="person"></ion-icon>
                <input type='text' value="<?php if (isset($_COOKIE["user_login"])) {
                                                echo $_COOKIE["user_login"];
                                            } ?>" class='input-field' maxlength="15" placeholder='Username' name="username" required>
                <i class="fa-solid fa-eye" id="eye"></i>
                <input type='password' value="<?php if (isset($_COOKIE["userpassword"])) {
                                                    echo $_COOKIE["userpassword"];
                                                } ?>" class='input-field' placeholder='Enter Password' id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" required>
                <script>
                    const passwordInput = document.querySelector("#password")
                    const eye = document.querySelector("#eye")
                    eye.addEventListener("click", function() {
                        this.classList.toggle("fa-eye-slash")
                        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
                        passwordInput.setAttribute("type", type)
                    })
                </script>
                <div class="check">
                <input type='checkbox' name="remember" id="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> title="save password" class='check-box'><span>Remember Me</span>
                <a href='forgot.php' target="_blank" id ="forgot">Forgot Password</a>
                </div>
                <button type='submit' class='submit-btn' id =="login"><U>Log in</U></button>
            </form>
            <form id='register' class='input-group-register' action="sign_up.php" method="post">
                <input type='text' class='input-field' placeholder='First Name' name="firstname" required>
                <input type='text' class='input-field' placeholder='Last Name ' name="lastname" required>
                <input type='email' class='input-field' placeholder='Email Id' name="email" required>
                <input type='text' class='input-field' maxlength="15" placeholder='Username' name="username" required>
                <i class="fa-solid fa-eye" id="eye1"></i>
                <input type='password' class='input-field' placeholder='Enter Password' name="password" id="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                <input type='password' class='input-field' placeholder='Confirm Password' name="confirm_password" id="confirm_password" required>
                <input type='checkbox' title="Deceleration" class='check-box' required><a href="Terms & Conditions.pdf" target="_blank"><span>I accept and agree to the <b><U>Terms of Use.<U><b></span></a>
                <button type='submit' class='submit-btn' name='submit'>Register</button>
                <script>
                    const passwordInput1 = document.querySelector("#password1")
                    const eye1 = document.querySelector("#eye1")
                    eye1.addEventListener("click", function() {
                        this.classList.toggle("fa-eye-slash")
                        const type = passwordInput1.getAttribute("type") === "password" ? "text" : "password"
                        passwordInput1.setAttribute("type", type)
                    })
                </script>
                <script>
                    var password = document.getElementById("password1"),
                        confirm_password = document.getElementById("confirm_password");

                    function validatePassword() {
                        if (password1.value != confirm_password.value) {
                            confirm_password.setCustomValidity("Passwords Don't Match");
                        } else {
                            confirm_password.setCustomValidity('');
                        }
                    }

                    password1.onchange = validatePassword;
                    confirm_password.onkeyup = validatePassword;
                </script>
            </form>
        </div>
    </div>
    <script>
        var x = document.getElementById('login');
        var y = document.getElementById('register');
        var z = document.getElementById('btn');

        function register() {
            x.style.left = '-400px';
            y.style.left = '50px';
            z.style.left = '110px';
        }

        function login() {
            x.style.left = '50px';
            y.style.left = '450px';
            z.style.left = '0px';
        }
    </script>
    <script>
        var modal = document.getElementById('login-form');
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </div>
</body>

</html>