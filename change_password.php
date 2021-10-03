<?php
include"config.php";
?>
<html>
<head>
    <title>FORM</title>
</head>
<body>
<h2>Please Enter Your Details</h2>
<form method="POST" action="login.php">
<table  align="center"  cellspacing=" 25">
    <tr>
        <th>Registration No</th>
        <td><input type="integer" placeholder="Mail@gmail.com"  name="id" required></td>
    </tr>
    <tr>
        <th>Password</th>
        <td><input type="Password" name="password" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input id="submit" type="submit"  value="Login" name="submit"></td>
        <td><a href="forget.php">Forget Password ? </a></td>
    </tr>
</table>
</form>
</body>
</html>