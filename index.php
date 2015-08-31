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
if (session::exists('success')) {
    echo session::flash('success');
} else {
    $salt=  Hash::salt(255);
    echo $salt;
}
?>
    </body>
</html>
