<?php
/**
 * Class Pdf2
 * Classe para gerar arquivos do tipo PDF
 *
 * @author Rogério Mantoanelli
 * @version 1.0
 * @copyright Savoir Tecnologia 2011
 * @access public
 * @package system/application/libraries
 */
class Pdf {
    
    /**
     * Variavel que se refere ao objeto pdf que será criado
     * 
     * @access public
     * @name $_pdf
     */
	public $_pdf;

    /**
     * Construtor
     */
    public function  __construct() {
            require_once('tcpdf/config/lang/eng.php');
            require_once('tcpdf/tcpdf.php');
            $this->_path = dirname(__FILE__).'/tcpdf/'; 
    }
    
    /**
     * Inicia o pdf
     * 
     * @access public
     * @param string $title 
     * @return void
     */
    public function create($title = ""){
        // create new PDF document
		$this->_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$this->_pdf->SetCreator(PDF_CREATOR);

		// set default header data
		$this->_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. " - {$title}", PDF_HEADER_STRING);

		// set header and footer fonts
		$this->_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->_pdf->SetFont('helvetica', '', 10);
        $this->_pdf->AddPage();
    }

    /**
     * Adiciona nova paginá no pdf com conteudo
     * 
     * @access public
     * @param string $html 
     * @return void
     */
    public function addPage($html){
        $this->_pdf->AddPage();
		$this->_pdf->writeHTML($html, true, false, true, false, '');
		$this->_pdf->lastPage();
    }
    
    /**
     * Escreve conteudo no pdf
     * 
     * @access public
     * @param string $html
     * @return void 
     */
    public function write($html){
        $this->_pdf->writeHTML($html, true, false, true, false, '');
    }
    
    /**
     * Exibe ou faz o Download do pdf
     * 
     * @access public
     * @param string $name
     * @param string $type
     * @return void 
     */
    public function output($name,$type="F"){
		$this->_pdf->Output($name.'.pdf', $type);
	}
}
