<?php
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $summoner_name = filter_input(INPUT_POST, 'summoner_name');
    $home_url = "http://clutchkingtest.web.illinois.edu/user.html?summoner_name=".$summoner_name;
    if (!empty($email) && !empty($password) && !empty($summoner_name)) {
        $host = "localhost";
        $dbusername = "clutchkingtest_root";
        $dbpassword = "clutchking.gg";
        $dbname = "clutchkingtest_users";

        $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            echo "Failed to connect to database";
        } else {
            $search_user_sql = "SELECT * FROM users WHERE Email = '$email'";
            $search_result = mysqli_query($connector, $search_user_sql);
            $resultCheck = mysqli_num_rows($search_result);
            if ($resultCheck > 0) {
                echo "The user has been created";
            } else {
                $api_key = "RGAPI-bee48f6b-0bb6-4ac6-93e1-9b943349bc8f";
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
                
                $create_user_sql = "INSERT INTO users (Email, Password, SummonerName)
                                    VALUES('$email', '$password', '$summoner_name');";
                
                $create_summoner_sql = "INSERT INTO summoner_stats (SummonerName, Tier, Rank, Wins, Losses)
                                        VALUES('$summoner_name', '$tier', '$rank', '$wins', '$losses');";
                
                if ($connector->query($create_user_sql)) {
                    //echo "New record has been inserted successfully.";
                    if ($connector->query($create_summoner_sql)) {
                        header("Location: $home_url");
                    } else {
                        echo "Error". $sql . "<br>" . $connector->error;
                    }
                } else {
                    echo "Error". $sql . "<br>" . $connector->error;
                }                    
            }
            $connector->close();
            
        }
    } else {
        echo "Please fill out the info.";
    }
    