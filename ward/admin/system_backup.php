<?php
header("Content-Type: text/html; charset=utf-8");
require_once('../configs/config.php');
require_once("../models/websurvey/webSurvey.class.php");
SysUser::authIsLogin("../login.php");

if(!empty($_GET['do'])){
    $do = $_GET['do'];
    switch($do){
        case "backupDatabase":
            $data = $_POST['back'];
            if('backupDatabase' == $data){
                // 设置SQL文件保存文件名 
                $cfg_dbname = 'asteriskcdrdb';
                $filename=date("Ymd",time())."-".$cfg_dbname.".sql"; 

                // 获取当前页面文件路径，SQL文件就导出到指定文件夹内
                // $savePath = './Public/upload/DB/';
                $savePath = '../upload/DB/';

                if(!file_exists($savePath)){
                    mkdir($savePath,0777,true);
                }
                $tmpFile = $savePath.$filename;
                fopen($tmpFile, "r");
                chmod($tmpFile,0777);

                /* //删除之前备份的数据
                $dh=opendir($savePath); 
                if($dh){
                    while ($file=readdir($dh)) { 
                        if($file!="." && $file!="..") { 
                            $fullpath=$savePath."/".$file; 
                            if(!is_dir($fullpath)) { 
                                unlink($fullpath); 
                            }
                        } 
                    } 
                    closedir($dh);
                } //删除之前备份的数据*/

                // 用MySQLDump命令导出数据库
                $dbhost = '***.***.***.***';//主机IP地址
                $cfg_dbuser = 'root';//用户名
                $cfg_dbpwd = '******';//密码
                $bool_dump = exec("mysqldump -h$dbhost -u$cfg_dbuser -p$cfg_dbpwd --default-character-set=utf8 $cfg_dbname > ".$tmpFile);
                if(0 == $bool_dump){
                    $bool_tar = exec("tar -zcvPf /var/spool/asterisk/monitor/system/backup/db.tar /var/spool/asterisk/monitor/upload/DB/$filename");
                    if(0 == $bool_tar){
                        $arr = json_encode(array('msg'=>1,'url'=>$filename));
                        echo $arr;
                    }else{
                        $arr = json_encode(array('msg'=>'备份失败，请联系管理员！'));
                        echo $arr;
                    }
                }
            }
            exit;
        }
        default:
            break;
    }
}
?>