<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $guardian = $_POST['guardian'];
    $email = $_POST['email'];
    $phone1 = $_POST['phone'];
    $inputState1 = $_POST['inputState1'];
    $inputState2 = $_POST['inputState2'];
    $apt = $_POST['apt'];
    $gender = $_POST['gender'];

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'aiims3';

    $conn = mysqli_connect($host, $user, $pass, $dbname);

    //primary key customization
    date_default_timezone_set('Asia/Kolkata');
    $t = date("H:i:s");
    $a = strtoupper(substr($inputState1, 0, 3));
    $id = $a . ("-") . $apt . ("-") . ("SLOT") . ("-");
    $id_query = "SELECT * FROM `appointment` WHERE id like '$id%'";
    $id_query_result = mysqli_query($conn, $id_query);
    $entries = mysqli_num_rows($id_query_result);
    if ($entries == 0) {
        $id2 = $id . ("01");
    } else {
        if ($entries < 9) {
            $id2 = $id . ("0") . ($entries + 1);
        } else {
            $id2 = $id . ($entries + 1);
        }
    }

    //primary key customization ends

    function timeslot($entries)
    {
        $minutes = 00;
        $hours = 10;
        if ($entries == 0) {
            $time = ("10:00 am");
        } else {
            if ($entries < 8) {
                $minutes = $entries * 5;
            } else if ($entries >= 8 && $entries <= 15) {
                $minutes = ($entries + 4) * 5;
            } else if ($entries >= 16 && $entries <= 23) {
                $minutes = ($entries + 8) * 5;
            } else if ($entries >= 24 && $entries <= 31) {
                $minutes = ($entries + 12) * 5;
            }
            while ($minutes >= 60) {
                $minutes -= 60;
                $hours += 1;
            }
            if ($hours > 12) {
                $hours = $hours - 12;
                if ($minutes == 0 || $minutes == 5) {
                    $time = ("0") . $hours . (":") . ("0") . $minutes . (" pm");
                } else {
                    $time = ("0") . $hours . (":") . $minutes . (" pm");
                }
            } else if ($hours == 12) {
                if ($minutes == 0 || $minutes == 5) {
                    $time = $hours . (":") . ("0") . $minutes . (" pm");
                } else {
                    $time = $hours . (":") . $minutes . (" pm");
                }
            } else if ($hours < 12) {
                if ($minutes == 0 || $minutes == 5) {
                    $time = $hours . (":") . ("0") . $minutes . (" am");
                } else {
                    $time = $hours . (":") . $minutes . (" am");
                }
            }
        }
        return $time;
    }

    //date customization to dd-mm-yyyy format
    $apt2 = date("d-m-Y", strtotime($apt));
    $dob2 = date("d-m-Y", strtotime($dob));

    //day from date
    function day($apt)
    {
        $day1 = strtotime($apt);
        $day = date('l', $day1);
        return $day;
    }
    function day1($dob)
    {
        $day1 = strtotime($dob);
        $day = date('l', $day1);
        return $day;
    }

    $time1 = timeslot($entries);


    if ($entries <= 31) {
        $que = "SELECT * FROM appointment WHERE fullname='$fullname' AND guardian='$guardian' AND dob = '$dob' AND apt = '$apt' AND problem = '$inputState1'";
        $res = mysqli_query($conn, $que);
        $cou = mysqli_num_rows($res);

        if ($cou > 0) {
            $message = "Duplicate entry !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='appointment.php'</script>";
        } else {
            $mul_query = "SELECT * FROM appointment WHERE email='$email' AND apt = '$apt'";
            $mul_result = mysqli_query($conn, $mul_query);
            $mul_count = mysqli_num_rows($mul_result);

            if ($mul_count < 2) {
                $sql = "insert into appointment(id, fullname, dob, address, guardian, email, phone, problem, doctor, apt, gender, apt_time)values('$id2','$fullname','$dob','$address','$guardian','$email','$phone1','$inputState1','$inputState2','$apt','$gender','$time1')";
                mysqli_query($conn, $sql);

                require('fpdf/fpdf.php');
                class PDF extends FPDF
                {
                    // Page header
                    function Header()
                    {
                        $this->Rect(5, 5, 200, 287, 'D');
                        // Logo
                        $this->Image('aiims_logoV1.png', 25, 8, 160);
                        $this->SetFont('Times', 'BU', 20);
                        $this->Ln(37);
                        $this->SetTextColor(220, 50, 50);
                        $this->Cell(195, 10, 'Appointment Letter', 0, 10, 'C');
                        $this->Ln(20);
                    }

                    // Page footer
                    function Footer()
                    {
                        // Position at 1.5 cm from bottom
                        $this->SetY(-15);
                        $this->Image('booked.jpg', 55, 230, 100);
                        // Arial italic 8
                        $this->SetFont('Arial', 'I', 8);
                        // Page number
                        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
                    }
                }

                $pdf = new PDF();
                $pdf->AddPage();
                $x = $pdf->GetX();
                $pdf->SetFont('Times', 'IBU', 18);
                $pdf->SetTextColor(220, 50, 50);
                $pdf->Cell(100, 10, 'Fields', 1, 0, 'C');
                $pdf->Cell(0, 10, 'Values', 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->SetFont('Times', '', 18);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(100, 10, 'ID', 1, 0, 'C');
                $pdf->Cell(0, 10, $id2, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Full Name', 1, 0, 'C');
                $pdf->Cell(0, 10, $fullname, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'DOB', 1, 0, 'C');
                $pdf->Cell(0, 10, $dob2 . (", ") . day1($dob), 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Gender', 1, 0, 'C');
                $pdf->Cell(0, 10, $gender, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Guardian', 1, 0, 'C');
                $pdf->Cell(0, 10, $guardian, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Address', 1, 0, 'C');
                $pdf->Cell(0, 10, $address, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'E-mail', 1, 0, 'C');
                $pdf->Cell(0, 10, $email, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Phone', 1, 0, 'C');
                $pdf->Cell(0, 10, $phone1, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Problem', 1, 0, 'C');
                $pdf->Cell(0, 10, $inputState1, 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Doctor', 1, 0, 'C');
                $pdf->Cell(0, 10, $inputState2, 1, 1, 'C');
                $pdf->SetX($x);
                date_default_timezone_set('Asia/Kolkata');
                $pdf->Cell(100, 10, 'Current Date', 1, 0, 'C');
                $pdf->Cell(0, 10, date("d-m-Y") . (", ") . date("l"), 1, 1, 'C');
                $pdf->Cell(100, 10, 'Current Time', 1, 0, 'C');
                $pdf->Cell(0, 10, date("h:i:s a"), 1, 1, 'C');
                $pdf->Cell(100, 10, 'Date of Appointment', 1, 0, 'C');
                $pdf->Cell(0, 10, $apt2 . (", ") . day($apt), 1, 1, 'C');
                $pdf->SetX($x);
                $pdf->Cell(100, 10, 'Time of Appointment', 1, 0, 'C');
                $pdf->Cell(0, 10, timeslot($entries), 1, 1, 'C');
                $PDF = $pdf->Output('S', '');


                // require_once __DIR__ . '/vendor/autoload.php';
                // date_default_timezone_set('Asia/Kolkata');

                // $mpdf = new \Mpdf\Mpdf();

                // $data = '';
                // $data .= '<strong>ID :- </strong>' . $id2 . '<br/>';
                // $data .= '<strong>Fullname :- </strong>' . $fullname . '<br/>';
                // $data .= '<strong>DOB :- </strong>' . $dob2.(", ").day1($dob) . '<br/>';
                // $data .= '<strong>Gender :- </strong>' . $gender . '<br/>';
                // $data .= '<strong>Address :- </strong>' . $address . '<br/>';
                // $data .= '<strong>Guardian :- </strong>' . $guardian . '<br/>';
                // $data .= '<strong>Email :- </strong>' . $email . '<br/>';
                // $data .= '<strong>Phone :- </strong>' . $phone1 . '<br/>';
                // $data .= '<strong>Problem :- </strong>' . $inputState1 . '<br/>';
                // $data .= '<strong>Doctor :- </strong>' . $inputState2 . '<br/>';
                // $data .= '<strong>Current Date :- </strong>' . date("d-m-Y") . (", ") . date("l") . '<br/>';
                // $data .= '<strong>Current Time :- </strong>' . date("h:i:s a") . '<br/>';
                // $data .= '<strong>Appointment Date :- </strong>' . $apt2.(", ").day($apt) . '<br/>';
                // $data .= '<strong>Appointment Time :- </strong>' . timeslot($entries) . '<br/>';

                // $mpdf->WriteHTML($data);
                // $pdf =  $mpdf->Output('','S');

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through 
                $mail->Username   = 'aiims.24x7@gmail.com';
                $mail->Password   = 'zlzg xrrl bjqw fpsp';                      //use email password                       //SMTP password
                $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                $mail->Port       = 587;
                $mail->setFrom('aiims.24x7@gmail.com', 'AIIMS OPD'); //use email
                $mail->addAddress($email);
                $mail->addReplyTo('aiims.24x7@gmail.com');
                $mail->addStringAttachment($PDF, 'appointment.pdf');
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Appointment Slip from AIIMS OPD';
                $mail_template = "<h2>Congratulations $_POST[fullname], your appointment under $_POST[inputState2] is booked.</h2>
                <h3>Please download the appointment pdf which is attatched with this mail,
                you are advised to carry the printed version of the appointment receipt at the time of your appointment.</h3>";
                $mail->Body = $mail_template;
                if ($mail->send()) {
                    $message = "Appointment booked, Check your email !";
                    echo "<script type='text/javascript'>alert('$message');window.location.href='logged_out.php'</script>";
                } else {
                    $message = "Error occured, try again !";
                    echo "<script type='text/javascript'>alert('$message');window.location.href='appointment.php'</script>";
                }
            }
            else {
                $message = "2 slots booked already !";
                echo "<script type='text/javascript'>alert('$message');window.location.href='appointment.php'</script>";
            }
        }
    } else {
        $message = "Slot fully booked, Try another date !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='appointment.php'</script>";
    }
}
?>