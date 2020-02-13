<?php
    session_start ();
     $id = $_SESSION["id"];
    $b = $_SESSION["email"];
    if(!isset($_SESSION["email"]))
    
    header("location:login.php");
    
    ?>
<html>


<head>
<link rel="stylesheet" type="text/css" href="css/index.css">

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/textfeltopslag.js"></script>


</head>
<div class="topnav" >

<img class="logo" src="uploads/content/H.png" alt="" height="26" width="26">

<form method="get" action="logout.php">
<button  class="logout" type="submit">Logout</button>
</form>
<?php
    
    include 'dbConfig.php';
    $sql = "SELECT users.id, users.first_name, images.profil from users INNER JOIN images on users.id = images.userid WHERE email = '".$b."' limit 1";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }
    while($row = mysqli_fetch_array($query)){
        $navn = $row["first_name"];
       $imageURL = $row["profil"];
        
        echo ' <a class="Bruger" href="profile.php">'.$navn.'</a>';
      echo '<img class="Brugerbillede" src="'.$imageURL.'" alt="" height="26" width="26">';
    }

    //The name of the directory that we need to create.
    $directoryName = './User/'.$navn.'/images/Content/';
    
    //Check if the directory already exists.
    if(!is_dir($directoryName)){
        //Directory does not exist, so lets create it.
        mkdir($directoryName, 0755, true);
    }
    ?>
<input class="søg" placeholder="Søg"  type="text" id="search" name="search">
<ul id="results">
</ul>
<a class="Startside" href="index.php"> Startside <a>
<!-- knappen tilfoje venner notifiktation -->

<div class="dropdown">
    <button class="dropbtn">request</button>
    <div class="dropdown-content">
        <?php
            include 'dbConfig.php';

            $nrOfReq = 0;
            
            $friendReq = "SELECT first_name, last_name, users.id from friends INNER JOIN users ON users.id = userid
                          WHERE friendID =".$id." AND friend ='waiting';";
            $query = mysqli_query($conn, $friendReq);

            if ($query->num_rows > 0) {
                while($row = mysqli_fetch_array($query)){
                    $nrOfReq+=1;
                    echo "<span>".$row["first_name"]." ".$row["last_name"]."
                    <button onclick='toAddOrNotToAdd(0, ".$row["id"].", ".$id.")'>act</button>
                    <button onclick='toAddOrNotToAdd(1, ".$row["id"].", ".$id.")'>dec</button>
                    </span>";
                }
            }
        ?>
    </div>
    <span class="badge"><?php echo $nrOfReq; ?></span>
</div>


<script type="text/javascript">

function toAddOrNotToAdd(action, friendID, userid) {

    var xhr = new XMLHttpRequest();
    var url = 'searchresults.php?action='+action+'&friendID='+friendID+'&userid='+userid;
    xhr.open('GET', url, true);
    
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
        }
    }
    
    xhr.send();
    location.reload();
}

var results = document.getElementById("results");
var search = document.getElementById("search");

function getSearchResults(){
    var searchVal = search.value;
    
    if(searchVal.length < 1){
        results.style.display='none';
        return;
    }
    
    console.log('searchVal : ' + searchVal);
    var xhr = new XMLHttpRequest();
    var url = 'searchresults.php?search=' + searchVal;
    // open function
    xhr.open('GET', url, true);
    
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var text = xhr.responseText;
            //console.log('response from searchresults.php : ' + xhr.responseText);
            results.innerHTML = text;
            results.style.display='block';
        }
    }
    
    xhr.send();
}

search.addEventListener("input", getSearchResults);
</script>
</div>
<body style="background-color:#e9ebee;">
<div class="row">
<div class="column left" style="background-color:#e9ebee;">
<?php
    
    include 'dbConfig.php';
    $sql = "SELECT users.id, users.first_name, users.last_name, images.profil from users INNER JOIN images on users.id = images.userid WHERE email = '".$b."' limit 1";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }
    
    
    while($row = mysqli_fetch_array($query)){
        $navn = $row["first_name"];
        $efternavn = $row["last_name"];
        $imageURL = $row["profil"];
        
        echo ' <a class="Brugerbody" href="profile.php">'.$navn.' '.$efternavn.'</a>';
        echo '<img class="Brugerbilledebody" src="'.$imageURL.'" alt="" height="20" width="20">';
    }
    ?>
