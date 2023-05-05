<?php
include "connect.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/11a9c95312.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../style/playing.css">
    <title>Document</title>
</head>
<body>
      <?php
      include "header.php"
      ?>

</body>  
<div style="border-bottom:1px solid rgb(216, 216, 191); ">
    <p style="position: relative; font-size: 17px; margin:8px; padding-left:7rem; ">
        <a href="homepage.php"><i class="fa-sharp fa-solid fa-house" style="color:rgb(216, 216, 191);"></i></a><i class="fa-solid fa-chevron-right" style="padding-left:0.5rem; padding-right:0.5rem; color:#7c2f33;"></i>
        <span><a href="#" style="color:rgb(216, 216, 191); text-decoration:none; ">Movie</a><i class="fa-solid fa-chevron-right" style="padding-left:0.5rem; padding-right:0.5rem; color:#7c2f33;"></i></span>
        <span><a href="upcoming.php" style="color:rgb(216, 216, 191);"><b>Upcoming</b></a></span>
    </p>
</div><br>

<div class="container" style="color: rgb(216, 216, 191);">
    <div class="row">
        <h3>Upcoming Movies</h3>
    </div><br>
 <?php
        $sql = "SELECT movie.name AS movie_name, GROUP_CONCAT(category.name SEPARATOR ', ') AS cat_names, movie.avatar AS avatar, movie.id as m_id
        FROM movie
        LEFT JOIN movie_cat ON movie.id = movie_cat.movie_id
        LEFT JOIN category ON movie_cat.cat_id = category.id WHERE movie.premiere_date > NOW()
        GROUP BY movie.id";
        $sqli = mysqli_query($conn, $sql);
        if (mysqli_num_rows($sqli) > 0) {
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($sqli)) {
            echo '<div class="col-md-3">';
            ?>
            <div class="card" style="width:260px; background: rgba(0, 0, 0, 0.3); ">
                <img class="card-img-top" src="../../asset/picture/<?=$row['avatar']; ?>" style="width:100%; height:145.35px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['movie_name']; ?></h5>
                    <p class="card-text"><?php
                    $cat_names = explode(', ', $row['cat_names']);
                    foreach ($cat_names as $cat_name) {
                        echo '<span class="badge badge-primary mr-1">'. $cat_name . '</span>';
                    }
                    ?></p>
                    <p>
                        <?php 
                        $movie_id=$row['m_id'];
                        $like=mysqli_query($conn,"SELECT * from likes where movie_id='$movie_id'");
                        if(isset($_SESSION['user_id']) ){
                        $user_id=$_SESSION['user_id'];
                        $checkLike=mysqli_query($conn,"SELECT *from likes where movie_id='$movie_id' and user_id='$user_id'");
                        ?>
                        
                        <?php if ( mysqli_num_rows($checkLike)){
                             echo '<a href="" class="btn btn-secondary disabled" style="font-size:12px; width:5.5rem; height:1.9rem">';}
                            
                        else
                        {echo '<a href="like.php?m_id='.$movie_id.'" class="btn btn-primary " style="font-size:12px; width:5.5rem; height:1.9rem">';}}
                        else{
                            echo '<a href="like.php?m_id='.$movie_id.'" class="btn btn-primary " style="font-size:12px; width:5.5rem; height:1.9rem">';
                        }
                        ?> 
                       <i class='fas fa-thumbs-up'></i> Like <?= mysqli_num_rows($like)?></a>
                        <span><a href="detailmovie.php?id=<?=$movie_id?>" class="btn btn-success" style="margin-left:25px; width:6.5rem; height:2.2rem; font-size:13px; ">More Details</a></span>
                    </p>
                </div>
            </div>  <br>  
            <?php
            echo '</div>';
        }
        echo '</div>';
        }   
        else {
            echo "<script>
                    alert(\"Không có phim nào phù hợp!\");
                </script>";  
    }  
            // }  
    
?>
</div>
<!--  -->
<?php
include 'footer.php'
?>
</body> 
</html>
