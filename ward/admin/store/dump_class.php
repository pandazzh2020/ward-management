<?php
class DbManage {
    var $db; // 数据库连接
    var $database; // 所用数据库
    var $sqldir; // 数据库备份文件夹
    // 换行符
    private $ds = "\n";
    // 存储SQL的变量
    public $sqlContent = "";
    // 每条sql语句的结尾符
    public $sqlEnd = ";";

	var $msg;

    /**
     * 初始化
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param string $charset
     */
    function __construct($host = 'localhost:3308', $username = 'root', $password = '', $database = 'db_test', $charset = 'utf8') {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        set_time_limit(0);//无时间限制
@ob_end_flush();
        // 连接数据库
        $this->db = @mysqli_connect ( $this->host, $this->username, $this->password ) or die( '<p class="dbDebug"><span class="err">Mysql Connect Error : </span>'.mysql_error().'</p>');
        // 选择使用哪个数据库
        mysqli_select_db ($this->db, $this->database) or die('<p class="dbDebug"><span class="err">Mysql Connect Error:</span>'.mysql_error().'</p>');
        // 数据库编码方式
        mysqli_query ($this->db, 'SET NAMES ' . $this->charset);

    }

    /*
     * 新增查询数据库表
     */
    function getTables() {
        $res = mysqli_query ($this->db, "SHOW TABLES" );
        $tables = array ();
        while ( $row = mysqli_fetch_array ( $res ) ) {
            $tables [] = $row [0];
        }
        return $tables;
    }

    /*
     *
     * ------------------------------------------数据库备份start----------------------------------------------------------
     */

