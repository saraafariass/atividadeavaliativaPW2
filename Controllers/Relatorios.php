<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");
require_once('Libraries/RelatorioPDF.php');

use Models\Database as Conexao;
use \PDO;

class Relatorios {
    private $usuarios;
    public function __construct(){
        $this->usuarios = new Conexao('usuarios');
    }

    public function index()
    {
        
        $user = ($this->usuarios)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);

        #$user = $this->usuarios->index();

        // As medidas são definidas em mm (milimetros)
        $pdf = new \RelatorioPDF();
        $pdf->AliasNbPages(); // Ativa o contador total de páginas
        $pdf->SetMargins(25, 20, 25); // Margens esquerda, topo, direita
        $pdf->SetAutoPageBreak(true, 20);   // Margem inferior (para rodapé)
        $pdf->AddPage('P', 'A4'); // 'L' = Paisagem ou 'P' - Retrato | Medidas do A4 -> Largura: 210 mm x Altura: 297 mm

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, mb_convert_encoding('Relatório de Usuários', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->Ln(3);

        //cores
        $pdf->SetFillColor(220,220,220);  // Cor de fundo (cinza)
        $pdf->SetTextColor(0, 0, 0);  // Cor do texto (branco)
        $pdf->SetDrawColor(0, 0, 0);   // Cor da borda (preto)

        // Cabeçalho da Tabela
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'ID', 1, 0, 'L', true); //alinhamento do texto - > C: centro, R: direita, L: esquerda
        $pdf->Cell(70, 10, 'Nome', 1, 0, 'L', true);
        $pdf->Cell(70, 10, 'CPF', 1, 0, 'L',true);
        $pdf->Ln();



        // Conteúdo
        $pdf->SetFont('Arial', '', 12);
        foreach ($user as $relUser) {
            $pdf->Cell(20, 8, $relUser->usuarios_id, 1);
            $pdf->Cell(70, 8, mb_convert_encoding($relUser->usuarios_nome.' '.$relUser->usuarios_sobrenome, 'ISO-8859-1', 'UTF-8'), 1);
            $pdf->Cell(70, 8, mb_convert_encoding($relUser->usuarios_cpf, 'ISO-8859-1', 'UTF-8'), 1);
            $pdf->Ln();
        }

        ob_clean();
        $pdf->Output('I', 'RelatorioUsuarios.pdf');
        // F -> Faz o Download do arquivo .pdf
        // I -> Abre o .pdf no navegador
        exit;
    }
}
