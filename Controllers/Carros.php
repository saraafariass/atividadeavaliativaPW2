<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Carros {

    private $carros;
    private $data;

    function __construct() {
        $this->carros = new Conexao('carros');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    // Chama o formulário de cadastro
    function new() {
        $this->data['carros'] = (object) [
            'carros_id' => '',
            'carros_modelo' => '',
            'carros_ano_fabricacao' => '',
            'carros_ano_modelo' => '',
            'carros_tipo_combustivel' => '',
            'carros_placa' => '',
            'carros_cor' => '',
            'carros_quilometragem' => '',
            'carros_cambio' => '',
            'carros_preco_venda' => '',
            'carros_preco_fipe' => '',
            'carros_status' => 'Disponível',
            'carros_data_cadastro' => date('Y-m-d'),
            'marca_id' => ''
        ];
        $this->data['pagina'] = 'Cadastrar Carro';
        $this->data['method'] = 'save';
        return view('carros/form', $this->data);
    }

    // C - Cadastrar Carro
    function save() {
        $requests = $_REQUEST;

        // Validação básica da placa (formato ABC-1A34)
        if (!preg_match('/^[A-Z]{3}-\d{1}[A-Z]{1}\d{2}$/', $requests['carros_placa'])) {
            $msg = ['texto' => 'Placa inválida! Use o formato ABC-1A34.', 'color' => 'danger'];
            $this->redirect(base_url('carros/new'), $msg);
        }

        $values = [
            'carros_modelo' => $requests['carros_modelo'],
            'carros_ano_fabricacao' => $requests['carros_ano_fabricacao'],
            'carros_ano_modelo' => $requests['carros_ano_modelo'],
            'carros_tipo_combustivel' => $requests['carros_tipo_combustivel'],
            'carros_placa' => $requests['carros_placa'],
            'carros_cor' => $requests['carros_cor'],
            'carros_quilometragem' => $requests['carros_quilometragem'],
            'carros_cambio' => $requests['carros_cambio'],
            'carros_preco_venda' => $requests['carros_preco_venda'],
            'carros_preco_fipe' => $requests['carros_preco_fipe'],
            'carros_status' => $requests['carros_status'],
            'carros_data_cadastro' => $requests['carros_data_cadastro'],
            'marca_id' => $requests['marca_id']
        ];

        if ($this->carros->insert($values)) {
            $msg = ['texto' => 'Carro cadastrado com sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao cadastrar carro.', 'color' => 'danger'];
        }
        $this->redirect(base_url('carros'), $msg);
    }

    // R - Listar Carros
    function index() {
        $join = "JOIN marcas ON carros.marca_id = marcas.id";
        $this->data['carros'] = $this->carros->select($join)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar Carros';
        return view('carros/index', $this->data);
    }

    // R - Editar (exibir formulário)
    function edit($id) {
        $this->data['carros'] = $this->carros->select(null, 'carros_id = ' . $id)->fetchObject();
        $this->data['pagina'] = 'Editar Carro';
        $this->data['method'] = 'update';
        return view('carros/form', $this->data);
    }

    // U - Atualizar Carro
    function update() {
        $requests = $_REQUEST;
        $values = [
            'carros_modelo' => $requests['carros_modelo'],
            'carros_ano_fabricacao' => $requests['carros_ano_fabricacao'],
            'carros_ano_modelo' => $requests['carros_ano_modelo'],
            'carros_tipo_combustivel' => $requests['carros_tipo_combustivel'],
            'carros_placa' => $requests['carros_placa'],
            'carros_cor' => $requests['carros_cor'],
            'carros_quilometragem' => $requests['carros_quilometragem'],
            'carros_cambio' => $requests['carros_cambio'],
            'carros_preco_venda' => $requests['carros_preco_venda'],
            'carros_preco_fipe' => $requests['carros_preco_fipe'],
            'carros_status' => $requests['carros_status'],
            'carros_data_cadastro' => $requests['carros_data_cadastro'],
            'marca_id' => $requests['marca_id']
        ];

        if ($this->carros->update('carros_id = ' . $requests['carros_id'], $values)) {
            $msg = ['texto' => 'Carro atualizado!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao atualizar.', 'color' => 'danger'];
        }
        $this->redirect(base_url('carros'), $msg);
    }

    // D - Deletar Carro
    function delete($id) {
        if ($this->carros->delete('carros_id = ' . $id)) {
            $msg = ['texto' => 'Carro excluído!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao excluir.', 'color' => 'danger'];
        }
        $this->redirect(base_url('carros'), $msg);
    }

    // Pesquisar Carros
    function search() {
        $requests = $_REQUEST;
        if (isset($requests['pesquisar'])) {
            $where = 'carros_modelo LIKE "%' . $requests['pesquisar'] . '%"';
            $this->data['carros'] = $this->carros->select(null, $where)->fetchAll(PDO::FETCH_CLASS);
            $msg = ['texto' => 'Resultados para: ' . $requests['pesquisar'], 'color' => 'info'];
            $_SESSION['msg'] = $msg;
            return view('carros/index', $this->data);
        }
        $this->redirect(base_url('carros'));
    }
}