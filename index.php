<?php



require_once 'core/init.php';
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       
       $que= DB::getInstance()->query("SELECT * FROM users WHERE username=?",array('alex'));
       
       ?>
    </body>
</html>
