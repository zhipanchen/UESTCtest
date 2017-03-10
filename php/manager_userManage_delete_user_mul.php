<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/17
 * Time: 15:07
 */
error_reporting(0);
require_once './closed/user.php';
$args = $_POST['userids'];
$userids = json_decode($args);
$u = new user();
if(is_array($userids))
{
    foreach ($userids as $userid)
    {
        $u->delUserByUserId($userid);
    }
}
echo json_encode(array('result'=>'success'));
?>