<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/30
 * Time: 20:42
 */
define('DB','uestc');//MYSQL数据库名
define('DH','localhost');//MYSQL主机名，不用改
define('DU','root');//MYSQL数据库用户名
define('DP','root');//MYSQL数据库用户密码
define('SEC','hack');//邮件加密的密钥
define('LINK',"http://localhost/php/closed/userActive.php&userid=");//邮件中本地接受邮件的位置并且用get方法传送userid的值
define('PN',10);//每页显示数量
define('TIME_LIMIT',3600);//session有效时间(s)
?>