<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    checkBan($_SESSION['user_id']);
    addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") opened leaderboard");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AnonMessaging - Fully anonymous messaging site</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <div class="main-column">
    <a style="color: #000;text-align:center;" href="../"><h1 style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a>
    <h1>Leaderboard</h1>
        <form method="GET" action="search.php">
            <input class="search-bar" type="search" name="search" placeholder="Search for username or email" required>
        </form>
        <br><hr><br>
        <h2>Highest scoring members:</h2>
        <?php
            $sql = "SELECT * FROM `users` ORDER BY `user_points` DESC LIMIT 100";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                if($row['user_type'] == "admin"){
                    $admin = True;
                }else {
                    $admin = False;
                }
                ?>
                <a style="color: #000;" href="../profile/index.php?id=<?php echo $row['user_id']; ?>">
                <div class="user_div">
                <p style="color:red;"><?php echo $row['user_points']; ?></p>
                    <h3><?php echo $row['user_name']; if($admin==True){echo " <span style='color:red;font-size:12px;'>[ADMIN]</span>";} ?></h3>
                    <p style="margin-top:10px;"><?php echo $row['user_email']; ?></p>  
                </div>
                </as>
                <?php
            }
        ?>
        <div class="right-column">
            <h2 style="font-weight:300;">Actions</h2>
            <hr>
            <ul>
            
            <li><a href="../">Dashboard</a></li>
                <li><a href="../profile/index.php?id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                <li><a href="../logout">Logout</a></li>
                <li><a href="../users/index.php">Users</a></li>
                <li><a href="../leaderboard/">Leaderboard</a></li>
                <li><a href="../global/">Global chat</a></li>
                <li><a href="../suggestions/">Suggestions</a></li>
            </ul>
        </div>
    </div>
</body>
</html>