<?php
include "connect.php";

   if($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['submit'])) {
    
        $file=$_FILES['avatar'];
        $filename= $file['name'];
        move_uploaded_file($file['tmp_name'],"../../asset/picture/$filename");
        $avatar=$filename;
        $name = $_POST['name'];
        $date = $_POST['premiere_date'];
        $country = $_POST['country'];
        $describe = $_POST['description'];
        if(isset($_POST['trailer'])){
            $trailer = $_POST['trailer'];
        }
        else{
            $trailer =null;
        }
        $sql = "INSERT INTO `movie`( `name`, `avatar`, `premiere_date`, `country`, `description`, `trailer`) 
        VALUES ('$name',' $avatar','$date','$country','$describe',' $trailer')";
           if (mysqli_query($conn, $sql)) {
            $id=mysqli_insert_id($conn);
            echo 'Record inserted successfully into movie';
            
        }
        else {
            echo "Lỗi: " . mysqli_error($conn);
        }
        $cat_add=mysqli_query($conn,"SELECT * from category");
        while($cat=mysqli_fetch_assoc($cat_add)){
            $cat_name=$cat['name'];
            if(isset($_POST["$cat_name"])){
                $cat= $_POST["$cat_name"];
                $result=mysqli_query($conn,"SELECT * from category where name='$cat'");
                while($cat_movie=mysqli_fetch_assoc($result)){
                    $cat_id= $cat_movie['id'];
                    
                    if(mysqli_query($conn,"INSERT INTO `movie_cat`(`movie_id`, `cat_id`) VALUES ('$id','$cat_id')")){
                       echo  'Record inserted successfully into m_cat';
                       header('location:ad_film.php');
                    }
                    else{
                        echo "Loi". mysqli_error($conn);
                    }
                }
            };

        }
        
        }
?>