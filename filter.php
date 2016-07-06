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
				"PrinterTypeID"=>'i',
				"DpiID"=>'i',
				"WindingID"=>'i',
				"PrintingTypeID"=>'i',
				"ModelID"=>'i',
				"VendorID"=>'i',
				"DisplayTypeID"=>'i'
			);

			$get = $this->parseMultipleGET(array_keys($parametersWithTypes));

			foreach ($get as $key => $value) {
				if ($value!=false) $this->backend->addWhereParameter($key, $value, $parametersWithTypes[$key]);
			}
			$result = $this->backend->getData();
			
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Поиск');
	 		include_once("View/FilterView.php");
		}
	}

	$index = new FilterController();
?>