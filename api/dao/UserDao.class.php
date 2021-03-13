<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

  public function get_user_by_id($id){
    return $this->query_unique("SELECT * FROM users WHERE user_id=:id", ["id"=>$id]);
  }

  public function add_user($user){
    $sql = "INSERT INTO users (name, account_id) VALUES (:name, :account_id)";
    $stmt= $this->connection->prepare($sql);
    $stmt->execute($user);
    $user['user_id'] = $this->connection->lastInsertId();
    return $user;
  }

  public function update_user($id, $user){
    $query = "UPDATE users SET ";
    foreach($user as $name => $value){
      $query .= $name ."= :".$name.", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE user_id= :user_id";
    $stmt= $this->connection->prepare($query);
    $user["user_id"] = $id;
    $stmt->execute($user);
    return $user;
  }
}
?>
