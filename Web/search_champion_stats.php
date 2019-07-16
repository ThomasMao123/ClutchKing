<?php
    $champion_name = filter_input(INPUT_POST, 'input_champion_name');
    if (!empty($champion_name)) {
        $host = "localhost";
        $dbusername = "clutchkingtest_root";
        $dbpassword = "clutchking.gg";
        $dbname = "clutchkingtest_users";

        $connector = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            echo "failed";
        } else {
            $sql = "SELECT * FROM single_champion_stats WHERE Name = '$champion_name' AND Role = 'top'; ";
            $result = mysqli_query($connector, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Win rate:";
                    echo $row['WinRate'];
                    echo "Pick rate:";
                    echo $row['PickRate'];
                    echo "Ban rate:";
                    echo $row['BanRate'];
                    echo "Role:";
                    echo $row['Role'];
                }
            } else {
                echo "Not found";
            }
            
        }
    } else {
        echo "Please enter a champion name";
    }
    ?>