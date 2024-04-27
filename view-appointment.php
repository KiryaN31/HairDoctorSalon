<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid'] == 0)) {
  header('location:logout.php');
} else {

  if (isset($_POST['submit'])) {

    $cid = $_GET['viewid'];
    $remark = $_POST['remark'];
    $status = ($_POST['status'] == 1 ? 'Pending' : ($_POST['status'] == 2 ? 'Approved' : 'Declined'));

    $appointment_query = mysqli_query($con, "SELECT * FROM tblappointment WHERE ID='$cid'");
    $appointment_row = mysqli_fetch_assoc($appointment_query);
    $email = $appointment_row['Email'];
    $name = $appointment_row['Name'];
    $aptno = $appointment_row['AptNumber'];

    if ($email) {
      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hannahsalon2023@gmail.com';
        $mail->Password = 'ibqbcvvalyurunnt';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('hairdoctorsalon@gmail.com', $name);
        $mail->addAddress($email, $name);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Appointment Status';

        $body = '<div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; color: #333; max-width: 600px; margin: auto; border-radius: 10px;">';
        $body .= '<h2 style="color: #007bff;">Client Welcome to Hair Doctor Salon</h2>';
        $body .= '<p>Your appointment status is: <strong>'.' ' . $status . '</strong> </p>';
        $body .= '<p style="color: #999;">Appointment #'.' '. $aptno .'</p>';
        $body .= '<p style="color: #999;">Remarks:'.' '. $remark .'</p>';
        $body .= '</div>';

        $mail->Body = $body;

        $mail->send();

        $query = mysqli_query($con, "update  tblappointment set Remark='$remark',Status='$status' where ID='$cid'");
        if ($query) {
          $msg = "All remark has been updated.";
        } else {
          $msg = "Something Went Wrong. Please try again";
        }
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

    } else {
      $msg = "Email not found for the appointment ID.";
    }
  }
?>
  <!DOCTYPE HTML>
  <html>

  <head>
    <title>RESERVEiT || View Appointment</title>

    <script type="application/x-javascript">
      addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
      }, false);

      function hideURLbar() {
        window.scrollTo(0, 1);
      }
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font CSS -->
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!--webfonts-->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
      new WOW().init();
    </script>
    <!--//end-animate-->
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
  </head>

  <body class="cbp-spmenu-push">
    <div class="main-content">
      <!--left-fixed -navigation-->
      <?php include_once('includes/sidebar.php'); ?>
      <!--left-fixed -navigation-->
      <!-- header-starts -->
      <?php include_once('includes/header.php'); ?>
      <!-- //header-ends -->
      <!-- main content start-->
      <div id="page-wrapper">
        <div class="main-page">
          <div class="tables">
            <h3 class="title1">View Appointment</h3>



            <div class="table-responsive bs-example widget-shadow">
              <p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
                                                                      echo $msg;
                                                                    }  ?> </p>
              <h4>View Appointment:</h4>
              <?php
              $cid = $_GET['viewid'];
              $ret = mysqli_query($con, "select * from tblappointment where ID='$cid'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($ret)) {

              ?>
                <table class="table table-bordered">
                  <tr>
                    <th>Appointment Number</th>
                    <td><?php echo $row['AptNumber']; ?></td>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td><?php echo $row['Name']; ?></td>
                  </tr>

                  <tr>
                    <th>Email</th>
                    <td><?php echo $row['Email']; ?></td>
                  </tr>
                  <tr>
                    <th>Mobile Number</th>
                    <td><?php echo $row['PhoneNumber']; ?></td>
                  </tr>
                  <tr>
                    <th>Appointment Date</th>
                    <td><?php echo $row['AptDate']; ?></td>
                  </tr>
                  <tr>
                    <th>Appointment Time</th>
                    <td><?php echo $row['AptTime']; ?></td>
                  </tr>


                  <tr>
                    <th>Services</th>
                    <td><?php echo $row['Services']; ?></td>
                  </tr>
                  <tr>
                    <th>Staff</th>
                    <td><?php echo $row['Staff']; ?></td>
                  </tr>
                  <tr>
                    <th>Down Payment</th>
                    <td><?php echo $row['dp']; ?></td>
                  </tr>
                  <tr>
                    <th>Reference Number</th>
                    <td><?php echo $row['refnum']; ?></td>
                  </tr>
                  <tr>
                    <th>Apply Date</th>
                    <td><?php echo $row['ApplyDate']; ?></td>
                  </tr>


                  <tr>
                    <th>Status</th>
                    <td> <?php
                          if ($row['Status'] == "Pending") {
                            echo "Pending";
                          }

                          if ($row['Status'] == "Approved") {
                            echo "Approved";
                          }
                          if ($row['Status'] == "Cancelled") {
                            echo "Cancelled";
                          }; ?></td>
                  </tr>
                </table>
                <table class="table table-bordered">
                  <?php if ($row['Remark'] == "") { ?>


                    <form name="submit" method="post" enctype="multipart/form-data">

                      <tr>
                        <th>Remark :</th>
                        <td>
                          <textarea name="remark" placeholder="" rows="12" cols="14" class="form-control wd-450" required="true"></textarea>
                        </td>
                      </tr>

                      <tr>
                        <th>Status :</th>
                        <td>
                          <select name="status" class="form-control wd-450" required="true">
                            <option value="1" selected="true">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Declined</option>
                          </select>
                        </td>
                      </tr>

                      <tr align="center">
                        <td colspan="2"><button type="submit" name="submit" class="btn btn-az-primary pd-x-20">Submit</button></td>
                      </tr>
                    </form>
                  <?php } else { ?>
                </table>
                <table class="table table-bordered">
                  <tr>
                    <th>Remark</th>
                    <td><?php echo $row['Remark']; ?></td>
                  </tr>


                  <tr>
                    <th>Remark date</th>
                    <td><?php echo $row['RemarkDate']; ?> </td>
                  </tr>

                </table>
              <?php } ?>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!--footer-->

      <!--//footer-->
    </div>
    <!-- Classie -->
    <script src="js/classie.js"></script>
    <script>
      var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

      showLeftPush.onclick = function() {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
      };

      function disableOther(button) {
        if (button !== 'showLeftPush') {
          classie.toggle(showLeftPush, 'disabled');
        }
      }
    </script>
    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
  </body>

  </html>
<?php }  ?>