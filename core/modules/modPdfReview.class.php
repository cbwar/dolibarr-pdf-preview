<?php

/*
 *  Copyright (C) 2016      Lachhab Ismail <lachhab.ismail@gmail.com>
 */

include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module MyModule
 */
class modPdfReview extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;
		$this->db = $db;
		$this->numero = 7104065;	
		$this->rights_class = 'pdfreview';
		$this->special = 0; // Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->family = "crm"; // Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = $langs->trans("PdfReviewDescription");
		$this->editor_name = 'Lachhab Ismail';
		$this->editor_url = 'lachhab.ismail@gmail.com';
		$this->version = '1.0';
		$this->langfiles = array("messages@pdfreview");
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Config pages. Put here list of php page, stored into pdfreview/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@pdfreview");
		$this->module_parts = array(
			'css' => array(
					'/pdfreview/css/pdfreview.css',
					'/pdfreview/js/text_layer_builder.css'
					),
			'js' => array(
				'/pdfreview/js/pdfjs-1.6.210/web/compatibility.js',
				'/pdfreview/js/pdfjs-1.6.210/build/pdf.worker.js',
				'/pdfreview/js/pdfjs-1.6.210/build/pdf.js',
				'/pdfreview/js/text_layer_builder.js',
				'/pdfreview/js/pdfreview.js.php'
			),
		);

		if (!isset($conf->pdfreview) || !isset($conf->pdfreview->enabled))
        {
        	$conf->pdfreview = new stdClass();
        	$conf->pdfreview->enabled = 0;
        }
	}
}