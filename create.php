<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login Registration</title>
</head>
<style type="text/css">
</style>
<body>
    <?php
     
        if(isset($_POST['submit'])){
            // Include the database configuration file
            include_once 'dbConfig.php';
            
        // If form submitted, insert values into the database.
        if (isset($_REQUEST['first_name'])){
            
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($conn,$password);
            
            $firstname = stripslashes($_REQUEST['first_name']);
            $firstname = mysqli_real_escape_string($conn,$firstname);
            
            $lastname = stripslashes($_REQUEST['last_name']);
            $lastname = mysqli_real_escape_string($conn,$lastname);
            
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($conn,$email);
            
            $Fød = stripslashes($_REQUEST['Fødselsdag']);
            $Fød = mysqli_real_escape_string($conn,$Fød);
            
        
            
            $trn_date = date("Y-m-d H:i:s");
            
            $query = "INSERT into users (password, first_name, last_name, email, trn_date, Fødselsdag) VALUES ( '".md5($password)."', '$firstname', '$lastname', '$email', '$trn_date','$Fød')";
            $result = mysqli_query($conn ,$query);
            $usercheck = "SELECT * FROM users WHERE email = '".$email."'";
            $check = mysqli_query($conn, $usercheck);
            $yes = count($check);
            if ($yes >0) {
        
                
                //The name of the directory that we need to create.
                $directoryName = './User/'.$firstname.'/images/Profil/';
               
                
                //Check if the directory already exists.
                if(!is_dir($directoryName)){
                    //Directory does not exist, so lets create it.
                    mkdir($directoryName, 0755, true);
                
                }
                
                $file = './profilecopy.php';
                $newfile = './'.$firstname.'.'.$lastname.'.php' ;
                if(copy($file,$newfile)){
                    echo 'The file was copied successfully';
                    
                    
                } else{
                    echo 'An error occurred during copying the file';
                    
                }
                
                
                /////////////slutter////
                
                
              echo '<script>window.location.href = "login.php";</script>';
                
            }
            else
            {
                
        
                echo "<div class='form'><h3>You are registered successfully.</h3>";
                    
                    
                    
                }
                
            }
            
    
            // File upload configuration
            $targetDir = './User/'.$firstname.'/images/Profil/';
            $allowTypes = array('jpg','png','jpeg','gif');
            
            $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
            if(!empty(array_filter($_FILES['files']['name']))){
                foreach($_FILES['files']['name'] as $key=>$val){
                    // File upload path
                    $fileName = basename($_FILES['files']['name'][$key]);
                    $targetFilePath = $targetDir . $fileName;
                    
                    // Check whether file type is valid
                    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                    if(in_array($fileType, $allowTypes)){
                        // Upload file to server
                        if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                            // Image db insert sql
                            $insertValuesSQL .= "'".$fileName."', NOW()";
                        }else{
                            $errorUpload .= $_FILES['files']['name'][$key].', ';
                        }
                    }else{
                        $errorUploadType .= $_FILES['files']['name'][$key].', ';
                    }
                }
                
                if(!empty($insertValuesSQL)){
                    $insertValuesSQL = trim($insertValuesSQL,',');
                    // Insert image file name into database
                    $sqlQuery = "INSERT INTO images (profil, uploaded_on, userid) VALUES ($insertValuesSQL, (SELECT id FROM users WHERE email = '$email'))";
                    $insert = $conn->query($sqlQuery);
                    if($insert){
                        $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
                        $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
                        $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
                        
                        $statusMsg = "Files are uploaded successfully.".$errorMsg;
                    }else{
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }
            }else{
                $statusMsg = 'Please select a file to upload.';
            }
            
            // Display status message
            echo $statusMsg;
        }
        
        ?>
<div class="form">
<h1 class="opretkonto">Opret en ny konto</h1>
<p class="gratis" >Det er gratis, og det bliver det ved med at være.<p>


<form name="registration" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
<input class="nyfname" type="text" name="first_name" placeholder="Firstname" required />
<input class="nylname" type="text" name="last_name" placeholder="Lastname" required />
<input  class="nyemail" type="text" name="email" placeholder="Email" required />
<input class="nypass"  type="password" name="password" placeholder="Password" required />
<p class="fød" >Fødselsdag<p>
<input type="date" name="Fødselsdag" id="start" class="dato" name="trip" value="date" min="1900-01-01" max="2024-12-31" />
<p class="PB" >Vælge dit profil billede<p>
<input class="vælge" type="file" name="files[]" multiple >

<input class="reg"  type="submit" name="submit" value="Opret profil" />
</form>
</div>
</body>
</html>

