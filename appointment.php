<?php
session_start();
if (!$_SESSION['aiims3']) {
    header('Location: homepage.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> AIIMS Kalyani Appointment Form</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="appointment.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

</head>

<body>
    <div class="navbar">
        <img src="logo.png" id="logo">
        <div id="KA">
            <a href='https://aiimskalyani.edu.in/'>AIIMS KALYANI</a>
            <P>Out Patient Department</P>
        </div>
    </div>
    <div class="container">
        <div class="title">Appointment Form</div>
        <form action="app_details.php" method="post" name="theform">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input type="text" placeholder="Enter your name" name="fullname" required>
                </div>
                <div class="input-box">
                    <span class="details">Date of Birth</span>
                    <input type="date" name="dob" id="dob" onchange="validateDob()" required>
                </div>
                <script>
                    function validateDob() {
                        var selectedDate = new Date(document.getElementById('dob').value);
                        var currentDate = new Date();
                        var minDate = new Date();
                        minDate.setFullYear(currentDate.getFullYear() - 105);
                        if (selectedDate < minDate) {
                            alert('Wrong Birthday provided, Please select a date within the last 105 years.');
                            document.getElementById('dob').value = '';
                        } else if (selectedDate > currentDate) {
                            alert('Wrong Birthday provided');
                            document.getElementById('dob').value = '';
                        }
                    }
                </script>
                <div class="input-box">
                    <span class="details">Present Address</span>
                    <input type="text" maxlength="32" placeholder="Enter your address" name="address" required>
                </div>
                <div class="input-box">
                    <span class="details">Father's Name / Spouse's Name (if duplicate entry, use the alternative)</span>
                    <input type="text" placeholder="Enter full name of your father/spouse" name="guardian" required>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="text" name="email"  value="<?php echo $_SESSION['email'];?>" readonly>
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input type="tel" id="numericInput" maxlength="10" minlength="10" placeholder="Enter your phone number" name="phone" pattern="[6789][0-9]{9}" title="Please enter valid phone number" required>
                    <script>
                            document.addEventListener('DOMContentLoaded', function() {
                            var numericInput = document.getElementById('numericInput');
                            // Add event listener for input event
                            numericInput.addEventListener('input', function() {
                            // Remove non-numeric characters
                            this.value = this.value.replace(/[^0-9]/g, '');
                            });
                        });
                    </script>    
                </div>
                <div class="input-box">
                    <span class="details" name="problem">Select Specialization</span>
                    <select id="inputState1" name="inputState1" class="form-select" onchange="doctor(this.id,'inputState2')" required>
                        <option value="">Choose according to your problem</option>
                        <option value="General Medicine">General Medicine</option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Paediatrics">Paediatrics</option>
                        <option value="Dermatology">Dermatology</option>
                        <option value="Ophthalmology">Ophthalmology</option>
                        <option value="ENT">ENT</option>
                        <option value="Psychiatry">Psychiatry</option>
                    </select>
                </div>
                <div class="input-box">
                    <span class="details">Select Doctor</span>
                    <select id="inputState2" class="form-select" name="inputState2" required>
                    </select>
                </div>
                <div class="input-box">
                    <span class="details">Date of Appointment (select within 1 month)</span>
                    <input type="text" name="apt" id="Apt" onchange="validateApt()" autocomplete = "off" required>
                </div>
                <script>
                    function validateApt() {
                        var selectedDate = new Date(document.getElementById('Apt').value);
                        var currentDate = new Date();
                        var maxDate = new Date();
                        maxDate.setMonth(currentDate.getMonth() + 1);
                        if (selectedDate < currentDate) {
                            alert('Please select a date of tomorrow or later.');
                            document.getElementById('Apt').value = '';
                        } else if (selectedDate > maxDate) {
                            alert('Please select a date within the next 1 month.');
                            document.getElementById('Apt').value = '';
                        }
                    }
                </script>
                <script>
                    $(function() {
                        $("#Apt").datepicker({
                            beforeShowDay: function(date) {
                                var day = date.getDay();
                                // Doctor availability
                                var firstDoctorAvailableDays = [1, 3, 5]; // Mon(1) Wed(3) Fri(5)
                                var secondDoctorAvailableDays = [2, 4, 6]; // Tue(2) Thu(4) Sat(6)

                                // Disable days based on selected doctor
                                var selectedDoctor = $("#inputState2").val();
                                if (selectedDoctor === "Dr. Abhijit Mahata" || selectedDoctor === "Dr. Preetha Chakraverty" || selectedDoctor === "Dr. Arnab Rong" || selectedDoctor === "Dr. Ramsankar Soren" || selectedDoctor === "Dr. Suman Mukherjee" || selectedDoctor === "Dr. Gagandeep" || selectedDoctor === "Dr. Nabanita Saha") {
                                    return [(firstDoctorAvailableDays.indexOf(day) !== -1), ""];
                                } else if (selectedDoctor === "Dr. Utsab Talukder" || selectedDoctor === "Dr. Jagriti Pramanick" || selectedDoctor === "Dr. Aritra Paul" || selectedDoctor === "Dr. Ananya Dutta" || selectedDoctor === "Dr. Souvik Saha" || selectedDoctor === "Dr. Noorain Aziza" || selectedDoctor === "Dr. Abir Podder") {
                                    return [(secondDoctorAvailableDays.indexOf(day) !== -1), ""];
                                }
                            }
                        });

                        // Change event listener for doctor selection
                        $("#inputState2").change(function() {
                            $("#Apt").datepicker("refresh");
                        });
                    });
                </script>
            </div>
            <div class="gender-details">
                <input type="radio" name="gender" value="Male" id="dot-1" required>
                <input type="radio" name="gender" value="Female" id="dot-2">
                <input type="radio" name="gender" value="Third" id="dot-3">
                <input type="radio" name="gender" value="Others" id="dot-4">
                <input type="radio" name="gender" value="Prefer not to say" id="dot-5">
                <span class="gender-title">Gender</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender" name="gender">Male</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender" name="gender">Female</span>
                    </label>
                    <label for="dot-3">
                        <span class="dot three"></span>
                        <span class="gender" name="gender">Third</span>
                    </label>
                    <label for="dot-4">
                        <span class="dot four"></span>
                        <span class="gender" name="gender">Others</span>
                    </label>
                    <label for="dot-5">
                        <span class="dot five"></span>
                        <span class="gender" name="gender">Prefer not to say</span>
                    </label>
                </div>
            </div>
            <div class="button">
                <button type="submit" name="submit" id="submit">Book Appointment</button>
            </div>
        </form>
        <div class="button" id="LO">
            <a href="logged_out.php">
                <input type="submit" id="Logout" value="<?php echo $_SESSION['username'];?> Logout">
            </a>
        </div>
    </div>
    <script>
        function doctor(s1, s2) {
            var s1 = document.getElementById(s1);
            var s2 = document.getElementById(s2);

            s2.innerHTML = "";
            if (s1.value == "General Medicine") {
                var optionArray = ['Dr. Abhijit Mahata|Dr. Abhijit Mahata', 'Dr. Utsab Talukder|Dr. Utsab Talukder'];
            } else if (s1.value == "Gynaecology") {
                var optionArray = ['Dr. Preetha Chakraverty|Dr. Preetha Chakraverty', 'Dr. Jagriti Pramanick|Dr. Jagriti Pramanick'];
            } else if (s1.value == "Paediatrics") {
                var optionArray = ['Dr. Arnab Rong|Dr. Arnab Rong', 'Dr. Aritra Paul|Dr. Aritra Paul'];
            } else if (s1.value == "Dermatology") {
                var optionArray = ['Dr. Ramsankar Soren|Dr. Ramsankar Soren', 'Dr. Ananya Dutta|Dr. Ananya Dutta'];
            } else if (s1.value == "Ophthalmology") {
                var optionArray = ['Dr. Suman Mukherjee|Dr. Suman Mukherjee', 'Dr. Souvik Saha|Dr. Souvik Saha'];
            } else if (s1.value == "ENT") {
                var optionArray = ['Dr. Gagandeep|Dr. Gagandeep', 'Dr. Noorain Aziza|Dr. Noorain Aziza'];
            } else if (s1.value == "Psychiatry") {
                var optionArray = ['Dr. Abir Podder|Dr. Abir Podder', 'Dr. Nabanita Saha|Dr. Nabanita Saha'];
            }
            for (var option in optionArray) {
                var pair = optionArray[option].split("|");
                var newoption = document.createElement("option");

                newoption.value = pair[0];
                newoption.innerHTML = pair[1];
                s2.options.add(newoption);
            }
        }
    </script>
    <script>
        function checkForm() {
            var f = document.forms['theform'].elements;
            var fieldsMustBeFiled = true;

            for (var i = 0; i < f.length; i++) {
                if (f[i].value.length == 0) {
                    fieldsMustBeFiled = false;
                }
            }
            if (fieldsMustBeFiled) {
                document.getElementById('submit').disabled = false;
            } else {
                document.getElementById('submit').disabled = true;
            }
        }
    </script>
</body>

</html>