<?php
error_reporting(E_ALL); 
require_once './includes.php';

function createUsersSQL($ID, $user_login, $user_pass, $display_name, $user_registered="''", $user_nicename="''", $user_email="''", $user_url="''", $user_activation_key="''", $user_status=0) 
{
    $user_registered = "'" . date("Y-m-d H:i:s") . "'";
    echo <<<EOT
    INSERT INTO `wp_users`(`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES ($ID, $user_login, $user_pass, $user_nicename, $user_email, $user_url, $user_registered, $user_activation_key, $user_status, $display_name);
    EOT;
}

foreach ($authors_dict as $id => $name) 
{
    $ID = intval($id);

    $user_login = createUserLogin($name);
    $user_login = "'" . $user_login . "'";

    $display_name = $name;
    $display_name = "'" . $display_name . "'";

    $user_pass = generatePassword();
    $user_pass = "'" . $user_pass . "'";

    createUsersSQL($ID, $user_login, $user_pass, $display_name);

    echo "<br>";   
}


?>