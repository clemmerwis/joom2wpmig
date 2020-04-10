<?php
error_reporting(E_ALL); 
require_once 'vendor/autoload.php';
require_once './includes.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

function createUsersSQL($ID, $user_login, $user_pass, $display_name, $user_registered="''", $user_nicename="''", $user_email="''", $user_url="''", $user_activation_key="''", $user_status=0) 
{
    $user_registered = "'" . date("Y-m-d H:i:s") . "'";
    $eot = <<<EOT
    
    INSERT INTO `wp_users`(`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES ($ID, $user_login, $user_pass, $user_nicename, $user_email, $user_url, $user_registered, $user_activation_key, $user_status, $display_name);

    EOT;
    return $eot;
}

$myFile = "usersSQL.txt";
$fh = fopen($myFile, 'w+') or die("can't open file");
foreach ($authors_dict as $id => $name) 
{
    $ID = intval($id);

    $user_login = createUserLogin($name);
    $user_login = "'" . $user_login . "'";

    $display_name = $name;
    $display_name = "'" . $display_name . "'";

    $user_pass = generatePassword();
    $user_pass = "'" . $user_pass . "'";

    $eot = createUsersSQL($ID, $user_login, $user_pass, $display_name);
    fwrite($fh, $eot); 
}
fclose($fh);

?>