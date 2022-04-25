<?php
include "../includes/config.php";
$course=$_POST['course'];
$row = mysqli_query($conn, "SELECT `header`, `assigment`,`upload` FROM `$course`");
$html="";
while ($res = mysqli_fetch_array($row)) :
    if ($res['assigment'] != NULL) :           
        $html.=$res['header'].'</br>'.
         '<a href="'.$res['assigment'].'">Assignment<a></br>'.
                '<a href="'.$res['upload'].'">Submission<a></br>'; 
     endif;
endwhile;
echo $html;
?>