    /**
     * 数据库备份
     * 参数：备份哪个表(可选),备份目录(可选，默认为backup),分卷大小(可选,默认2000，即2M)
     *
     * @param $string $dir
     * @param int $size
     * @param $string $tablename
     */
    function backup($tablename = '', $dir, $size) {
        $dir = $dir ? $dir : './backup/';
        // 创建目录
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true ) or die ( '创建文件夹失败' );
        }
        $size = $size ? $size : 2048;
        $sql = '';
        // 只备份某个表
        if (! empty ( $tablename )) {
            if(@mysqli_num_rows(mysqli_query($this->db,"SHOW TABLES LIKE '".$tablename."'")) == 1) {
             } else {
                $this->_showMsg('表-<b>' . $tablename .'</b>-不存在，请检查！',true);
                die();
            }
            $this->_showMsg('正在备份表 <span class="imp">' . $tablename.'</span>');
            // 插入dump信息
            $sql = $this->_retrieve ();
            // 插入表结构信息
            $sql .= $this->_insert_table_structure ( $tablename );
            // 插入数据
            $data = mysqli_query ($this->db, "select * from " . $tablename );
            // 文件名前面部分
            $filename = date ( 'YmdHis' ) . "_" . $tablename;
            // 字段数量
            $num_fields = mysqli_num_fields ( $data );
            // 第几分卷
            $p = 1;
            // 循环每条记录
            while ( $record = mysqli_fetch_array ( $data ) ) {
                // 单条记录
                $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                // 如果大于分卷大小，则写入文件
                if (strlen ( $sql ) >= $size * 1024) {
                    $file = $filename . "_v" . $p . ".sql";
                    if ($this->_write_file ( $sql, $file, $dir )) {
                        $this->_showMsg("表-<b>" . $tablename . "</b>-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>" .$dir . $file ."</span> ]");
                    } else {
                        $this->_showMsg("备份表 -<b>" . $tablename . "</b>- 失败",true);
                        return false;
                    }
                    // 下一个分卷
                    $p ++;
                    // 重置$sql变量为空，重新计算该变量大小
                    $sql = "";
                }
            }
            // 及时清除数据
            unset($data,$record);
            // sql大小不够分卷大小
            if ($sql != "") {
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sql, $filename, $dir )) {
                    $this->_showMsg( "表-<b>" . $tablename . "</b>-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>" .$dir . $filename ."</span> ]");
                } else {
                    $this->_showMsg("备份卷-<b>" . $p . "</b>-失败<br />");
                    return false;
                }
            }
            $this->_showMsg("恭喜您! <span class='imp'>备份成功</span>");
        } else {
            $this->_showMsg('正在备份');
            // 备份全部表
            if ($tables = mysqli_query ($this->db, "show table status from " . $this->database )) {
                $this->_showMsg("读取数据库结构成功！");
            } else {
                $this->_showMsg("读取数据库结构失败！");
                exit ( 0 );
            }
            // 插入dump信息
            $sql .= $this->_retrieve ();
            // 文件名前面部分
            $filename = date ( 'YmdHis' ) . "_all";
            // 查出所有表
            $tables = mysqli_query ($this->db, 'SHOW TABLES' );
            // 第几分卷
            $p = 1;
            // 循环所有表
            while ( $table = mysqli_fetch_array ( $tables ) ) {
                // 获取表名
                $tablename = $table [0];
                // 获取表结构
                $sql .= $this->_insert_table_structure ( $tablename );
                $data = mysqli_query ($this->db, "select * from " . $tablename );
                $num_fields = mysqli_num_fields ( $data );

                // 循环每条记录
                while ( $record = mysqli_fetch_array ( $data ) ) {
                    // 单条记录
                    $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                    // 如果大于分卷大小，则写入文件
                    if (strlen ( $sql ) >= $size * 1000) {

                        $file = $filename . "_v" . $p . ".sql";
                        // 写入文件
                        if ($this->_write_file ( $sql, $file, $dir )) {
                            $this->_showMsg("-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>".$dir.$file."</span> ]");
                        } else {
                            $this->_showMsg("卷-<b>" . $p . "</b>-备份失败!",true);
                            return false;
                        }
                        // 下一个分卷
                        $p ++;
                        // 重置$sql变量为空，重新计算该变量大小
                        $sql = "";
                    }
                }
            }
            // sql大小不够分卷大小
            if ($sql != "") {
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sql, $filename, $dir )) {
                    $this->_showMsg("-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>".$dir.$filename."</span> ]");
                } else {
                    $this->_showMsg("卷-<b>" . $p . "</b>-备份失败",true);
					echo "<a href = '../home.php'>返回</a>";
                    return false;
                }
            }
            $this->_showMsg("恭喜您! <span class='imp'>备份成功</span>");
			echo "<a href = '../home.php'>返回</a>";
        }
    }

    //  及时输出信息
    private function _showMsg($msg,$err=false){
        $err = $err ? "<span class='err'>ERROR:</span>" : '' ;
        echo "<p class='dbDebug'>".$err . $msg."</p>";
        flush();
    }

    /**
     * 插入数据库备份基础信息
     *
     * @return string
     */
    private function _retrieve() {
        $value = '';
        $value .= '--' . $this->ds;
        $value .= '-- MySQL database dump' . $this->ds;
        $value .= '-- Created by DbManage class, Power By yanue. ' . $this->ds;
        $value .= '-- http://yanue.net ' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- 主机: ' . $this->host . $this->ds;
        $value .= '-- 生成日期: ' . date ( 'Y' ) . ' 年  ' . date ( 'm' ) . ' 月 ' . date ( 'd' ) . ' 日 ' . date ( 'H:i' ) . $this->ds;
        $value .= '-- MySQL版本: ' . mysqli_get_server_info ($this->db) . $this->ds;
        $value .= '-- PHP 版本: ' . phpversion () . $this->ds;
        $value .= $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- 数据库: `' . $this->database . '`' . $this->ds;
        $value .= '--' . $this->ds . $this->ds;
        $value .= '-- -------------------------------------------------------';
        $value .= $this->ds . $this->ds;
        return $value;
    }

    /**
     * 插入表结构
     *
     * @param unknown_type $table
     * @return string
     */
    private function _insert_table_structure($table) {
        $sql = '';
        $sql .= "--" . $this->ds;
        $sql .= "-- 表的结构" . $table . $this->ds;
        $sql .= "--" . $this->ds . $this->ds;

        // 如果存在则删除表
        $sql .= "DROP TABLE IF EXISTS `" . $table . '`' . $this->sqlEnd . $this->ds;
        // 获取详细表信息
        $res = mysqli_query ($this->db, 'SHOW CREATE TABLE `' . $table . '`' );
        $row = mysqli_fetch_array ($res );
        $sql .= $row [1];
        $sql .= $this->sqlEnd . $this->ds;
        // 加上
        $sql .= $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= "-- 转存表中的数据 " . $table . $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= $this->ds;
        return $sql;
    }

    /**
     * 插入单条记录
     *
     * @param string $table
     * @param int $num_fields
     * @param array $record
     * @return string
     */
    private function _insert_record($table, $num_fields, $record) {
        // sql字段逗号分割
        $insert = '';
        $comma = "";
        $insert .= "INSERT INTO `" . $table . "` VALUES(";
        // 循环每个子段下面的内容
        for($i = 0; $i < $num_fields; $i ++) {
            $insert .= ($comma . "'" . mysqli_escape_string ( $this->db,$record [$i] ) . "'");
            $comma = ",";
        }
        $insert .= ");" . $this->ds;
        return $insert;
    }

    /**
     * 写入文件
     *
     * @param string $sql
     * @param string $filename
     * @param string $dir
     * @return boolean
     */
    private function _write_file($sql, $filename, $dir) {
        $dir = $dir ? $dir : './backup/';
        // 创建目录
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true );
        }
        $re = true;
        if (! @$fp = fopen ( $dir . $filename, "w+" )) {
            $re = false;
            $this->_showMsg("打开sql文件失败！",true);
        }
        if (! @fwrite ( $fp, $sql )) {
            $re = false;
            $this->_showMsg("写入sql文件失败，请文件是否可写",true);
        }
        if (! @fclose ( $fp )) {
            $re = false;
            $this->_showMsg("关闭sql文件失败！",true);
        }
        return $re;
    }

    /*
     *
     * -------------------------------上：数据库导出-----------分割线----------下：数据库导入--------------------------------
     */

    /**
     * 导入备份数据
     * 说明：分卷文件格式20120516211738_all_v1.sql
     * 参数：文件路径(必填)
     *
     * @param string $sqlfile
     */
    function restore($sqlfile) {
        // 检测文件是否存在
        if (! file_exists ( $sqlfile )) {
            $this->_showMsg("sql文件不存在！请检查",true);
            exit ();
        }
        $this->lock ( $this->database );
        // 获取数据库存储位置
        $sqlpath = pathinfo ( $sqlfile );
        $this->sqldir = $sqlpath ['dirname'];
        // 检测是否包含分卷，将类似20120516211738_all_v1.sql从_v分开,有则说明有分卷
        $volume = explode ( "_v", $sqlfile );
        $volume_path = $volume [0];
        $this->_showMsg("请勿刷新及关闭浏览器以防止程序被中止，如有不慎！将导致数据库结构受损");
        $this->_showMsg("正在导入备份数据，请稍等！");
        if (empty ( $volume [1] )) {
            $this->_showMsg ( "正在导入sql：<span class='imp'>" . $sqlfile . '</span>');
            // 没有分卷
            if ($this->_import ( $sqlfile )) {
                $this->_showMsg( "数据库导入成功！");
            } else {
                 $this->_showMsg('数据库导入失败！',true);
                exit ();
            }
        } else {
            // 存在分卷，则获取当前是第几分卷，循环执行余下分卷
            $volume_id = explode ( ".sq", $volume [1] );
            // 当前分卷为$volume_id
            $volume_id = intval ( $volume_id [0] );
            while ( $volume_id ) {
                $tmpfile = $volume_path . "_v" . $volume_id . ".sql";
                // 存在其他分卷，继续执行
                if (file_exists ( $tmpfile )) {
                    // 执行导入方法
                    $this->msg =$this->msg . "正在导入分卷 $volume_id ：<span style='color:#f00;'>" . $tmpfile . '</span><br />';
                    if ($this->_import ( $tmpfile )) {

                    } else {
                        $volume_id = $volume_id ? $volume_id :1;
                        exit ( "导入分卷：<span style='color:#f00;'>" . $tmpfile . '</span>失败！可能是数据库结构已损坏！请尝试从分卷1开始导入' );
                    }
                } else {
                    $this->msg .= "此分卷备份全部导入成功！<br />";
                    return;
                }
                $volume_id ++;
            }
        }if (empty ( $volume [1] )) {
            $this->_showMsg ( "正在导入sql：<span class='imp'>" . $sqlfile . '</span>');
            // 没有分卷
            if ($this->_import ( $sqlfile )) {
                $this->_showMsg( "数据库导入成功！");
				echo "<a href = '../home.php'>返回</a>";
            } else {
                 $this->_showMsg('数据库导入失败！',true);
				 echo "<a href = '../home.php'>返回</a>";
                 exit ();
            }
        } else {
            // 存在分卷，则获取当前是第几分卷，循环执行余下分卷
            $volume_id = explode ( ".sq", $volume [1] );
            // 当前分卷为$volume_id
            $volume_id = intval ( $volume_id [0] );
            while ( $volume_id ) {
                $tmpfile = $volume_path . "_v" . $volume_id . ".sql";
                // 存在其他分卷，继续执行
                if (file_exists ( $tmpfile )) {
                    // 执行导入方法
                    $this->msg .= "正在导入分卷 $volume_id ：<span style='color:#f00;'>" . $tmpfile . '</span><br />';
                    if ($this->_import ( $tmpfile )) {

                    } else {
                        $volume_id = $volume_id ? $volume_id :1;
                        exit ( "导入分卷：<span style='color:#f00;'>" . $tmpfile . '</span>失败！可能是数据库结构已损坏！请尝试从分卷1开始导入' );
						echo "<a href = '../home.php'>返回</a>";
                    }
                } else {
                    $this->msg .= "此分卷备份全部导入成功！<br />";
					echo "<a href = '../home.php'>返回</a>";
                    return;
                }
                $volume_id ++;
            }
        }
    }

    /**
     * 将sql导入到数据库（普通导入）
     *
     * @param string $sqlfile
     * @return boolean
     */
    private function _import($sqlfile) {
        // sql文件包含的sql语句数组
        $sqls = array ();
        $f = fopen ( $sqlfile, "rb" );
        // 创建表缓冲变量
        $create_table = '';
        while ( ! feof ( $f ) ) {
            // 读取每一行sql
            $line = fgets ( $f );
            // 这一步为了将创建表合成完整的sql语句
            // 如果结尾没有包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)
            if (! preg_match ( '/;/', $line ) || preg_match ( '/ENGINE=/', $line )) {
                // 将本次sql语句与创建表sql连接存起来
                $create_table .= $line;
                // 如果包含了创建表的最后一句
                if (preg_match ( '/ENGINE=/', $create_table)) {
                    //执行sql语句创建表
                    $this->_insert_into($create_table);
                    // 清空当前，准备下一个表的创建
                    $create_table = '';
                }
                // 跳过本次
                continue;
            }
            //执行sql语句
            $this->_insert_into($line);
        }
        fclose ( $f );
        return true;
    }

    //插入单条sql语句
    private function _insert_into($sql){
        if (! mysqli_query ($this->db, trim ( $sql ) )) {
            $this->msg .= mysqli_error ($this->db);
            return false;
        }
    }

    /*
     * -------------------------------数据库导入end---------------------------------
     */

    // 关闭数据库连接
    private function close() {
        mysqli_close ( $this->db );
    }

    // 锁定数据库，以免备份或导入时出错
    private function lock($tablename, $op = "WRITE") {
        if (mysqli_query ($this->db, "lock tables " . $tablename . " " . $op ))
            return true;
        else
            return false;
    }

    // 解锁
    private function unlock() {
        if (mysqli_query ($this->db, "unlock tables" ))
            return true;
        else
            return false;
    }

    // 析构
    function __destruct() {
        if($this->db){
            mysqli_query ( $this->db ,"unlock tables");
            mysqli_close ( $this->db );
        }
    }

}
?>
