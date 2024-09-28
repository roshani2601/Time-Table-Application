<?php
require ("../db_connect.php");

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   header('location:login.php');
   exit;
}

$query = "SELECT * FROM admin WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
   <header class="header">

      <section class="flex">

         <a href="index.php" class="logo">TimeTable</a>

         <!-- <form action="search.php" method="post" class="search-form">
            <input type="text" name="search_box" required placeholder="search courses..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
         </form> -->

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
         </div>

         <div class="profile">
            <img src="upload/<?= $user_data['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
            <h3 class="name"><?php echo ucwords($user_data['username']); ?></h3>
            <p class="role"><?php echo ucwords($user_data['type']); ?></p>
            <a href="view_profile.php" class="btn">view profile</a>
            <div class="flex-btn">
               <a href="../logout.php" class="option-btn">Logout</a>
            </div>
         </div>
      </section>

   </header>

   <div class="side-bar">

      <div id="close-btn">
         <i class="fas fa-times"></i>
      </div>

      <div class="profile">
         <img src="upload/<?= $user_data['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
         <h3 class="name"><?php echo ucwords($user_data['username']); ?></h3>
         <p class="role"><?php echo ucwords($user_data['type']); ?></p>
         <a href="view_profile.php" class="btn">view profile</a>
      </div>

      <nav class="navbar">
         <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>

         <div class="dropdown">
            <a><i class="fa-solid fa-list"></i><span>Academics</span>
               <div class="dropdown-content">
                  <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
                  <a href="semesters.php"><i class="fa-brands fa-stack-overflow"></i><span>Semesters</span></a>
                  <a href="subjects.php"><i class="fa-solid fa-book"></i><span>Subjects</span></a>
               </div>
            </a>
         </div>
         <a href="teachers.php"><i class="fa-solid fa-user-tie"></i><span>Teachers</span></a>
         <a href="Students.php"><i class="fa-solid fa-people-line"></i><span>Students</span></a>
         <a href="timetable.php"><i class="fa-solid fa-table"></i><span>TimeTable</span></a>
         <a href="user.php"><i class="fa-solid fa-users"></i><span>Users</span></a>
      </nav>

   </div>
</body>

</html>