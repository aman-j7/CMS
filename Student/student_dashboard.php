<?php
include "../includes/config.php";
$res = mysqli_query($conn, "SELECT course_id FROM `teaches` WHERE faculty_id='f012'");
?>
<html>
<head>
  <title>
    Student Dashboard
  </title>
  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<section class="home">
<div class="container mt-4 ">
<h1 class="text-center pt-2 pb-2 text">
  DASHBOARD
</h1>
</div>
  <div class="container mt-2 ">
    <?php
    $c = 0;
    while ($row = mysqli_fetch_array($res)):
      if ($c % 3 == 0): ?>
        <div class="row">
        <?php endif;
        $c = $c + 1;
        $counter = $row['course_id'];
        $t = mysqli_query($conn, "SELECT `course_name` FROM `courses` where course_id='$counter'");
        $t = mysqli_fetch_array($t);
        $t = $t["course_name"]; ?>
        <div class="col-lg-4 mb-4 mt-4 ">
          <a href="../Courses/<?php echo $counter ?>.php?course=<?php echo $counter ?>&course_name=<?php echo $t ?>" style="color:black"> <!-- no need of course name -->
            <div class="card" >
              <img src="https://news.miami.edu/life/_assets/images/images-stories/2019/08/faculty-new-year-940x529.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title text-center"><?php echo $counter ?></h5>
              </a>
            </div>
          </div>
        </div>
        <?php if ($c % 3 == 0): ?>
        </div>
      <?php endif;
    endwhile;?>
</div>
</section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>