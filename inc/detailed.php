<?php
    if (!isset($serverid))
    {
        if (!isset($_GET['detailed']))
        {
            return;
        }
        $serverid = $_GET['detailed'];
    }

    
?>