<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/13
 * Time: 12:51
 */

require_once './closed/config.php';
require_once './closed/session.php';
require_once './closed/user.php';

$s = new Session();
$u = new user();
$session = $s->getCurrentSession();
$user = $u->getUserById($session['sessionuserid']);
$s->clearSession($user['username']);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>