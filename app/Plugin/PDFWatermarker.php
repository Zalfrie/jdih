<?php

namespace App\Plugin;

use \fpdi\FPDI;

class PDFWatermarker {
	
	private $_originalPdf;
	private $_newPdf;
	private $_tempPdf;
	private $_watermark;
	private $_imagePositionOutput;
	
	public function __construct($originalPdf,$newPdf,$watermark) {
		
		$this->_originalPdf = $originalPdf;
		$this->_newPdf = $newPdf;
		$this->_tempPdf = new FPDI();
		$this->_watermark = $watermark;
		
		$this->_validateAssets();
		
		$this->setWatermarkPosition();
	}
	
	private function _validateAssets() {
		
		if ( !file_exists( $this->_originalPdf ) ) {
			throw new \Exception("Inputted PDF file doesn't exist");
		}
		else if ( !file_exists( $this->_watermark->getFilePath() ) ) {
			throw new \Exception("Watermark doesn't exist.");
		}
		
	}
	
	/**
	* $position string -  'center','topright', 'topleft', 'bottomright', 'bottomleft'
	*/
	public function setWatermarkPosition($position="center") {
		$this->_imagePositionOutput = $position;
	}
	
	private function _watermarkPdf() {
		$pageCtr = $this->_tempPdf->setSourceFile($this->_originalPdf);
		for($ctr = 1; $ctr <= $pageCtr; $ctr++){
			$this->_watermarkPage($ctr);
		}
	}
	
	private function _watermarkPage($page_number) {
		$templateId = $this->_tempPdf->importPage($page_number);
		$templateDimension = $this->_tempPdf->getTemplateSize($templateId);
		
		if ( $templateDimension['w'] > $templateDimension['h'] ) {
			$orientation = "L";
		}
		else {
			$orientation = "P";
		}
		
		$this->_tempPdf->addPage("P",array($templateDimension['w'],$templateDimension['h']));
		$this->_tempPdf->useTemplate($templateId);
		
		$wWidth = ($this->_watermark->getWidth() / 96) * 25.4; //in mm
		$wHeight = ($this->_watermark->getHeight() / 96) * 25.4; //in mm
		
		$watermarkPosition = $this->_determineWatermarkPosition( 	$wWidth, 
																	$wHeight, 
																	$templateDimension['w'], 
																	$templateDimension['h']);
		$this->_tempPdf->Image($this->_watermark->getFilePath(),$watermarkPosition[0],$watermarkPosition[1],-96);
	}
	
	private function _determineWatermarkPosition( $wWidth, $wHeight, $tWidth, $tHeight ) {
		
		switch( $this->_imagePositionOutput ) {
			case 'topleft': 
				$x = 0;
				$y = 0;
				break;
			case 'topright':
				$x = $tWidth - $wWidth;
				$y = 0;
				break;
			case 'bottomright':
				$x = $tWidth - $wWidth;
				$y = $tHeight - $wHeight;
				break;
			case 'bottomleft':
				$x = 0;
				$y = $tHeight - $wHeight;
				break;
			default:
				$x = ( $tWidth - $wWidth ) / 2 ;
				$y = ( $tHeight - $wHeight ) / 2 ;
				break;
		}
		
		return array($x,$y);
	}
	
	public function watermarkPdf($output = 'D') {
		$this->_watermarkPdf();
		return $this->_tempPdf->Output($this->_newPdf, $output);
	}
}