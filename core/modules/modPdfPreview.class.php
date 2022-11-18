<?php
require_once dirname(__DIR__, 2) . '/bootstrap.php';
require_once DOL_DOCUMENT_ROOT . '/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module MyModule
 */
class modPdfPreview extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		parent::__construct($db);

		$moduleDir = basename(dirname(__DIR__, 2));

		$this->numero = 7104065;
		$this->rights_class = 'pdfpreview';
		$this->special = 0; // Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->family = 'financial'; // Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		$this->name = 'PDF Preview';
		$this->description = 'Rendu des fichiers PDF dans les factures';
		$this->editor_name = 'Lachhab Ismail, Lisch Raphael';
		$this->editor_url = 'lachhab.ismail@gmail.com, raphael.lisch@gmail.com';
		$this->version = '1.1';
		$this->langfiles = array('messages@pdfpreview');
		$this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
		// Config pages. Put here list of php page, stored into pdfpreview/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@$moduleDir");
		$this->module_parts = array(
			'css' => array(
				"/$moduleDir/css/pdfpreview.css",
			),
			'js' => array(
				"/$moduleDir/js/pdfpreview.js.php"
			),
		);

	}
}
