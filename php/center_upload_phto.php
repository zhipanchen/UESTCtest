<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午3:46
 */
    $photo = $_FILES['photo'];
    $userid = $_POST['userid'];
    require_once './closed/dir.php';
    $d = new dir();
    $d->makeDirInFilesData('photo');
    $path = 'photo/'.md5($userid).'.jpg';
    move_uploaded_file($photo['tmp_name'],$path);
    require_once './closed/user.php';
    $u = new user();
    $u->modUserPhoto($userid,$path);
    echo json_encode(array('result'=>'success','path'=>$path));
    //{"result":"success","path":"photo\/c4ca4238a0b923820dcc509a6f75849b.jpg"}
?>