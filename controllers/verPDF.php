<?php 


    if (isset($_REQUEST["action"]) && !empty($_REQUEST["action"])) {
        if($_REQUEST["action"] == 'verPDF'){
            require 'funciones.php';
            $cabeceras = array('g.monto'=>'Monto', 'g.fecha'=> 'Fecha', 'g.observaciones'=> 'Observaciones','tg.descripcion'=> 'Descripcion',);  
            $params = json_decode(exportarPDF($_REQUEST["idMes"], $_REQUEST["id"]),true);                        
            CrearPDF($params);
        }
    }


    function CrearPDF($params)
    {
        require 'fpdf/fpdf.php';        
        class PDF extends FPDF
        {
            // Page header
            function Header()
            {
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                $mesActual = $meses[date('n')-1];
                // Logo
                //$this->Image('logo.png',10,-1,70);
                $this->SetFont('Arial','B',13);
                // Move to the right
                $this->Cell(80);
                // Title
                $this->Cell(45,10,'Listado de Gastos',2,0,'C');
                //$this->Cell(45,10,'Listado de Gastos correspondiente al Mes de '.$mesActual,2,0,'C');
                // $this->Cell(50,10,'Mes de: '.$mesActual,2,0,'C');
                // Line break
                $this->Ln(20);
                // $this->Cell(45,15,'Monto',1,0,'C');
                // $this->Cell(45,15,'Fecha',1,0,'C');
                // $this->Cell(45,15,'Obs',1,0,'C');
                // $this->Cell(45,15,'Tipo',1,0,'C');
                // $this->Ln(20);
            }
            function Footer()
            {
                $dia = strftime("%u");
                switch ($dia) {
                    case 1:
                    $dia =  "Lunes";
                    break;
                    case 2:
                    $dia =  "Martes";
                    break;
                    case 3:
                    $dia =  "Miercoles";
                    break;
                    case 4:
                    $dia =  "Jueves";
                    break;
                    case 5:
                    $dia =  "Viernes";
                    break;
                    case 6:
                    $dia =  "Sabado";
                    break;
                    case 7:
                    $dia =  "Domingo";
                    break;
                    default:
                        # code...
                    break;
                }
                //move pionter at the bottom of the page
                $this->SetY( -15 );
                //set font to Arial, Bold, size 10
                $this->SetFont( 'Arial', '', 8 );
                date_default_timezone_set('America/Santiago');
                setlocale(LC_ALL,"es_CL");
                $horaActual = localtime(time());//[2]-6;
                $minutoActual = localtime(time());//[1];
                $this->Cell(0,4,"Exportado en: ".(utf8_decode($dia.strftime(" %d de %B de %Y "))).($horaActual[2]).":".$minutoActual[1],0,1,"C");
                //write Page No
                //$this->Cell(0,4,'Pagina '. $this->PageNo()."/"."{nb}",0,0,'C');
                $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
            }
        }
        $pdf=new PDF();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','',10);
        foreach($params as $row) {            
            $pdf->Ln();
            foreach($row as $column)            
            $pdf->Cell(45,12,utf8_decode($column),1);
            //$pdf->Cell()
            //$pdf->Cell(60, 12, utf8_decode($column), 1,0, "C");
        }
        $pdf->Output();


    }
?>