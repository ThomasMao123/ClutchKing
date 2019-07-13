<?php
    $champion_name = filter_input(INPUT_POST, 'input_champion');
    if (!empty($champion_name)) {
        $host = "localhost";
        $dbusername = "clutchkingtest_root";
        $dbpassword = "clutchking.gg";
        $dbname = "clutchkingtest_users";

        $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            echo "failed";
        } else {
            $sql = "SELECT * FROM single_champion_stats WHERE Name = '$champion_name'";
            $result = mysqli_query($connector, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['Win rate'];
                }
            } else {
                echo "Not found";
            }
            
        }
    } else {
        echo "Please enter a champion name";
    }