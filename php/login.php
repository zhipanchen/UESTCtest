<?php

require_once 'closed/config.php';
require_once 'closed/session.php';
require_once 'closed/connect_db.php';
$s = new Session();
$conn = connectDb();
$username=$_POST['username'];
$password=$_POST['password'];
//$username="peadmin";
//$password="peadmin";
$sql="SELECT * FROM x2_user WHERE username= '$username'";
$stmt = $conn->query($sql);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if($user)
{
     if($user['userstate']==0)
     {
          $message['state']=3;
     }
     else
     {
          if($user['userpassword']==md5($password))
          {
               $message['state']=$user['usergroupid'];
               $s->setSession($user);
          }
          else
          {
               $message['state']=0;
          }
     }
}
else
{
     $message['state']=0;
}
$stmt=null;
$conn=null;
echo json_encode($message);
?>