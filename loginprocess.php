<?php
    session_start ();
    $cser=mysqli_connect("172.16.115.20","Highwook","Password1","HighWook") or die("connection failed:".mysqli_error());
    
    if(isset($_REQUEST['sub']))
    {
        $a = $_REQUEST['email'];
        $b = mysqli_real_escape_string($cser, $_POST['password']);
        $b = md5($b);
        $res = mysqli_query($cser,"select * from users where email='$a'and password='$b'");
        $recent = mysqli_query($cser,"UPDATE `users` SET `Recent`= now() WHERE email='$a'");
        $result=mysqli_fetch_array($res,$recent);
        if($result )
        {
            $_SESSION["id"]=$result["id"];
            $_SESSION["email"]=$a;
            header("location:index.php");
        }
        else
        {
            header("location:login.php?err=");
            
        }
    }
    ?>
