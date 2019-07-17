<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";
    
    $champion_name = $_GET['champion_name'];
    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    
    $result = mysqli_query($connector, "SELECT * FROM single_champion_stats WHERE Name = '$champion_name' AND Role = 'top';");
    
    $data = array();

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);