<!DOCTYPE html>
<html>
<head>
<title>QR Attendance System</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
text-align:center;
padding-top:80px;
}

.box{
background:white;
width:350px;
margin:auto;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px #ccc;
}

h2{
margin-bottom:20px;
}

button{
padding:12px;
background:#007bff;
color:white;
border:none;
cursor:pointer;
width:90%;
margin:10px;
font-size:16px;
}

button:hover{
background:#0056b3;
}

.student{
background:#28a745;
}

.teacher{
background:#007bff;
}

.admin{
background:#6c757d;
}

</style>

</head>

<body>

<div class="box">

<h2>QR Attendance System</h2>

<button class="student" onclick="goStudent()">👨‍🎓 Student Login</button>

<button class="teacher" onclick="goTeacher()">👨‍🏫 Teacher Login</button>

<button class="admin" onclick="goAdmin()">🛠 Admin Login</button>

</div>

<script>

function goStudent(){
window.location="student_login.php";
}

function goTeacher(){
window.location="teacher_login.php";
}

function goAdmin(){
window.location="admin_login.php";
}

</script>

</body>
</html>