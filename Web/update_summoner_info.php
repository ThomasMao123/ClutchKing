<?php
    $host = "localhost";
    $dbusername = "clutchkingtest_root";
    $dbpassword = "clutchking.gg";
    $dbname = "clutchkingtest_users";

    $summoner_name = $_GET['summoner_name'];
    $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        echo "Failed to connect to database";
    } else {
        $api_key = "RGAPI-c59065ce-0b1e-4dea-b65d-0c721422d4ed";
        $riot_getId_api = "https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/".$summoner_name."?api_key=".$api_key;
        //Get encrypted id
        $summoner_json = json_decode(file_get_contents($riot_getId_api), true);
        $summoner_id = $summoner_json['id'];
        //echo $summoner_id;

        $riot_getStats_api = "https://na1.api.riotgames.com/lol/league/v4/entries/by-summoner/".$summoner_id."?api_key=".$api_key;
        $summoner_match_stats = json_decode(file_get_contents($riot_getStats_api), true);
            
        $tier = $summoner_match_stats[0]['tier'];
        $rank = $summoner_match_stats[0]['rank'];
        $wins = $summoner_match_stats[0]['wins'];
        $losses = $summoner_match_stats[0]['losses'];
            
        $update_summoner_sql = "UPDATE summoner_stats 
                                SET Tier = '$tier', Rank = '$rank', Wins = '$wins', Losses = '$losses'
                                WHERE SummonerName = '$summoner_name';";
            
        $select_summoner_sql = "SELECT * FROM summoner_stats WHERE SummonerName = '$summoner_name';";

        if ($connect->query($update_summoner_sql)) {
            $result = mysqli_query($connector, $select_summoner_sql);
            
            $data = array();
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        }

    }