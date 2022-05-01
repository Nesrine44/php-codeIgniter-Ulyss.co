<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('telecharger_facture')) {

    function telecharger_facture($html_data, $file_name = "",$footer,$header) {
        if ($file_name == "") {
            $file_name = 'report' . date('dMY');
        }

        require 'mpdf.php';
        $mypdf = new mPDF('utf-8','A4');
        $mypdf->setAutoTopMargin = 'stretch'; 
        $mypdf->setAutoBottomMargin = 'stretch';
        $mypdf->SetHTMLFooter($footer);
        $mypdf->SetHTMLheader($header);
        $mypdf->setAutoBottomMargin = false;
 
        $mypdf->WriteHTML($html_data);
        $mypdf->Output($file_name . '.pdf', 'D');
    }

}

?>