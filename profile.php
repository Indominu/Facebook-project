<?php
    session_start ();
     $id = $_SESSION["id"];
    $b = $_SESSION["email"];
    if(!isset($_SESSION["email"]))
    
    header("location:login.php");
    
include 'dbConfig.php';

$sql = "SELECT * from users WHERE id = '$id'";
// Get images from the database
$query = mysqli_query($conn, $sql);

if (!$query) {
    die ('SQL Error: ' . mysqli_error($conn));
}
    while($row = mysqli_fetch_array($query)){
        $navn = $row["first_name"];
        $efternavn = $row["last_name"];
        
    }

?>
<html>


<head>
<link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/textfeltopslag.js"></script>


</head>
<form method="get" action="logout.php">
    
</form>
   <!--form til at ændre profil billedet -->
<form hidden id="changeProfileImage" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input hidden  id="uptest" name="text" Value="" rows="1"></input>
   <input hiddentype="submit" name="submit" value="Submit Form"><br>

</form>
<!--form til at ændre profil billedet  slutter-->
<div class="topnav" >

<img class="logo" src="uploads/content/H.png" alt="" height="26" width="26">

<form method="get" action="logout.php">
<button  class="logout" type="submit">Logout</button>
</form>
<?php
    
    include 'dbConfig.php';
    
    /// opdatere databasen profile billede 

    if(isset($_POST["submit"])){
        
        $changeProfileImage = $_POST["text"];
    
        echo "hejejefd";
        echo $changeProfileImage;
        
     $upprofile = "UPDATE images SET profil='$changeProfileImage' WHERE userid=48";
        
        if ($conn->query($upprofile) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }
    
    
    $sql = "SELECT users.id, users.first_name, images.profil from users INNER JOIN images on users.id = images.userid WHERE email = '".$b."' limit 1";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }
    while($row = mysqli_fetch_array($query)){
        $navn = $row["first_name"];
       $imageURL = './User/'.$navn.'/images/Profil/'.$row["profil"];
        
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
<script type="text/javascript">
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
<div class="column left">
</div> 
<?php
    
    include 'dbConfig.php';
    
    $sql = "SELECT * from images WHERE userid = '$id' limit 1";
    // Get images from the database
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }
    
    
    while($row = mysqli_fetch_array($query)){
        $profilepic= './User/'.$navn.'/images/Profil/'.$row["profil"];
        

        //echo '<input type="image" class="profilbillede" src="'.$profilepic.'" alt="" height="168px" width="168px">';
        echo '<div id="profile-upload"> <div class="hvr-profile-img">
        <input type="file" name="logo" id="getval"  class="upload w180" title="Dimensions 180 X 180" id="imag">
        </div>
        <i class="fa fa-camera"></i>
  </div>';
     
    }
    ?>
<div class="column middle">
<?php
include 'dbConfig.php';

    
$cover = "SELECT * from images order by uploaded_on DESC LIMIT 1";
// Get images from the database
$query = mysqli_query($conn, $cover);


if ($query->num_rows > 0) {
    
while($row = mysqli_fetch_array($query)){
    
    $coverpic = './User/'.$navn.'/images/Cover/'.$row["file_name"];
    echo '<div>';
    echo '<img  type="text" class="coverbillede" src="'.$coverpic.'" alt="" >';
    echo '</div>';
    
?>
<form name="registration" action="uploadcover.php" method="post" enctype="multipart/form-data">
<input  class="opload" type="file" name="files[]"  multiple >
<input class="opdater" type="submit" name="submit" value="Opdater/coverbillede"/>
</form>
<div class="info">
    <h4 style="margin: 0; color: black">Bio.</h4>
    <form action="uploadcover.php" method="post">
        <textarea name="bioText" style="margin: 0; width: 100%; height: 80%">
            <?php
                include 'dbConfig.php';

                $bio = "SELECT userBio from users WHERE id =".$_SESSION["id"].";";
                $query = mysqli_query($conn, $bio);

                if ($query->num_rows > 0) {
                    while($row = mysqli_fetch_array($query)){
                        echo $row["userBio"];
                    }
                }
            ?>
        </textarea>
        <input type="submit" name="submit"/>
    </form>
</div>
<img class="iconer" src="uploads/content/photo.png" alt=""><div class="infobilleder" >
<?php
    include 'dbConfig.php';
    
    $cover = "SELECT * from Post order by uploaded_on DESC LIMIT 3";
    // Get images from the database
    $query = mysqli_query($conn, $cover);
    
    if (!$query) {
        die ('SQL Error: ' . mysqli_error($conn));
    }

    echo '<p class="textBilleder">Billeder</p>';
    while($row = mysqli_fetch_array($query)){
        
        $galleri = './User/'.$navn.'/images/Content/'.$row["file_name"];
        
        echo '<img  type="text" src="'.$galleri.'" alt=""  width="101" height="135">';
        
        
    }
    
?>
</div>
<img class="iconer" src="uploads/content/share.png" alt=""><div class="infovenner" >
<?php
 echo '<p class="textBilleder">Venner</p>';
    
?>
</div>
<?php
    }
}else{
       echo '<h1 class="coverbilledetext">Vælge dit cover billede<h1>';
}

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
        $imageURL = './User/'.$navn.'/images/Profil/'.$row["profil"];
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
<input  class="upload" type="file" name="files[]" multiple >
<textarea class="autoExpand"  name="text"  id="test" rows="1"  placeholder=<?php echo' "Hvad har du på hjerte '.$navn.'"';?>></textarea>
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



<div class="column right">

</div>
</div>

</body>
<script>
document.getElementById('getval').addEventListener('change', readURL, true);
function readURL(){
    var file = document.getElementById("getval").files[0];
    var reader = new FileReader();
    reader.onloadend = function(){
        document.getElementById('profile-upload').style.backgroundImage = "url(" + reader.result + ")";     
         document.getElementById("uptest").value = reader.result ;     
         document.getElementById("changeProfileImage").submit();
        

    }
    if(file){
        reader.readAsDataURL(file);
    }else{
    }
}    
</script>
</html>
