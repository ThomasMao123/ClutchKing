<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";

    $home_url = "http://clutchkingtest.web.illinois.edu";
    $summoner_name = $_POST["summoner_name"];

    $sql = "DELETE FROM summoner_stats WHERE SummonerName = '$summoner_name';";

    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    mysqli_query($connector, $sql);

    

    