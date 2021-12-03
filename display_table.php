<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Query Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="width:80%;margin:3% 0 0 8%; background-color:#fbfaf0 !important;">

<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_management";

$conn = mysqli_connect($server, $username, $password, $dbname);

function displayStudentTable($query, $conn){
    $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
    echo "<table class = 'table table-striped table-bordered' style = 'border: 2px solid;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope = 'col'>Roll Number</th>";
    echo "<th scope = 'col'>Name</th>";
    echo "<th scope = 'col'>Branch</th>";
    echo "<th scope = 'col'>Semester</th>";
    echo "<th scope = 'col'>Email ID</th>";
    echo "<th scope = 'col'>Room Number</th>";
    echo "<th scope = 'col'>Hostel Number</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = mysqli_fetch_array($run)){
        echo "<tr>";
        echo "<th scope = 'row'>".$row['ROLL_NO']."</th>";
        echo "<td>".$row['FIRSTNAME']." ".$row['LASTNAME']."</td>";
        echo "<td>".$row['BRANCH']."</td>";
        echo "<td>".$row['SEM']."</td>";
        echo "<td>".$row['EMAIL_ID']."</td>";
        echo "<td>".$row['ROOM_ID']."</td>";
        echo "<td>".$row['HID']."</td>";
        echo "</tr>";
    }    
    echo "</tbody>";
    echo "</table>";
}

if(isset($_GET['ShowRoom'])){
    $showRoomsQuery = "SELECT * FROM Room ORDER BY Room_ID;";
    $run = mysqli_query($conn, $showRoomsQuery) or die(mysqli_error($conn));
    echo "<table class = 'table table-striped table-bordered' style = 'border: 2px solid;'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th scope = 'col'>Room Number</th>";
            echo "<th scope = 'col'>Hostel Number</th>";
            echo "<th scope = 'col'>Capacity</th>";
            echo "<th scope = 'col'>Room Type</th>";
            echo "<th scope = 'col'>Status</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
        while($row = mysqli_fetch_array($run)){
        echo "<tr>";
            echo "<th scope = 'row'>".$row['ROOM_ID']."</th>";
            echo "<td>".$row['HID']."</td>";
            echo "<td>".$row['CAPACITY']."</td>";
            echo "<td>".$row['ROOM_TYPE']."</td>";
            echo "<td>".$row['ROOM_STATUS']."</td>";
        echo "</tr>";
        }    
    echo "</body>";
    echo "</table>";
}

if(isset($_GET['ShowHostel'])){
    $showHostelQuery = "SELECT * FROM Hostel ORDER BY HID";
    $run1 = mysqli_query($conn, $showHostelQuery) or die(mysqli_error($conn));
    
    echo "<table class = 'table table-striped table-bordered' style = 'border: 2px solid;'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th scope = 'col'>Hostel Number</th>";
            echo "<th scope = 'col'>Hostel Name</th>";
            echo "<th scope = 'col'>Hostel Type</th>";
            echo "<th scope = 'col'>Number of Single Rooms</th>";
            echo "<th scope = 'col'>Number of Double Rooms</th>";
            echo "<th scope = 'col'>Number of Quadruple Rooms</th>";
            echo "<th scope = 'col'>Total Capacity</th>";
            echo "<th scope = 'col'>Meal Type</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
        while($row = mysqli_fetch_array($run1)){
         echo "<tr>";
            echo "<th scope = 'row'>".$row['HID']."</th>";
            echo "<td>".$row['HNAME']."</td>";
            echo "<td>".$row['HOSTEL_TYPE']."</td>";
            echo "<td>".$row['SINGLE_ROOM']."</td>";
            echo "<td>".$row['DOUBLE_ROOM']."</td>";
            echo "<td>".$row['QUAD_ROOM']."</td>";
            echo "<td>".$row['CAPACITY']."</td>";
            echo "<td>".$row['MEAL_TYPE']."</td>";
        echo "</tr>";
        }
    echo "</tbody>";
    echo "</table>";
}

