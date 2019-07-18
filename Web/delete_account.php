<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";

    $home_url = "http://clutchkingtest.web.illinois.edu";
    $summoner_name = $_GET["summoner_name"];

    $sql_delete_summoner = "DELETE FROM summoner_stats WHERE SummonerName = '$summoner_name';";
    $sql_delete_user = "DELETE FROM users WHERE SummonerName =  '$summoner_name';";
    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    
    if ($connector->query($sql_delete_summoner)) {
        if ($connector->query($sql_delete_user)) {
            echo "done";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }


    

    