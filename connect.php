<?php

try{
    $conn = new PDO('mysql:host=localhost;dbname=poppleton_dogshow_db', 'username', 'password');
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
    echo "Oh no, there was a problem" . $exception->getMessage();
}

?>
