<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename='', $stream=TRUE, $attach = 1)  {
	
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html('<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => $attach)); 
    } else {
        return $dompdf->output();
    }
	
}
?>
