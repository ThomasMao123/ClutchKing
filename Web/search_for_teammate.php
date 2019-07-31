<?php
    $summoner_name = $_GET['summoner_name'];
    $output=shell_exec('source /home/clutchkingtest/virtualenv/graph/3.5/bin/activate;
            		  python /home/clutchkingtest/virtualenv/graph/search_for_teammate.py '.$summoner_name);
    echo $output;
    ?>