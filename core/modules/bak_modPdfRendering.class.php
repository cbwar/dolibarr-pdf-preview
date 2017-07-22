<?php

/*
 *  Copyright (C) 2016      Lachhab Ismail <lachhab.ismail@gmail.com>
 */

include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module MyModule
 */
class modPdfRendering extends DolibarrModules
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
		$this->rights_class = 'pdfrendering';
		$this->special = 0; // Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->family = "crm"; // Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = $langs->trans("PdfRenderingDescription");
		$this->editor_name = 'Lachhab Ismail';
		$this->editor_url = 'lachhab.ismail@gmail.com';
		$this->version = '1.0';
		$this->langfiles = array("messages@pdfrendering");
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Config pages. Put here list of php page, stored into pdfreview/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@pdfreview");
		$this->module_parts = array(
			'css' => array(
					'/pdfrendering/css/pdfrendering.css',
					'/pdfrendering/js/text_layer_builder.css'
					),
			'js' => array(
				'/pdfrendering/js/pdfjs-1.6.210/web/compatibility.js',
				'/pdfrendering/js/pdfjs-1.6.210/build/pdf.worker.js',
				'/pdfrendering/js/pdfjs-1.6.210/build/pdf.js',
				'/pdfrendering/js/text_layer_builder.js',
				'/pdfrendering/js/pdfrendering.js'
			),
		);

		if (!isset($conf->pdfrendering) || !isset($conf->pdfrendering->enabled))
        {
        	$conf->pdfrendering = new stdClass();
        	$conf->pdfrendering->enabled = 0;
        }
	}
}