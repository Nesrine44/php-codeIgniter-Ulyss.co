<?php
    $response = exec('/opt/phantomjs/bin/phantomjs scripts/login.js', $output);

    var_dump($output);

?>
