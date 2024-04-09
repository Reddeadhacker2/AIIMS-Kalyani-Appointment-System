<?php
include('connection.php');
session_start();
if(!$_SESSION['login'])
{
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
  <link rel="icon" type="image/x-icon" href="favicon.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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

    h1,h3 {
      margin-left: 12%;
    }

    #eye{
          position: absolute;
          right: 30px;
          top:45%;
          transform: translateY(-30%);
        }
  </style>
</head>

<body>
  <div class="container-fluid">
    <h1 class="text-left my-3">AIIMS Kalyani</h1>
    <h3 class="datatable design text-left">Reservation Section</h3>
    <div class="row">
      <div class="container">
        <div class="btnAdd">
          <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success">Add Patient</a>
          <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addAdminModal" class="btn btn-warning">Add Admin</a>
          <a href="logout2.php" class="btn btn-danger">Logout</a>
          <a href="online.php" class="btn btn-info">Online Appointment</a>
        </div>
        <div class="row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <table id="example" class="table table-dark table-striped table-hover text-center">
              <thead>
                <th>ID</th>
                <th>Full Name</th>
                <th>Mobile</th>
                <th>Problem</th>
                <th>Apt_Date_Time</th>
                <th>Operations</th>
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
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  -->
  <script type="text/javascript">
    //fetch data
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
          'url': 'fetch_data.php',
          'type': 'post',
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [5]
          },

        ]
      });
    });

    //add data
    $(document).on('submit', '#addUser', function(e) {
      e.preventDefault();
      var date = $('#addDateField').val();
      var username = $('#addUserField').val();
      var mobile = $('#addMobileField').val();
      var problem = $('#addProblemField').val();
      if (date != '' && username != '' && mobile != '' && problem != '') {
        $.ajax({
          url: "add_user.php",
          type: "post",
          data: {
            date: date,
            username: username,
            mobile: mobile,
            problem: problem
          },
          success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'true') {
              mytable = $('#example').DataTable();
              mytable.draw();
              $('#addUserModal').modal('hide');
            } else {
              alert('failed');
            }
          }
        });
      } else {
        alert('Fill all the required fields');
      }
    });

    //update data
    $(document).on('submit', '#updateUser', function(e) {
      e.preventDefault();
      //var tr = $(this).closest('tr');
      var date = $('#dateField').val();
      var username = $('#nameField').val();
      var mobile = $('#mobileField').val();
      var problem = $('#problemField').val();
      var trid = $('#trid').val();
      var id = $('#id').val();
      if (date != '' && username != '' && mobile != '' && problem != '')
      {
        if (confirm("Confirm update ?"))
        {
        $.ajax({
          url: "update_user.php",
          type: "post",
          data: {
            date: date,
            username: username,
            mobile: mobile,
            problem: problem,
            id: id
          },
          success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'true') {
              table = $('#example').DataTable();
              // table.cell(parseInt(trid) - 1,0).data(id);
              // table.cell(parseInt(trid) - 1,1).data(username);
              // table.cell(parseInt(trid) - 1,2).data(mobile);
              // table.cell(parseInt(trid) - 1,3).data(problem);
              // table.cell(parseInt(trid) - 1,4).data(date);
              var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Update</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([id, username, mobile, problem, date, button]);
              $('#exampleModal').modal('hide');
            } else {
              alert('failed');
            }
          }
        });
      }
    } else {
        alert('Fill all the required fields');
      }
    });

    //get single data
    $('#example').on('click', '.editbtn ', function(event) {
      var table = $('#example').DataTable();
      var trid = $(this).closest('tr').attr('id');
      // console.log(selectedRow);
      var id = $(this).data('id');
      $('#exampleModal').modal('show');

      $.ajax({
        url: "get_single_data.php",
        data: {
          id: id
        },
        type: 'post',
        success: function(data) {
          var json = JSON.parse(data);
          $('#nameField').val(json.username);
          $('#problemField').val(json.problem);
          $('#mobileField').val(json.mobile);
          $('#dateField').val(json.date);
          $('#id').val(id);
          $('#trid').val(trid);
        }
      })
    });

    //delete data
    $(document).on('click', '.deleteBtn', function(event) {
      var table = $('#example').DataTable();
      event.preventDefault();
      var id = $(this).data('id');
      if (confirm("Confirm delete ?")) {
        $.ajax({
          url: "delete_user.php",
          data: {
            id: id
          },
          type: "post",
          success: function(data) {
            var json = JSON.parse(data);
            status = json.status;
            if (status == 'success') {
              //table.fnDeleteRow( table.$('#' + id)[0] );
              //$("#example tbody").find(id).remove();
              //table.row($(this).closest("tr")) .remove();
              $("#" + id).closest('tr').remove();
            } else {
              alert('Failed');
              return;
            }
          }
        });
      } else {
        return null;
      }



    })
  </script>
  <!-- Update Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateUser">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="trid" id="trid" value="">
            <div class="mb-3 row">
              <label for="nameField" class="col-md-3 form-label">Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="nameField" name="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="mobileField" class="col-md-3 form-label">Mobile</label>
              <div class="col-md-9">
                <input type="tel" class="form-control" id="mobileField" name="mobile">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="problemField" class="col-md-3 form-label">Problem</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="problemField" name="problem" placeholder="GEN,GYN,PAE,OPH,DER,ENT,PSY">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="dateField" class="col-md-3 form-label">Date</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="dateField" name="date">
              </div>
            </div>
            <hr>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Add user Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addUser" action="">
            <div class="mb-3 row">
              <label for="addUserField" class="col-md-3 form-label">Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addUserField" name="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addMobileField" class="col-md-3 form-label">Mobile</label>
              <div class="col-md-9">
                <input type="tel" class="form-control" id="addMobileField" name="mobile">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addProblemField" class="col-md-3 form-label">Problem</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addProblemField" name="problem" placeholder="GEN,GYN,PAE,OPH,DER,ENT,PSY">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addDateField" class="col-md-3 form-label">Date & Time</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addDateField" name="date" placeholder="YYYY-MM-DD HH:MM am/pm">
              </div>
            </div>
            <hr>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Add admin Modal -->
  <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="add_admin.php" method="post">
            <div class="mb-3 row">
              <label for="addUserField" class="col-md-3 form-label">UserName</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addUsernameField" name="username" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addPasswordField" class="col-md-3 form-label">Password</label>
              <div class="col-md-9"> 
              <i class="fa-solid fa-eye" id="eye"></i>
              <input type="password" class="form-control" id="addPasswordField" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" required>
                <script type="text/javascript">
                    const passwordInput = document.querySelector("#addPasswordField")
                    const eye = document.querySelector("#eye")
                    eye.addEventListener("click", function() {
                        this.classList.toggle("fa-eye-slash")
                        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
                        passwordInput.setAttribute("type", type)
                    })
                </script>
              </div>
            </div>
            <hr>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
</body>

</html>
<script type="text/javascript">
  //var table = $('#example').DataTable();
</script>
