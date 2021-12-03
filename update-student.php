<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Update Details</title>
  <link rel="stylesheet" href="css/update-page.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Nunito:wght@400;600;700&family=Outfit:wght@400;500;600&display=swap"
    rel="stylesheet">
</head>

<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_management";

$conn = mysqli_connect($server, $username, $password, $dbname);
?>

<body style="font-family: 'Outfit', sans-serif;">
  <ul class="nav nav-tabs" style="height:70px;padding-top:14px;padding-bottom:20px;">
    <li class="nav-item">
      <a class="nav-link active" id="first" aria-current="page" href="#">Add Student</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="second" href="#second" id="first">Delete Record</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="third" href="#third">Update Record</a>
    </li>
  </ul>


<div class="row">
  <div class="col-lg-5" style="padding:0;">
    <img src="images/student.jpg" alt="" style="padding:0;width:100%;">
  </div>
  <div class="col-lg-7 shadow" style="padding:2%; background-color:#f6f8e8;">
    <div id="first-div" style="padding:3% 3% 7% 3%; border:2px solid black; border-radius:5px;">
      <form class="" action="update-student.php" method="get">
        <h2>Personal Details</h2>
        <input type="text" placeholder="First Name"
        style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
        name="fName" value="" required>
        <input type="text" placeholder="Last Name"
        style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="lName" value=""
        required>
        <input type="number" placeholder="Roll Number"
        style="display:inline-block;width:44%;padding:7px;  margin:10px 0; margin-right:60px; border-radius : 5px;"
        name="rNum" value="" required>
        <input type="text" placeholder="Semester"
        style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="sem" value=""
        required>
        <input type="email" placeholder="Email ID"
        style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
        name="email" value="" required>
        <select name="branch" id="" placeholder="Branch"
        style="display:inline-block;width:44%;padding:7px; margin:10px 0; border-radius : 5px; " required>
        <option value="NULL">Branch</option>
        <option value="IT">IT</option>
        <option value="CSE">CSE</option>
        <option value="ME">ME</option>
        <option value="IPE">IPE</option>
        <option value="CE">CE</option>
      </select>
      <br><br>
      <h2>Hostel Details</h2>
      <input type="number" placeholder="Hostel ID"
      style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
      name="HID" value="" required>
      <input type="number" placeholder="Room ID"
      style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="RID" value=""
      required>
      
      <div class="" style="text-align:right; padding-right:4%;">
        <button type="submit" name="Insert" style="width:20%; padding:8px; border-radius:10px; margin-top:40px;">Add
          New Student</button>
          
        </div>
      </form>
    </div>
    
    <?php
      if(isset($_GET['Insert'])){
        $rollNumber = $_GET['rNum'];
        $firstname = $_GET['fName'];
        $lastname = $_GET['lName'];
        $branch = $_GET['branch'];
        $semester = $_GET['sem'];
        $email = $_GET['email'];
        $hostelID = $_GET['HID'];
        $roomID = $_GET['RID'];
        
        $conditionQuery1 = "SELECT COUNT(*) AS Total FROM Student WHERE Roll_No = $rollNumber;";
        $run2 = mysqli_query($conn, $conditionQuery1) or die(mysqli_error($conn));
        $count = mysqli_fetch_assoc($run2);
        
        $conditionQuery2 = "SELECT COUNT(*) AS Num FROM Student WHERE Room_ID = $roomID;";
        $run3 = mysqli_query($conn, $conditionQuery2) or die(mysqli_error($conn));
        $num = mysqli_fetch_assoc($run3);
        
        $conditionQuery3 = "SELECT Capacity AS Cap FROM Room WHERE Room_ID = $roomID;";
        $run4 = mysqli_query($conn, $conditionQuery3) or die(mysqli_error($conn));
        $limit = mysqli_fetch_assoc($run4);
        if($count['Total'] > 0){
          echo "Roll Number Already Exists!!";
        }
        else if($num['Num'] == $limit['Cap']){
          echo "Room Already Full";
        }
        else{
          $roomUpdateQuery = "UPDATE Room SET Room_Status = 'Occupied' WHERE Room_ID = $roomID;";
          $run1 = mysqli_query($conn, $roomUpdateQuery) or die(mysqli_error($conn));
          if(!$run1){
            echo "Failed to insert data";
          }
          else{
            $insertQuery = "INSERT INTO Student VALUES ($rollNumber, '$firstname', '$lastname', '$branch', '$email', $semester, $roomID, $hostelID);";
            $run = mysqli_query($conn, $insertQuery) or die(mysqli_error($conn));
            echo "Data entered successfully";
          }        
        }
      }
      
  if(isset($_GET['Delete'])){
    $rollNumber = $_GET['rNum'];
    $firstname = $_GET['fName'];
    $lastname = $_GET['lName'];
    $email = $_GET['email'];
        
    
    $conditionQuery = "SELECT COUNT(*) AS Total FROM Student WHERE Room_ID = (SELECT Room_ID FROM Student WHERE ROLL_NO = $rollNumber);";
    $run = mysqli_query($conn, $conditionQuery) or die(mysqli_error($conn));
    $count = mysqli_fetch_assoc($run);
    
    if($count['Total'] == 0){
      echo "Student Does Not Exist!!";
    }
    else{
      if($count['Total'] == 1){
        $roomUpdateQuery = "UPDATE Room SET Room_Status = 'Vacant' WHERE Room_ID = (SELECT Room_ID FROM Student WHERE ROLL_NO = $rollNumber);";
        $run2 = mysqli_query($conn, $roomUpdateQuery) or die(mysqli_error($conn));
      }
      
      $deleteQuery = "DELETE FROM Student WHERE ROLL_NO = $rollNumber;";
      $run1 = mysqli_query($conn, $deleteQuery) or die(mysqli_error($conn));

      if($run1){
        echo "Data deleted successfully";
      }
      else{
        echo "Failed to delete data";
      }
    }
  }

  if(isset($_GET['Update'])){
    $rollNumber = $_GET['rNum'];        
    $branch = $_GET['branch'];
    $semester = $_GET['sem'];
    $email = $_GET['email'];
    $hostelID = $_GET['HID'];
    $roomID = $_GET['RID'];

    $conditionQuery1 = "SELECT COUNT(*) AS Total FROM Student WHERE Roll_No = $rollNumber;";
    $run1 = mysqli_query($conn, $conditionQuery1) or die(mysqli_error($conn));
    $count = mysqli_fetch_assoc($run1);
    if($count['Total'] == 0){
      echo "Roll Number Does Not Exist!!";
      echo "<br>";
    }
    else{
      if($branch){
        $query = "UPDATE Student SET Branch = '$branch' WHERE Roll_No = $rollNumber;";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
      if($semester){
        $query = "UPDATE Student SET Sem = $semester WHERE Roll_No = $rollNumber;";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
      if($email){
        $query = "UPDATE Student SET email_ID = '$email' WHERE Roll_No = $rollNumber;";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
      if($roomID){
        $conditionQuery2 = "SELECT COUNT(*) AS Num FROM Student WHERE Room_ID = $roomID;";
        $run3 = mysqli_query($conn, $conditionQuery2) or die(mysqli_error($conn));
        $num = mysqli_fetch_assoc($run3);
        
        $conditionQuery3 = "SELECT Capacity AS Cap FROM Room WHERE Room_ID = $roomID;";
        $run4 = mysqli_query($conn, $conditionQuery3) or die(mysqli_error($conn));
        $limit = mysqli_fetch_assoc($run4);

        if($num['Num'] == $limit['Cap']){
          echo "Room Already Full";
        }
        else{
          $query3 = "SELECT COUNT(*) AS Total FROM Student WHERE Room_ID = (SELECT Room_ID FROM Student WHERE Roll_No = $rollNumber);";
          $run3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));
          $count = mysqli_fetch_assoc($run3);
          if($count['Total'] == 1){
            $roomUpdateQuery = "UPDATE Room SET Room_Status = 'Vacant' WHERE Room_ID = (SELECT Room_ID FROM Student WHERE ROLL_NO = $rollNumber);";
            $run2 = mysqli_query($conn, $roomUpdateQuery) or die(mysqli_error($conn));
          }

          $query1 = "UPDATE Student SET Room_ID = $roomID WHERE Roll_No = $rollNumber;";
          $run1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
          
          $query2 = "UPDATE Room SET Room_Status = 'Occupied' WHERE Room_ID = $roomID;";
          $run2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

          if($hostelID){
            $query3 = "UPDATE Student SET HID = $hostelID WHERE Roll_No = $rollNumber;";
            $run3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));
          }
        }
      }
      echo "Data Updated Successfully";
    }
  }
