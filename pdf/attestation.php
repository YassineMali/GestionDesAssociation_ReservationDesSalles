<?php
SESSION_START();
if(!isset($_SESSION['login']))
{
header("Location:login.php");
}
use setasign\Fpdi;
use setasign\tcpdf;
if(isset($_POST["nom"]) && $_GET["clic"] && !empty($_POST["nom"]))
{
    $clic = $_GET["clic"];
    $nom=$_POST["nom"];
    

    require_once 'vendor/autoload.php';
    require_once 'vendor/setasign/tcpdf/tcpdf.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    set_time_limit(2);
    date_default_timezone_set('UTC');
    $start = microtime(true);

    $pdf = new Fpdi\TcpdfFpdi();

    // set some language dependent data:
    $lg = Array();
    $lg['a_meta_charset'] = 'UTF-8';
    $lg['a_meta_dir'] = 'rtl';
    $lg['a_meta_language'] = 'fa';
    $lg['w_page'] = 'page';

    // set some language-dependent strings (optional)
    $pdf->setLanguageArray($lg);



    $pdf->AddPage();
    $pages = $pdf->setSourceFile('attestation.pdf');
    $page=$pdf->importPage($pages, '/MediaBox');
    $pdf->useTemplate($page, 0, 0);

    $pdf->SetFont('dejavusanscondensedb', '', 15);
    $pdf->Ln(80);
    $pdf->Write(0, "السيد(ة): ".$nom ."\n", '','','C');

    $pdf->SetFont('aefurat', '', 13);
    $pdf->Ln(4);
    $pdf->Cell(148);
    $pdf->Cell(0, 10,date('Y'));
    $pdf->Ln(30);
    $html='
    <style>
    
      .mg {
        width:20% !important;

      }
      
      </style>
    ';
   
    for($i = 1; $i <=$clic;$i++) {
      if(!empty($_POST[$i]) or !empty($_POST[$i."_"])){
        $j=$_POST[$i];
        $j_=$_POST[$i."_"];

       $html.='<div>- '.$j.' - '.$j_.'</div>';
      } 
        //$pdf->Write(0, "* ".$j." - ".$j_."\n", '','','R');
    }
    //$pdf->Cell(30);
    $pdf->SetMargins(25,0, 30, true);

    $pdf->WriteHTML($html);	

    $pdf->Output($nom.".pdf");
    
//-----------------------------------------
}
else{
    header("Location:../formation.php");

}
?>