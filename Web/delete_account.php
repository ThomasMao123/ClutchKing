<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";

    $home_url = "http://clutchkingtest.web.illinois.edu";
    $summoner_name = $_GET["summoner_name"];

    $sql = "DELETE FROM summoner_stats WHERE SummonerName = '$summoner_name';
            DELETE FROM users WHERE SummonerName = '$summoner_name';";
    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    $result = mysqli_query($connector, $sql);

    header("Location: $home_url");

    