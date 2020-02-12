<?php
    session_start ();
    $A = $_SESSION["id"];
    $b = $_SESSION["email"];
    if(!isset($_SESSION["email"]))
    
    header("location:login.php");

    if(isset($_POST['submit'])){
        // Include the database configuration file
        include_once 'dbConfig.php';

        if(isset($_POST['bioText'])){
            $sql = "UPDATE users set userBio = "."'".$_POST['bioText']."'"." WHERE id = ".$A.";";
            $result = mysqli_query($conn, $sql);
            echo '<script>window.location.href = "profile.php";</script>';
             
        }else{        
        
        $sql = "Select first_name from users where email = '$b'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $nv = $row["first_name"];
                //The name of the directory that we need to create.
                $directoryName = './User/'.$nv.'/images/Cover/';
                
                //Check if the directory already exists.
                if(!is_dir($directoryName)){
                    //Directory does not exist, so lets create it.
                    mkdir($directoryName, 0755, true);
                }

            }
        }
        
        // File upload configuration
        $targetDir = './User/'.$nv.'/images/Cover/';
        $allowTypes = array('jpg','png','jpeg','gif');
        echo $targetDir;
        
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
        if(!empty(array_filter($_FILES['files']['name']))){
            foreach($_FILES['files']['name'] as $key=>$val){
                // File upload path
                $fileName = basename($_FILES['files']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                
                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                if(in_array(strtolower($fileType) , $allowTypes)){
            
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
                $sqlQuery = "INSERT INTO images (file_name, uploaded_on, userid) VALUES ($insertValuesSQL, '$A')";
                $insert = $conn->query($sqlQuery);
                if($insert){
                    $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
                    $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
                    $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
                   echo '<script>window.location.href = "profile.php";</script>';
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
    }
    

    ?>
