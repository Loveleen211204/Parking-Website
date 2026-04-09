<?php
session_start();
include "db.php";
date_default_timezone_set("Asia/Kolkata");  //Timing 

/* ---------------- SECURITY CHECK ---------------- */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "Student"){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id'];

/* ---------------- PROFILE UPDATE ---------------- */
if(isset($_POST['update_profile'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $rollno = $_POST['rollno'];
    $course = $_POST['course'];
    $vehicle = $_POST['vehicle'];
    $vehicle_type = $_POST['vehicle_type'];

    mysqli_query($conn,"UPDATE users SET 
        name='$name',
        email='$email',
        rollno='$rollno',
        course='$course',
        vehicle='$vehicle',
        vehicle_type='$vehicle_type'
        WHERE id='$id'");

    $activePage = "profile";  // Stay on profile page
}

/* ---------------- MARK ENTRY ---------------- */
if(isset($_POST['mark_entry'])){
    $time = date("H:i:s");
    mysqli_query($conn,"INSERT INTO parking_history (user_id, entry_time) 
                VALUES ('$id', NOW())");

    $activePage = "history";
}

/* ---------------- MARK EXIT ---------------- */
if(isset($_POST['mark_exit'])){
    $time = date("H:i:s");
    mysqli_query($conn,"UPDATE parking_history 
                   SET exit_time = NOW()
                    WHERE user_id='$id' 
                    AND exit_time IS NULL
                    ORDER BY id DESC LIMIT 1");
    $activePage = "history";
}

/* ---------------- FETCH USER ---------------- */
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($result);
?>
<?php
if(!isset($activePage)){
    $activePage = "dashboard";
}
?>

<html>
<head>
<title>Student Dashboard</title>
<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f1f3f6;
}

.container{
    display:flex;
    height:100vh;
}

/* Sidebar */
.sidebar{
    width:250px;
    background:linear-gradient(180deg,#800000,#5a0000);
    color:white;
    padding:20px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
}

.sidebar button{
    width:100%;
    padding:12px;
    margin:8px 0;
    border:none;
    background:white;
    color:#800000;
    font-weight:600;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

.sidebar button:hover{
    background:#ffdede;
}

/* Content */
.content{
    flex:1;
    padding:30px;
    overflow-y:auto;
}

/* Card */
.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:25px;
}

/* Badge */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    color:white;
}

.areaA{ background:#28a745; }
.areaB{ background:#007bff; }
.notAssigned{ background:gray; }

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th{
    background:#002147;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
}

tr:nth-child(even){
    background:#f9f9f9;
}

/* Fade Animation */
.page{
    display:none;
    opacity:0;
    transform:translateY(10px);
    transition:0.4s ease;
}

.page.active{
    display:block;
    opacity:1;
    transform:translateY(0);
}
input, select{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    margin-top:5px;
}

button{
    padding:10px 18px;
    background:#800000;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#5a0000;
}

</style>
</head>
<body>
<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2><?= $user['name'] ?></h2>
    <button onclick="showPage('dashboard')">Dashboard</button>
    <button onclick="showPage('profile')">Edit Profile</button>
    <button onclick="showPage('history')">Entry & Exit</button>
    <button onclick="window.location='logout.php'">Logout</button>
</div>

<!-- CONTENT -->
<div class="content">

<!-- DASHBOARD -->
<div id="dashboard" class="page">
    <h2>Welcome, <?= $user['name'] ?> 👋</h2>

    <div class="card">
        <h3>Student Profile</h3>
        <p><strong>Roll No:</strong> <?= $user['rollno'] ?></p>
        <p><strong>Course:</strong> <?= $user['course'] ?></p>
        <p><strong>Email:</strong> <?= $user['email'] ?></p>
        <p><strong>Vehicle:</strong> <?= $user['vehicle'] ?: "Not Registered" ?></p>
        <p><strong>Vehicle Type:</strong> <?= $user['vehicle_type'] ?: "Not Selected" ?></p>

        <p><strong>Parking Area:</strong>
        <?php
        if($user['vehicle_type']=="Two Wheeler"){
            echo "<span class='badge areaA'>Area A - Two Wheeler Zone</span>";
        }
        elseif($user['vehicle_type']=="Four Wheeler"){
            echo "<span class='badge areaB'>Area B - Four Wheeler Zone</span>";
        }
        else{
            echo "<span class='badge notAssigned'>Not Assigned</span>";
        }
        ?>
        </p>
    </div>
</div>

<!-- PROFILE UPDATE -->
<div id="profile" class="page">
    <h2>Edit Profile Information</h2>
    <div class="card">
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= $user['name'] ?>" required>
        <br><br>
        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required>
        <br><br>
        <label>Roll Number</label>
        <input type="text" name="rollno" value="<?= $user['rollno'] ?>" required>
        <br><br>
        <label>Course</label>
        <input type="text" name="course" value="<?= $user['course'] ?>" required>
        <br><br>
        <label>Vehicle Number</label>
        <input type="text" name="vehicle" value="<?= $user['vehicle'] ?>">
        <br><br>
        <label>Vehicle Type</label>
        <select name="vehicle_type">
            <option value="">Select Type</option>
            <option value="Two Wheeler" <?= ($user['vehicle_type']=="Two Wheeler")?'selected':'' ?>>Two Wheeler</option>
            <option value="Four Wheeler" <?= ($user['vehicle_type']=="Four Wheeler")?'selected':'' ?>>Four Wheeler</option>
        </select>
        <br><br>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
    </div>
</div>

<!-- HISTORY -->
 <div id="history" class="page">
    <h2>Entry & Exit History</h2>
    <div class="card">
        <form method="POST" style="display:inline;">
            <button name="mark_entry">Mark Entry</button>
        </form>
        <form method="POST" style="display:inline;">
            <button name="mark_exit">Mark Exit</button>
        </form>
        <br><br>
        <table>
            <tr>
                <th>Date</th>
                <th>Entry Time</th>
                <th>Exit Time</th>
                <th>Status</th>
            </tr>
           <?php
                $history = mysqli_query($conn,"SELECT * FROM parking_history 
                            WHERE user_id='$id' 
                            AND entry_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                            ORDER BY id DESC");
                if(mysqli_num_rows($history) > 0){
                        while($row = mysqli_fetch_assoc($history)){
                             $date  = date("d M Y", strtotime($row['entry_time']));
                             $entry = $row['entry_time'] ? date("h:i A", strtotime($row['entry_time'])) : "-";
                             $exit  = $row['exit_time']  ? date("h:i A", strtotime($row['exit_time']))  : "-";
                        if($row['exit_time'] == NULL){
                             $status = "<span style='color:green;font-weight:bold;'>Inside Parking</span>";
                        } else {
                             $status = "<span style='color:red;font-weight:bold;'>Exited</span>";
                        }
                         echo "<tr>
                           <td>$date</td>
                           <td>$entry</td>
                           <td>$exit</td>
                           <td>$status</td>
                         </tr>";
                        } 
                } else {
                 echo "<tr>
                   <td colspan='4' style='text-align:center; padding:20px; color:gray;'>
                   🚫 No parking history yet<br>
                   <small>Click 'Mark Entry' to start</small>
                   </td>
                 </tr>";
                }
            ?>
        </table>
    </div>
  </div>
</div>
</div>

<script>
function showPage(page){
    document.querySelectorAll(".page").forEach(p=>{
        p.classList.remove("active");
    });
    document.getElementById(page).classList.add("active");
}
window.onload = function(){
    showPage("<?= $activePage ?>");
}
</script>
</body>
</html>