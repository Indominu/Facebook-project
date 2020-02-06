<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="login.js"></script>
    </head>

    <body style="background-color:#e9ebee;">
        <div class="topnav" >
            
            <form action="loginprocess.php" method="POST"><br><br>
                <p class="email" >Email:</p>
                <input class="user" type="text" required="" placeholder="Email" name="email"><br><br>
                <p class="ad" >Password:</p>
                <input  class="pass" type="text" required="" placeholder="Password" name="password">
                <input class="login" type="submit" value="Login" name="sub">
                <br>
                </div>
                    <?php
                        if(isset($_REQUEST["err"]))
                            $msg="Invalid email or Password";
                    ?>

                    <p style="color:red;">

                    <?php if(isset($msg))
                        {
                            echo $msg;
                        }
                    ?>

                </p>
            </form>

            <form>
            <h2 class="seneste" >Seneste logins<h2>
            <?php
            // config database
            /include 'dbConfig.php';
            

    
    $sql = "SELECT users.id, users.first_name, users.Recent, images.profil from users INNER JOIN images on users.id = images.userid order by users.Recent desc LIMIT 2";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }

if($query->num_rows > 0){
    while($row = mysqli_fetch_array($query)){
         $navn = $row["first_name"];
         $id = $row["id"];
        
        
        $_SESSION['id'] = $id;
        $imageURL = './User/'.$navn.'/images/Profil/'.$row["profil"];
     
        echo '<div class="gallery">';
        echo '<a target="_blank" href="'.$imageURL.'">';
        echo '<img src="'.$imageURL.'" alt="" width="160" height="160">';
        echo '</a>';
        echo '<div class="desc">'.$navn.'</div>';
        echo '</div>';
        
        
        ?>
    
        <?php  }
}else{ ?>
    
    <p>No image(s) found...</p>
    <?php } ?>


</form>


</body>
</html>

