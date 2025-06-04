<?php
// https://www.fpdf.org/

require_once('Libraries/fpdf/fpdf.php');
echo base_url('public/assets/images/logo_bargain1.png');

class RelatorioPDF extends FPDF
{
    function Header()
    {
        $logoWidth = 50; // Largura da logo
        $pageWidth = $this->GetPageWidth(); // Largura total da página
        $x = ($pageWidth - $logoWidth) / 2; // Calcula posição X centralizada

        $this->Image('public/assets/images/logo_bargain1.png', $x, 6, $logoWidth); // Centralizado
        $this->Ln(10);
    }

    function Footer()
    {
        $text1 = mb_convert_encoding('Página', 'ISO-8859-1', 'UTF-8');
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, $text1 . $this->PageNo() . '/{nb}', 0, 0, 'C');
        
    }
}
