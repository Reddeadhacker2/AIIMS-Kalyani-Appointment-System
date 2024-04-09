<?php
include('connection.php');
session_start();
if (!$_SESSION['login']) {
  header('Location: logout2.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="favicon.jpg">
  <title>Server Side Operations</title>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
      font-weight: bolder;
    }


    .btnAdd {
      text-align: right;
      width: 83%;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 30px;
    }

    .btnAdd a {
      margin-left: 200px;
    }

    body {
      height: 94vh;
      width: 100%;
      background-image: url(pexels-philippe-donn-1114690.jpg);
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
      color: white;
    }

    .modal-content {
      color: black;
    }

    h1,
    h3 {
      margin-left: 12%;
    }

    #msgField {
      height: 100px;
    }

    .form-inline {
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 10px;
      margin-left: 40px;
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <h1 class="text-left my-3">AIIMS Kalyani</h1>
    <h3 class="datatable design text-left">Online Appointment Section</h3>
    <div class="row">
      <div class="container">
        <div class="btnAdd">
          <a href="crud.php" class="btn btn-info">Reservation Section</a>
          <form class="form-inline" method="POST" action="cancel.php">
            <div class="form-group mx-sm-3 mb-2">
              <input type="text" class="form-control" id="idpat" name="idpat" placeholder="ID Pattern" autocomplete="off" required>
            </div>
            <div class="button">
              <button type="submit" id="submit" class="btn btn-danger mb-2" onclick="confirmation()" disabled="disabled">Cancel Appointment</button>
            </div>
          </form>
          <a href="logout2.php" class="btn btn-danger">Logout</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
          <table id="example" class="table table-dark table-striped table-hover text-center">
            <thead>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Problem</th>
              <th>Doctor</th>
              <th>Apt_Date</th>
              <th>Apt_Time</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </div>
  </div>
  <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>

  <!-- fetch data -->
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
          'url': 'fetch_online.php',
          'type': 'post',
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": []
          },

        ]
      });
    });
  </script>


  <script>
    function confirmation() {
      var result = confirm("Are you sure ?");
      if(result == false)
      {
        event.preventDefault();
      }
    }
  </script>


  <script type="text/javascript">
    (function() {
      $('form > div > input').keyup(function() {
        var empty = false;
        $('form > div > input').each(function() {
          if ($(this).val()== '') {
          empty = true;
          }
        });
        if (empty) {
          $('#submit').attr('disabled', 'disabled');
        } else {
          $('#submit').removeAttr('disabled');
        }
      });
    })()
  </script>
</body>

</html>