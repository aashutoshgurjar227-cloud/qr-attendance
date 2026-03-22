<?php
session_start();
include "db.php";

// LOGIN CHECK
if(!isset($_SESSION['student_email'])){
    header("Location: student_login.php");
    exit();
}

$email = $_SESSION['student_email'];

// FETCH STUDENT
$student_query = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");
$student = mysqli_fetch_assoc($student_query);

// अगर student नहीं मिला तो logout
if(!$student){
    session_destroy();
    header("Location: student_login.php");
    exit();
}

// MARK ATTENDANCE POST HANDLER
if(isset($_POST['mark'])){
    $session_id = $_POST['session_id'];
    $otp = $_POST['otp'];
    $now = date("Y-m-d H:i:s");

    // OTP Validation
    $check = mysqli_query($conn,"
        SELECT * FROM students 
        WHERE email='$email' 
        AND otp='$otp' 
        AND otp_expiry > '$now'
    ");

    if(mysqli_num_rows($check)>0){

        // Already marked check
        $already = mysqli_query($conn,"
            SELECT * FROM attendance 
            WHERE student_id='".$student['id']."' 
            AND session_id='$session_id'
        ");

        if(mysqli_num_rows($already)==0){

            mysqli_query($conn,"
                INSERT INTO attendance(student_id,session_id,student_name,roll_number,department,time)
                VALUES('".$student['id']."','$session_id','".$student['name']."','".$student['roll_number']."','".$student['department']."',NOW())
            ");

            echo "<script>alert('Attendance Marked Successfully');</script>";

        }else{
            echo "<script>alert('Already Marked');</script>";
        }

    }else{
        echo "<script>alert('Invalid or Expired OTP');</script>";
    }
}

// FETCH ATTENDANCE
$attendance_query = mysqli_query($conn,"
SELECT a.*, s.subject, s.session_time, s.department 
FROM attendance a
JOIN sessions s ON a.session_id=s.id
WHERE a.student_id='".$student['id']."'
ORDER BY a.time DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.7/html5-qrcode.min.js"></script>

<style>
body{margin:0;font-family:Arial;display:flex;background:#f4f6f8;}
.sidebar{width:220px;background:#2c3e50;color:white;height:100vh;position:fixed;top:0;left:0;}
.sidebar h2{text-align:center;padding:20px;margin:0;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;cursor:pointer;}
.sidebar a:hover{background:#1abc9c;}
.main{margin-left:220px;padding:20px;width:100%;}
.card{background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px #ccc;margin-bottom:20px;}
button{padding:10px;background:#3498db;color:white;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#2980b9;}
#reader{margin-top:20px;width:100%;max-width:400px;}
input{padding:10px;width:90%;margin-top:10px;border-radius:5px;}
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{padding:10px;border:1px solid #ddd;text-align:center;}
th{background:#2c3e50;color:white;}
</style>
</head>
<body>

<div class="sidebar">
<h2>Student Panel</h2>
<a onclick="showSection('home')">Home</a>
<a onclick="showSection('profile')">Profile</a>
<a onclick="showSection('mark')">Mark Attendance</a>
<a onclick="showSection('view')">View Attendance</a>
<a href="logout.php">Logout</a>
</div>

<div class="main">

<!-- HOME -->
<div id="home" class="card">
<h2>Welcome <?php echo $student['name']; ?></h2>
<p>Use the sidebar to navigate and mark attendance.</p>
</div>

<!-- PROFILE -->
<div id="profile" class="card" style="display:none;">
<h2>Profile</h2>
<p><b>Name:</b> <?php echo $student['name']; ?></p>
<p><b>Roll:</b> <?php echo $student['roll_number']; ?></p>
<p><b>Department:</b> <?php echo $student['department']; ?></p>
</div>

<!-- MARK ATTENDANCE -->
<div id="mark" class="card" style="display:none;">
<h2>Mark Attendance</h2>

<button onclick="startQR()">Scan QR & Mark Attendance</button>
<div id="reader"></div>

<form method="POST" id="otpBox" style="display:none;">
<input type="hidden" name="session_id" id="session_id">

<p><b>Name:</b> <?php echo $student['name']; ?></p>
<p><b>Roll:</b> <?php echo $student['roll_number']; ?></p>
<p><b>Department:</b> <?php echo $student['department']; ?></p>

<input type="text" name="otp" placeholder="Enter OTP" required>
<br><br>
<button name="mark">Submit Attendance</button>
</form>
</div>

<!-- VIEW ATTENDANCE -->
<div id="view" class="card" style="display:none;">
<h2>Attendance Records</h2>
<table>
<tr>
<th>Subject</th><th>Department</th><th>Time</th><th>Date</th>
</tr>
<?php while($row=mysqli_fetch_assoc($attendance_query)){ ?>
<tr>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['session_time']; ?></td>
<td><?php echo $row['time']; ?></td>
</tr>
<?php } ?>
</table>
</div>

</div>

<script>
function showSection(id){
document.getElementById('home').style.display='none';
document.getElementById('profile').style.display='none';
document.getElementById('mark').style.display='none';
document.getElementById('view').style.display='none';
document.getElementById(id).style.display='block';
}
showSection('home');

function startQR(){
let html5QrCode = new Html5Qrcode("reader");
html5QrCode.start(
{ facingMode: "environment" },
{ fps:10, qrbox:250 },
(qrCodeMessage)=>{
alert("QR Scanned: "+qrCodeMessage);
html5QrCode.stop();
document.getElementById('otpBox').style.display='block';
document.getElementById('session_id').value = qrCodeMessage.split("session=")[1]; // Extract session id from QR link
},
(error)=>{}
).catch(err=>{
alert("Camera not found or permission denied. Use a device with camera.");
});
}
</script>

</body>
</html>