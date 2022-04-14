<?php
$time=time();
$row1=mysqli_query($conn,"select student.name from student inner JOIN login on login.reg_id=student.id  where login.islogin > $time");
$row2=mysqli_query($conn,"select teacher.name from teacher inner JOIN login on login.reg_id=teacher.id  where login.islogin > $time");
?>

<style>
  .modal_user {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    right: 0px;
}
.modal_user_content {
    height: 100%;
}
</style>
<div class="modal fade" id="onlineUser" role="dialog">
    <div class="modal-dialog modal_user">
      <div class="modal-content modal_user_content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto; text-align: left;" id="exampleModalLabel">Online Users</h5>
          <button type="button" class="btn-close btn-sm btn-close-white" aria-label="Close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
        <?php
        while($res = mysqli_fetch_array($row1)){
          echo $res['name'].'</br>';
        }
        while($res = mysqli_fetch_array($row2)){
          echo $res['name'].'</br>';}
        ?>
      </div>
    </div>
  </div>
</div>
 <nav class="sidebar close">
 <header>

   <div class="image-text">
     <span class="image">
       <img src="../images/L_logo.png" alt="logo">
     </span>

     <div class="text logo-text">
       <span class="name">Next Gen</span>
       <span class="profession">Learning</span>
     </div>
   </div>

   <i class='bx bx-chevron-right toggle'></i>
 </header>

 <div class="menu-bar">
   <div class="menu">
     <li class="">
       <a href="../includes/profile.php">
         <i class='bx bx-home-alt icon'></i>
         <span class="text nav-text">Home</span>
       </a>
     </li>
   </div>
   <div class="menu">
     <li class="">
     <a href="#" data-bs-toggle="modal" data-bs-target="#onlineUser" style="color:black">
         <i class='bx bx-home-alt icon'></i>
         <span class="text nav-text">update</span>
       </a>
     </li>
   </div>

   <div class="bottom-content">
     <li class="">
       <a href="../includes/logout.php">
         <i class='bx bx-log-out icon'></i>
         <span class="text nav-text">Logout</span>
</a>
     </li>

     <li class="mode">
       <div class="sun-moon">
         <i class='bx bx-moon icon moon'></i>
         <i class='bx bx-sun icon sun'></i>
       </div>
       <span class="mode-text text">Dark mode</span>

       <div class="toggle-switch">
         <span class="switch"></span>
       </div>
     </li>

   </div>
 </div>

</nav>