if(isset($_GET['ShowStudent'])){
    $showStudentQuery = "SELECT * FROM Student ORDER BY Roll_No;";
    displayStudentTable($showStudentQuery, $conn);
}

if(isset($_GET['findStudent'])){
    $roomID = $_GET['roomID'];
    $hostelName = $_GET['hostelName'];

    if($roomID == NULL && $hostelName == NULL){
        echo "<strong>Enter Room ID or Hostel Name!!</strong>";
    }
    else{
        if($roomID != NULL){
            $findStudentQuery = "SELECT * FROM Student WHERE Room_ID = $roomID";
            displayStudentTable($findStudentQuery, $conn);
        }
        else{
            $findStudentQuery = "SELECT * FROM Student JOIN HOSTEL ON Student.HID = Hostel.HID WHERE HNAME = '$hostelName'";
            displayStudentTable($findStudentQuery, $conn);
        }
    }
}

if(isset($_GET['showBranch'])){
    $branch = $_GET['branch'];
    $sem = $_GET['sem'];

    if($branch == "NULL" && $sem == NULL){
        echo "<strong>Enter Branch or Semester!!</strong>";
    }
    else{
        if($branch != "NULL" && $sem != NULL){
            $showBranchQuery = "SELECT * FROM Student WHERE Branch = '$branch' AND Sem = $sem;";
            displayStudentTable($showBranchQuery, $conn);
        }
        else if($branch == "NULL"){
            $showBranchQuery = "SELECT * FROM Student WHERE Sem = $sem;";
            displayStudentTable($showBranchQuery, $conn);
        }
        else{
            $showBranchQuery = "SELECT * FROM Student WHERE Branch = '$branch'";
            displayStudentTable($showBranchQuery, $conn);
        }
    }
}

if(isset($_GET['findRNum'])){
    $name = $_GET['nameToFind'];
    $num = $_GET['numToFind'];
    $findRoomQuery = NULL;

    if($name == NULL && $num == NULL){
        echo "<strong>Enter Roll Number or Name!!</strong>";
    }
    else{
        if($num != NULL){
            $findRoomQuery = "SELECT * FROM Student JOIN Hostel ON Student.HID = Hostel.HID WHERE ROLL_NO = $num;";
        }
        else{
            $findRoomQuery = "SELECT * FROM Student JOIN Hostel ON Student.HID = Hostel.HID WHERE FIRSTNAME = '$name';";
        }

        $run = mysqli_query($conn, $findRoomQuery) or die(mysqli_error($conn));
        echo "<table class = 'table table-striped table-bordered' style = 'border: 2px solid;'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th scope = 'col'>Roll Number</th>";
                echo "<th scope = 'col'>Student Name</th>";
                echo "<th scope = 'col'>Branch</th>";
                echo "<th scope = 'col'>Hostel Name</th>";
                echo "<th scope = 'col'>Room Number</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
            while($row = mysqli_fetch_array($run)){
             echo "<tr>";
                echo "<td>".$row['ROLL_NO']."</td>";
                echo "<td>".$row['FIRSTNAME']." ".$row['LASTNAME']."</td>";
                echo "<td>".$row['BRANCH']." ".$row['SEM'];
                if($row['SEM'] == 3){
                    echo "rd Sem"."</td>";
                }
                else{
                    echo "th Sem"."</td>";
                }
                echo "<td>".$row['HNAME']."</td>";
                echo "<th scope = 'row'>".$row['ROOM_ID']."</th>";
            echo "</tr>";
            }
        echo "</tbody>";
        echo "</table>";
    }
}

if(isset($_GET['custom'])){
    $customQuery = $_GET['query'];
    if(!$customQuery){
        echo "<strong>Enter Query!!</strong>";
    }
    else{
        $run = mysqli_query($conn, $customQuery) or die(mysqli_error($conn));
        
        echo "<table class = 'table table-striped table-bordered' style = 'border: 2px solid; text-align: center;'>";
        echo "<tbody>";
        
        echo "Query Successful...";
        
        while($row = @mysqli_fetch_assoc($run)){
            echo "<tr>";
            foreach($row AS $value){
                echo "<td>".$value."</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}

?>
</body>
</html>