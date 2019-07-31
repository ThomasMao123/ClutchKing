<?php
    $selected_champion_name = $_GET['selected_champion_name'];
    $output=shell_exec('source /home/clutchkingtest/virtualenv/graph/3.5/bin/activate;
            		    python /home/clutchkingtest/virtualenv/graph/team_formation.py '.$selected_champion_name);
    echo $output;
?>