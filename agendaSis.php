<?php
class Dbasis{
   protected $host;
   protected $port;
   protected $dbname;
   protected $user;
   protected $password;
   protected $dns;
   protected $conn;


   function __construct()
   {
      $this->host       = '';
      $this->port       = '';
      $this->dbname     = '';
      $this->user       = '';
      $this->password   = '';
      $this->dns        = "host= $this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password";
      $this->conn       =  pg_connect($this->dns) or die('ERRO AO CONECTAR! '.pg_last_error());
   }
   public function close(){
      pg_close($this->conn);
   }

   public function create($tabela, array $datas)
   {
      $fields     = implode(", ", array_keys($datas));
      $values     = "'" . implode("', '", array_values($datas)) . "'";
      $qrCreate   = "INSERT INTO {$tabela} ($fields) VALUES ($values)";
      $stCreate   = pg_query($qrCreate);
      if(pg_affected_rows($stCreate)>0){
         return pg_result_status($stCreate); //retorna 1 
      }else{
            return false;
      }
      Dbasis::close();
   }
     
   public function read(string $tabela, string $condicao = NULL)
   {
      $qrRead = "SELECT * FROM {$tabela} {$condicao}";
      $stRead = pg_query($this->conn,$qrRead);
      if(pg_affected_rows($stRead)>0){
         return pg_fetch_all($stRead); 
      }else{
         return false;
      }
      Dbasis::close();
   }
   
   public function update($tabela, array $datas, $where)
   {
       foreach ($datas as $fields => $values) {
           $campos[] = "$fields = '$values'";
       }
       $campos = implode(", ", $campos);
       $qrUpdate = "UPDATE " . $tabela . " SET " . $campos . " WHERE " . $where;
       $stUpdate = pg_query($this->conn,$qrUpdate);
       if (pg_affected_rows($stUpdate)>0) {
           return $campos;
       }else{
          return false;
       }
      Dbasis::close();
   }
   
   public function select($campo, $tabela, $cond = NULL)
   {
      $qrRead = "SELECT {$campo} FROM {$tabela} {$cond}";
      $stRead = pg_query($this->conn, $qrRead);
      if ($stRead) {
         return pg_fetch_all($stRead);
      }else{
         return false;
      }
      Dbasis::close();
   }
   protected function delete($tabela, $where)
   {
       $qrDelete = "DELETE FROM {$tabela} WHERE {$where}";
       $stDelete = pg_query($this->conn, $qrDelete);
       if ($stDelete) {
           return $stDelete;
       }else{
          return false;
       }
      Dbasis::close();
   }
}
