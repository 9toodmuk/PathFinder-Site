<?php
class Model{
  protected $db;
  protected $table;
  protected $field = array();

  public static function __construct($table){
    $this->db = new Mysql();
    $this->table = $table;
    $this->getFields();
  }

  private function getFields(){
    $sql = "DESC ". $this->table;
    $result = $this->db->getAll($sql);
    foreach ($result as $value) {
      $this->fields[] = $value['Field'];
      if ($value['Key'] == 'PRI') {
        $pk = $value['Field'];
      }
    }

    if (isset($pk)) {
      $this->fields['pk'] = $pk;
    }
  }

  public static function insert($list){
    $field_list = '';
    $value_list = '';

    foreach ($list as $key => $value){
      if (in_array($key, $this->fields)) {
        $field_list .= "'".$key."'" . ',';
        $value_list .= "'".$value."'" . ',';
    }

    $field_list = rtrim($field_list,',');
    $value_list = rtrim($value_list,',');

    $sql = "INSERT INTO '{$this->table}' ({$field_list}) VALUES ($value_list);";

    if ($this->db->query($sql)) {
      return $this->db->getInsertId();
    }else{
      return false;
    }
  }

  public static function update($list){
    $uplist = '';
    $where = 0;

    foreach ($list as $key => $value) {
      if(in_array($key, $this->fields)){
        if ($key == $this->fields['pk']) {
          $where = "'$key' = $value";
        }else{
        $uplist .= "'$key' = '$value'".",";
        }
      }
    }

    $uplist = rtrim($uplist,',');

    $sql = "UPDATE '{$this->table}' SET {$uplist} WHERE $where";

    if ($this->db->query($sql)) {
      if ($rows = mysqli_affected_rows()) {
        return $rows;
      } else {
        return false;
      }
    }else{
      return false;
    }
  }

  public static function delete($list){
    $where = 0;
    if(is_array($pk)){
      $where = "'{$this->fields['pk']}' in (".implode(',', $pk).")";
    }else{
      $where = "'{$this->fields['pk']}' = $pk";
    }

    $sql = "DELETE FROM '{$this->table}' WHERE $where;";

    if ($this->db->query($sql)) {
      if ($rows = mysqli_affected_rows()) {
        return $rows;
      } else {
        return false;
      }
    }else{
      return false;
    }
  }

  public static function selectByPk($pk){
    $sql = "SELECT * FROM '{$this->table}' WHERE '{$this->fields['pk']}' = $pk;";
    return $this->db->getRow($sql);
  }

  public static function total(){
    $sql = "SELECT COUNT(*) FROM '{$this->table}';";
    return $this->db->getOne($sql);
  }

  public static function pageRows($offset, $limit, $where = ''){
    if (empty($where)){
      $sql = "SELECT * FROM {$this->table} LIMIT $offset, $limit;";
    }else{
      $sql = "SELECT * FROM {$this->table} WHERE $where LIMIT $offset, $limit;";
    }

    return $this->db->getAll($sql);
  }
}
