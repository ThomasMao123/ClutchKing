<?php
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $summoner_name = filter_input(INPUT_POST, 'summoner_name');
    $home_url = "http://clutchkingtest.web.illinois.edu/user_stats.html?summoner_name=".$summoner_name;
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
                $create_user_sql = "INSERT INTO users (Email, Password, SummonerName)
                                    VALUES('$email', '$password', '$summoner_name');";
                if ($connector->query($create_user_sql)) {
                    //echo "New record has been inserted successfully.";
                    header("Location: $home_url");
                } else {
                    echo "Error". $sql . "<br>" . $connector->error;
                }                    
            }
            $connector->close();
            
        }
    } else {
        echo "Please fill out the info.";
    }
    