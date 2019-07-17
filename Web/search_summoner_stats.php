<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";
    $summoner_name = $_GET['summoner_name'];
    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    
    $result = mysqli_query($connector, "SELECT * FROM summoner_stats WHERE SummonerName = '$summoner_name'");
    
    $data = array();

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);