<!-- sidebar med Nyheder og alt andet     -->
<div style="margin-top: 12%;">
<p class="messenger">Nyheder<p>
<img class="messengerbillede" src="uploads/content/nyhed.png" alt="" height="20" width="20">

<p class="messenger">Messenger<p>
<img class="messengerbillede" src="uploads/content/messenger.png" alt="" height="20" width="20">

<p class="messenger">Marketplace<p>
<img class="messengerbillede" src="uploads/content/shop.png" alt="" height="20" width="20">

<p class="Udforsk">Udforsk<p>


<p class="messenger">Begivenheder<p>
<img class="messengerbillede" src="uploads/content/calender.png" alt="" height="20" width="20">

<p class="messenger">Grupper<p>
<img class="messengerbillede" src="uploads/content/group.png" alt="" height="20" width="20">

<p class="messenger">Sider<p>
<img class="messengerbillede" src="uploads/content/flag.png" alt="" height="20" width="20">

<p class="messenger">Minder<p>
<img class="messengerbillede" src="uploads/content/time.png" alt="" height="20" width="20">
<!-- sidebar slut-->
</div>
</div>
<div class="column middle">

<?php
    
    include 'dbConfig.php';
    $sql = "SELECT users.id, users.first_name, users.last_name, images.profil from users INNER JOIN images on users.id = images.userid WHERE users.email = '".$b."' limit 1";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }

    while($row = mysqli_fetch_array($query)){
        $navn = $row["first_name"];
        $efternavn = $row["last_name"];
        $imageURL = $row["profil"];
        $pen ='<img class="iconer" src="uploads/content/pen.png" alt="">';
        $photo ='<img class="iconer" src="uploads/content/photo.png" alt="">';
        $video ='<img class="iconer" src="uploads/content/video.png" alt="">';
        $tag ='<img class="iconer" src="uploads/content/tag.png" alt="">';
        $share ='<img class="iconer" src="uploads/content/share.png" alt="">';
        $img ='<img class="iconer" src="uploads/content/share.png" alt="">';
        
        
        //opslag header som laver der hvor der står video billeder hvor man kan uploade dem
        echo ' <div class="opslagnavi" ><p class="opslagnavitext">'.$pen.' Opret opslag &ensp; |&ensp;'.$photo.' Vælg en fil at overføre &ensp; | &ensp;'.$video.' Livevideo</p></div>';
        
        //laver selve opslag omrodet
        echo ' <div class="opslag" > </div>';
        //indsætter profil billedet i textboxen og laver textboxen
        echo '<img  type="text" class="opslagbillede" src="'.$imageURL.'" alt="" height="50" width="50">';
       // echo ' <textarea class="autoExpand"  name="opslagtext" rows="1"  placeholder="Hvad har du på hjerte '.$navn.'"></textarea>';
        
        echo '<hr class="diver">';
        
        
        ?>

        


<form name="registration" action="opslag.php" method="post" enctype="multipart/form-data">
<input  class="opload" type="file" name="files[]" multiple >
<textarea class="autoExpand"  name="text" rows="1"  placeholder=<?php echo' "Hvad har du på hjerte '.$navn.'"';?>></textarea>
<input class="reg" type="submit" name="submit" value="Del" />



   <?php
         }
       include 'dbConfig.php';
       $sql = "SELECT * from Post WHERE userimageid = '$id'";
    
       // Get images from the database
       $query = mysqli_query($conn, $sql);
       
       if (!$query) {
           die ('SQL Error: ' . mysqli_error($conn));
       }
       
       while($row = mysqli_fetch_array($query)){
           
       $images = './User/'.$navn.'/images/Content/'.$row["file_name"];
       $text = $row["text"];
       $date = $row["uploaded_on"];
           
           $dato =date('d. F H.i', strtotime($date));
       //laver selve opslag omrodet
       echo ' <div class="post" > ';
        echo '<img  type="text" class="Postprofil" src="'.$imageURL.'" alt="" height="50" width="50"><p class="postnavn">'.$navn.'&ensp;'.$efternavn.'</p>';
            echo '<p class="postdato" >'.$dato.'</p>';
           echo '<p class="posttext" >'.$text.'</p>';
       
        echo'<img class="postbillede" src="'.$images.'" alt="">';
           echo ' </div>';
       
       
       
       
        }
       ?>


</div>
</form>
</form>
<div class="column right">

</div>
</div>

</body>
<style>
.badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background: red;
  color: white;
}

.dropbtn {
    background-color: #555;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: absolute;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content span {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content span:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
</html>

