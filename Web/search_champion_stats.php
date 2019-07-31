<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";
    
    $champion_name = $_GET['champion_name'];
    
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    
    
    
    $best_counter_search = "SELECT * FROM single_champion_stats WHERE name IN (SELECT Name FROM match_up_stats WHERE ".$champion_name." IN (SELECT MIN(TEMP.A) FROM (SELECT Name AS N, ".$champion_name." AS A FROM match_up_stats WHERE NOT Name = ".$champion_name.") AS TEMP))";
    $best_against_search = "SELECT * FROM single_champion_stats WHERE name IN (SELECT Name FROM match_up_stats WHERE ".$champion_name." IN (SELECT MAX(TEMP.A) FROM (SELECT Name AS N, ".$champion_name." AS A FROM match_up_stats WHERE NOT Name = ".$champion_name.") AS TEMP))";

    $data = array();
    $result = mysqli_query($connector, "SELECT * FROM single_champion_stats WHERE name = '$champion_name' AND role = 'top';");
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $best_counter_result = mysqli_query($connector, $best_counter_search);
    $data[] = mysqli_fetch_assoc($best_counter_result);

    $best_against_result = mysqli_query($connector, $best_against_search);
    $data[] = mysqli_fetch_assoc($best_against_result);
    
    echo json_encode($data);