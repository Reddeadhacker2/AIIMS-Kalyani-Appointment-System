<?php
include('send_mail.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        *,
        *:before,
        *:after {
            box-sizing: border-box
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Raleway', sans-serif;
        }

        .container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;

            &:hover,
            &:active {

                .top,
                .bottom {

                    &:before,
                    &:after {
                        margin-left: 200px;
                        transform-origin: -200px 50%;
                        transition-delay: 0s;
                    }
                }

                .center {
                    opacity: 1;
                    transition-delay: 0.2s;
                }
            }
        }

        .top,
        .bottom {

            &:before,
            &:after {
                content: '';
                display: block;
                position: absolute;
                width: 200vmax;
                height: 200vmax;
                top: 50%;
                left: 50%;
                margin-top: -100vmax;
                transform-origin: 0 50%;
                transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
                z-index: 10;
                opacity: 0.65;
                transition-delay: 0.2s;
            }
        }

        .top {
            &:before {
                transform: rotate(45deg);
                background: #e46569;
            }

            &:after {
                transform: rotate(135deg);
                background: #ecaf81;
            }
        }

        .bottom {
            &:before {
                transform: rotate(-45deg);
                background: #60b8d4;
            }

            &:after {
                transform: rotate(-135deg);
                background: #3745b5;
            }
        }

        .center {
            position: absolute;
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            margin-left: -200px;
            margin-top: -200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
            transition-delay: 0s;
            color: #333;
            padding-bottom: 50px;
            
            h2{
                padding-bottom: 20px;
            }

            input {
                width: 100%;
                padding: 12px;
                margin: 5px;
                border-radius: 30px;
                border: 1px solid #ccc;
                font-family: inherit;
                font-weight: bolder;
            font-size: 15px;
            }
        }

        #reset {
            width: 100%;
            padding: 12px;
            margin: 5px;
            border-radius: 30px;
            border: 1px solid #ccc;
            font-family: inherit;
            background-color: #e46569;
            color: white;
            font-weight: bolder;
            font-size: 15px;
        }

        #reset:hover {
            background-color: #374585;
        }
        ::placeholder
        {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container" onclick="onclick">
        <div class="top"></div>
        <div class="bottom"></div>
        <div class="center">
            <h2>Password Reset</h2>
            <form action="reset_password.php" method="post">
                <input type="email" placeholder="Email" id="email" name ="email"/>
                <input type="password" placeholder="New Password" id="new_password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required>
                <button type="submit" id="reset">Reset Password</button>
            </form>
        </div>
    </div>

</body>

</html>
<?php
session_unset();
session_destroy();
?>