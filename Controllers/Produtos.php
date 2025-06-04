<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Produtos{

    private $produtos;
    private $categorias;
    private $data;

    
    function __construct(){
        $this->produtos = new Conexao('produtos');
        $this->categorias = new Conexao('categorias');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    // Chama o formulário de cadastro
    function new(){
        $this->data['categorias'] = $this->categorias->select($join=null,
         $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['produtos'] = (object) [
            'produtos_id' => '',
            'produtos_nome' => '',
            'produtos_descricao' => '',
            'produtos_preco_custo' => '',
            'produtos_preco_venda' => '',
            'produtos_categorias_id' => '',
        ];
        $this->data['pagina'] = 'Cadastrar produtos';
        $this->data['method'] = 'save';
        return view('produtos/form',$this->data);
    }

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'produtos_nome'=> $requests['produtos_nome'],
            'produtos_descricao'=> $requests['produtos_descricao'],
            'produtos_preco_custo'=> $requests['produtos_preco_custo'],
            'produtos_preco_venda'=> $requests['produtos_preco_venda'],
            'produtos_categorias_id'  => $requests['produtos_categorias_id']
            ];

        if(($this->produtos)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        Produtos::redirect(base_url('produtos'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $join = 'categorias on produtos_categorias_id = categorias_id';
        $this->data['produtos'] = ($this->produtos)->select($join, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar produtos';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('produtos/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['categorias'] = $this->categorias->select($join=null,
         $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['produtos'] = ($this->produtos)->select($join=null,'produtos_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar produtos';
        $this->data['method'] = 'edit_save';

        return view('produtos/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'produtos_nome like "%'.$requests['pesquisar'].'%" 
                      or produtos_descricao like "%'.$requests['pesquisar'].'%"'; 
            $this->data['produtos'] = ($this->produtos)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['produtos']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar produtos';
            return view('produtos/index',$this->data);

        }else{
            Produtos::redirect(base_url('produtos'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'produtos_nome'=> $requests['produtos_nome'],
                    'produtos_descricao'=> $requests['produtos_descricao'],
                    'produtos_preco_custo'=> $requests['produtos_preco_custo'],
                    'produtos_preco_venda'=> $requests['produtos_preco_venda'],
                    'produtos_categorias_id'  => $requests['produtos_categorias_id']
                ];

        if($this->produtos->update('produtos_id = '.$requests['produtos_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        Produtos::redirect(base_url('produtos'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->produtos)->delete('produtos_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        Produtos::redirect(base_url('produtos'),$msg);

    }
    

    
}


// $dados = new Produtos();
// print_r($dados->index());


