<?php
session_start();
include "db.php";

if(!isset($_SESSION['teacher_email'])){
    header("Location: teacher_login.php");
    exit();
}

// TIME SLOTS
$slots = [
"10:30-11:30",
"11:30-12:30",
"12:30-01:30",
"02:00-03:00",
"03:00-04:00",
"04:00-05:00"
];

$session = null; // IMPORTANT

// CREATE SESSION
if(isset($_POST['create_session'])){

$subject = $_POST['subject'];
$department = $_POST['department'];
$session_time = $_POST['session_time'];

// insert session
mysqli_query($conn,"INSERT INTO sessions(subject,department,session_time) VALUES('$subject','$department','$session_time')");
$session_id = mysqli_insert_id($conn);

// OTP + expiry (15 min)
$expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

$students = mysqli_query($conn,"SELECT * FROM students WHERE department='$department'");
while($stu=mysqli_fetch_assoc($students)){
    $otp = rand(100000,999999);
    mysqli_query($conn,"UPDATE students SET otp='$otp', otp_expiry='$expiry' WHERE email='".$stu['email']."'");
}

// 👉 अभी create हुआ session ही fetch करो
$session = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM sessions WHERE id='$session_id'"));

echo "<script>alert('Session Created');</script>";
}

// ATTENDANCE
$attendance = mysqli_query($conn,"
SELECT a.*, s.subject 
FROM attendance a 
JOIN sessions s ON s.id=a.session_id
ORDER BY a.time DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>

<style>
body{margin:0;font-family:Arial;display:flex;background:#f4f6f8;}
.sidebar{width:220px;background:#34495e;color:white;height:100vh;position:fixed;}
.sidebar h2{text-align:center;padding:20px;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;cursor:pointer;}
.sidebar a:hover{background:#2c3e50;}

.main{margin-left:220px;padding:20px;width:100%;}

.card{background:white;padding:20px;margin-bottom:20px;border-radius:10px;box-shadow:0 0 10px #ccc;}

button{padding:10px;background:#3498db;color:white;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#2980b9;}

input,select{width:90%;padding:10px;margin:10px;}
</style>

</head>

<body>

<div class="sidebar">
<h2>Teacher Panel</h2>

<a onclick="show('home')">Home</a>
<a onclick="show('create')">Create Session</a>
<a onclick="show('qr')">Generate QR</a>
<a onclick="show('view')">View Attendance</a>
<a href="logout.php">Logout</a>

</div>

<div class="main">

<!-- HOME -->
<div id="home" class="card">
<h2>Welcome Teacher</h2>
</div>

<!-- CREATE SESSION -->
<div id="create" class="card" style="display:none;">
<h2>Create Session</h2>

<form method="POST">
<input type="text" name="subject" placeholder="Subject" required>

<select name="department">
<option value="CSE">CSE</option>
<option value="ET">ET</option>
<option value="ME">ME</option>
</select>

<select name="session_time">
<?php foreach($slots as $s){ echo "<option>$s</option>"; } ?>
</select>

<button name="create_session">Create Session</button>
</form>

</div>

<!-- QR GENERATE -->
<div id="qr" class="card" style="display:none;">
<h2>QR Code</h2>

<?php if(isset($session) && $session != null){ ?>

<p><b>Subject:</b> <?php echo $session['subject']; ?></p>
<p><b>Dept:</b> <?php echo $session['department']; ?></p>
<p><b>Time:</b> <?php echo $session['session_time']; ?></p>

<?php
$link = "http://YOUR_PC_IP/qr-attendance/student_dashboard.php?session=".$session['id'];
?>

<p>Link:</p>
<input type="text" value="<?php echo $link; ?>">

<p>QR:</p>
<img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($link); ?>&size=150x150">

<p id="timer" style="color:red;font-weight:bold;"></p>

<?php } else { ?>
<p style="color:red;">No session created yet</p>
<?php } ?>

</div>

<!-- ATTENDANCE -->
<div id="view" class="card" style="display:none;">
<h2>Attendance</h2>

<table border="1" width="100%">
<tr>
<th>Name</th>
<th>Roll</th>
<th>Dept</th>
<th>Subject</th>
<th>Time</th>
</tr>

<?php while($row=mysqli_fetch_assoc($attendance)){ ?>
<tr>
<td><?php echo $row['student_name']; ?></td>
<td><?php echo $row['roll_number']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['time']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

<script>

// NAVIGATION
function show(id){

document.getElementById('home').style.display='none';
document.getElementById('create').style.display='none';
document.getElementById('qr').style.display='none';
document.getElementById('view').style.display='none';

document.getElementById(id).style.display='block';
}

// DEFAULT
show('home');

// TIMER (15 min)
let timeLeft = 900;

let timer = setInterval(function(){

let min = Math.floor(timeLeft/60);
let sec = timeLeft%60;

if(document.getElementById("timer")){
document.getElementById("timer").innerHTML =
"QR Expiry: " + min + "m " + sec + "s";
}

timeLeft--;

if(timeLeft < 0){
clearInterval(timer);
if(document.getElementById("timer")){
document.getElementById("timer").innerHTML = "QR Expired";
}
}

},1000);

</script>

</body>
</html>