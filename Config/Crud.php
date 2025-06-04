<?php

//apelido do arquivo (Alias)
namespace Config;



// // faz a chamada da classe PDO
use \PDO;
use \PDOException;
include("Database.php");

use \Config\Database as DB;

class Crud{

protected $connection;
protected $table;

 public function __construct(){
    $this->connection = new DB($this->table);
    print_r($this->connection);
 }




# CRUD
# C - Create
# R - Read
# U - Update
# D - Delete

/*
 ### C- Create:  Método responsável por inserir dados no banco
 ### Exemplo para a criar uma query de Inserção no Banco de Dados
  $values = array(
    'cidades_id' => 1,
    'cidades_nome' => 'Ceres',
    'cidades_uf' => 'GO'
  );

  INSERT INTO `cidades` 
  (`cidades_id`, `cidades_nome`,`cidades_uf`) 
  VALUES 
  (NULL, 'Ceres', 'GO');
*/

//   public function insert($values){
//     //Extração de chaves e valores do array
//     $fields = array_keys($values); // pega as chaves do array
//     $binds  = array_pad([],count($fields),'?'); // cria as posições de inserção da query

//     //monta a query de inserção
//     $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    
//     //executa a query e passa o valores que serão inseridos no banco
//     $this->execute($query,array_values($values));

//     //retorna o ultimo id inserido.
//     return $this->connection->lastInsertId();
//   }

  /* 
    #####  R- Read : Método responsável por fazer uma consulta no banco
    ### Exemplo para a criar uma query de seleção em um Banco de Dados
    Exemplo:
     SELECT * from enderecos
     inner join cidades on enderecos_cidades_id = cidades_id 
     WHERE cidades_id = 1 
     order by cidades_nome 
     LIMIT 1
  */
  public function select($join = null, $where = null, $order = null, $limit = null,$fields = '*'){
    
    //Complementos da query de seleção
    @$join = strlen($join) ? 'inner join '.$join : ''; //junção de tabelas
    @$where = strlen($where) ? 'WHERE '.$where : ''; //clausula where
    @$order = strlen($order) ? 'ORDER BY '.$order : ''; //ordenação
    @$limit = strlen($limit) ? 'LIMIT '.$limit : ''; // limite de retorno de dados

    //monta a query
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$limit;
    
    //Executa a query
    return $this->execute($query);
  }

  /*
  #####  U - Update : Método responsável por fazer uma atualização da tabela do banco
  ### Exemplo para a criar uma query de Atualização em uma linha da tabela do Banco de Dados
  Exemplo:
        UPDATE cidades set 
        cidades_nome = 'Ceres', 
        cidades_uf = 'GO'
        WHERE cidades_id = 1
  */
//   public function update($where,$values){
//     //Dados da query
//     $fields = array_keys($values);

//     //Monta a query
//     $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    
//     //EXECUTAR A QUERY
//     $this->execute($query,array_values($values));

//     //RETORNA SUCESSO
//     return true;
//   }
/*
  #####  D- Delete : Método responsável por remover dados da tabela do banco
  Exemplo:
  
  delete from cidades
  where cidades_id = 1

*/
//   public function delete($where){
//     //Monta a query
//     $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
    
//     //Executa a query
//     $this->execute($query);
    
//     //Retorna verdadeiro caso tenha sucesso na exclusão
//     return true;
//   }

}

//Testando a Classe da Conexão com o BD e o CRUD

// instancia o banco de dados - (Parametros: Nome tabela)
$table = 'cidades';
$con = new Crud($table);
/*
Retorno de dados
  - PDO::FETCH_OBJ - para retornar os resultados em um objeto
  - PDO::FETCH_ASSOC - para retornar os resultados em um array associativo
*/
//

// # C - Create
// $values = array(
//   'cidades_nome' => 'Rialma',
//   'cidades_uf' => 'GO'
// );
// $create  = ($con)->insert($values);

// var_dump($create);

// # R - Read
$read = ($con)->select()->fetchAll(PDO::FETCH_OBJ);
var_dump($read);

// // Caso use PDO::FETCH_OBJ
// foreach($read as $key=>$value){
//   echo "{$read[$key]->cidades_id} - 
//         {$read[$key]->cidades_nome} - 
//         {$read[$key]->cidades_uf}<br/>";
// }

// // Caso use PDO::FETCH_ASSOC
// // foreach($read as $key=>$value){
// //   echo "{$read[$key]['cidades_id']} - 
// //         {$read[$key]['cidades_nome']} - 
// //         {$read[$key]['cidades_uf']}<br/>";
// // }

// # U - Update

// $values = array(
//   'cidades_nome' => 'Rialma2',
//   'cidades_uf' => 'GO'
// );
// $update = ($con)->update('cidades_id = 2',$values);

// # D - Delete
// $delete = ($con)->delete('cidades_id = 1');