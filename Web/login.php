<?php
    $login_email = filter_input(INPUT_POST, 'login_email');
    $login_password = filter_input(INPUT_POST, 'login_password');
    
    if (!empty($login_email) && !empty($login_password)) {
        $host = "localhost";
        $dbusername = "clutchkingtest_root";
        $dbpassword = "clutchking.gg";
        $dbname = "clutchkingtest_users";

        $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            echo "Failed to connect to database";
        } else {
            $search_user_sql = "SELECT * FROM users WHERE Email = '$login_email'";
            $search_result = mysqli_query($connector, $search_user_sql);
            $resultCheck = mysqli_num_rows($search_result);
            
            if ($resultCheck > 0) {
                $row = mysqli_fetch_assoc($search_result);
                if ($row['Password'] == $login_password) {
                    //echo "Login successfully!";
                    $home_url = "http://clutchkingtest.web.illinois.edu/user.html?summoner_name=".$row['SummonerName'];
                    header("Location: $home_url");
                } else {
                    echo "Password is not correct!";
                }
            } else {
                echo "User is not founded!";
            }
            $connector->close();
            
        }
    } else {
        echo "Please fill out the info.";
    }
    