<?php
    
    $connection = mysqli_connect('anightabovethemall.com.mysql.service.one.com', 'anightabovethemall_comhighbook', 'Password1');
    if(!$connection){
        die("Database Connection Failed" . mysqli_error($connection));
    }
    $selectdb = mysqli_select_db($connection, 'anightabovethemall_comhighbook');
    if(!$selectdb){
        die("Database Selection Failed" . mysqli_error($connection));
    }

    if(isset($_GET['action'])) {
        $sql = "";

        if($_GET['action'] == 0) {
            $sql = "UPDATE friends SET friend = 'accepted' WHERE 
            userid=".$_GET['friendID']." AND friendID=".$_GET['userid']." AND friend='waiting';";
        }

        if($_GET['action'] == 1) {
            $sql = "DELETE FROM friends WHERE userid=".$_GET['friendID']." AND friendID=".$_GET['userid'].";";
        }

        
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){

        }

    } else {
        $search = $_GET['search'];
        $sql = "SELECT * FROM users WHERE first_name LIKE '$search%' LIMIT 5";
        
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $id = $row["id"];
            $navn = $row["first_name"];
            $efternavn = $row["last_name"];
            $ph = "?id=";
            $img = './User/'.$navn.'/images/Profil/'.$pr;
            
            echo "<li><a href=søgprofil.php".$ph.$id.">".$navn." ".$efternavn."</a></li>";
        }
    }
?>