<?php 
  /**
  * 数据库连接
  */
  class MyDB {
    private $db = null; 

    private function getConn() {
      if ($this -> db === null) {
        // 假定数据库用户名：root，密码：root，一般加@，它的作用是隐藏连接错误，die直接终止后续程序运行，一般发布的网站不采用
        $this -> db = @new mysqli('127.0.0.1','root','root') or die('不能打开连接!');
        // select_db是MySQLi类的成员函数之一，选择数据库
        $this -> db -> select_db('test') or die("数据库不能打开");                  
        // 执行SQL语句，注意UTF8加双引号
        $this -> db -> query('SET NAMES "UTF8"');
      }
      return $this -> db;
    }

    /**
    * 获取查询记录集
    */
    public function execSQL($sql) { 
      $this -> getConn();
      return $this -> db -> query($sql);
    }

    /**
    * 预处理，绑定参数，可以防御SQL注入
    */
    public function prepare($sql){
      $this -> getConn();	
      return	$this -> db -> prepare($sql); 
    } 

    /**
    * 返回最新插入的自增字段
    */
    public function getLastInsertId(){ 
      $this -> getConn();
      // 返回最后一个查询中自动生成的 ID，也可以写成返回getConn() -> insert_id的形式
      return $this -> db -> insert_id;
    }

    public function getOne($result){
      $this -> getConn();
      // mysqli_fetch_array是从结果集中取得一行作为数字数组或关联数组
      return mysqli_fetch_array($result);
    }

    // 析构函数
    public function __destruct() { 
      if ($this -> db !== null){
        $this -> db -> close();
      }  
    }
  }
?>