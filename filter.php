<?php
	include_once('controller.php');

	class FilterController extends Controller {
		function __construct()
		{
			parent::__construct();

			$parametersWithTypes = array(
				"CountTickets"=>'i',
				"Speed"=>'i',
				"UseKnife"=>'i',
				"UseSeparator"=>'i',
				"UseEthernet"=>'i',
				"Price"=>'i',
				"DiamSleeveTicket"=>'i',
				"MaxDiamRollTicket"=>'i',
				"DiamSleeveRibbon"=>'i',
				"MaxWoundRibbon"=>'i',
				"MaxPrintingWidth"=>'i',
				"UseWinder"=>'i',
				"SKU"=>'s',
				"PrinterType"=>'s',
				"DPI"=>'i',
				"Winding"=>'s',
				"PrintingType"=>'s',
				"ModelName"=>'s',
				"VendorName"=>'s',
				"DisplayTypeName"=>'s'
			);

			$get = $this->parseMultipleGET(array_keys($parametersWithTypes));

			foreach ($get as $key => $value) {
				if ($value!=false) $this->backend->addWhereParameter($key, $value, $parametersWithTypes[$key]);
			}

			$result = $this->backend->runQuery();
			print_r($result);
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Поиск');
	 		include_once("View/FilterView.php");
		}
	}

	$index = new FilterController();
?>