?> 
      
      <div id="second-div" style="padding:3% 3% 7% 3%; border:2px solid black; border-radius:5px;" class="invisible">
        <form class="" action="update-student.php" method="get">
          <h2>Enter Details</h2>
          <input type="number" placeholder="Roll Number"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
            name="rNum" value="" required>
          <input type="email" placeholder="Email"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="email" value="">

          <input type="text" placeholder="First Number"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
            name="fName" value="">
          <input type="text" placeholder="Last Name"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="lName" value="">

          <div class="" style="text-align:right; padding-right:4%;">
            <button type="submit" name="Delete" style="width:24%; padding:8px; border-radius:10px; margin-top:40px;">Delete
              Student Record</button>

          </div>
        </form>
      </div>
      
      
      
      
      <div id="third-div" style="padding:5% 3% 7% 3%; border:2px solid black; border-radius:5px;" class="invisible">
        <form class="" action="update-student.php" method="get">
          <h4>Roll Number</h4>
          <input type="number" placeholder="Roll Number"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
            name="rNum" value="" required>
          <br><br>
          <h5>Enter fields to be updated:</h5>
          <input type="number" placeholder="Room Number"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
            name="RID" value="">
          <input type="number" placeholder="Hostel Number"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="HID" value="">
          <input type="number" placeholder="Semester"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; margin-right:60px; border-radius : 5px;"
            name="sem" value="">
          <select name="branch" id="" placeholder="Branch"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0; border-radius : 5px; " required>
              <option value="NULL">Branch</option>
              <option value="IT">IT</option>
              <option value="CSE">CSE</option>
              <option value="ME">ME</option>
              <option value="IPE">IPE</option>
              <option value="CE">CE</option>
          </select>
            <input type="email" placeholder="E-Mail"
            style="display:inline-block;width:44%;padding:7px; margin:10px 0;  border-radius : 5px;" name="email" value="">
          <div class="" style="text-align:right; padding-right:4%;">
            <button type="submit" name="Update" style="width:28%; padding:8px; border-radius:10px; margin-top:40px;">Update
              Student Record</button>

          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/update-page.js">

  </script>
</body>

</html>