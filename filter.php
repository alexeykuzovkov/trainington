<?php
	include_once('controller.php');

	class FilterController extends Controller {
		function __construct()
		{
			parent::__construct();

			$this->Displaytypes = $this->backend->getDisplaytypes();
			$this->Dpis = $this->backend->getDpis();
			$this->PrinterTypes = $this->backend->getPrinterTypes();
			$this->PrintingTypes = $this->backend->getPrintingTypes();
			$this->Windings = $this->backend->getWindings();
			$this->Vendors = $this->backend->getVendors();
			$this->ModelTypes = $this->backend->getModelTypes();


			$parametersWithTypes = array(
				"UseKnife"=>array("row"=>"UseKnife", "type"=>'i', "operator"=>"="),
				"UseSeparator"=>array("row"=>"UseSeparator", "type"=>'i', "operator"=>"="),
				"UseEthernet"=>array("row"=>"UseEthernet", "type"=>'i', "operator"=>"="),
				"Price"=>array("row"=>"Price", "type"=>'i', "operator"=>"="),

				"UseWinder"=>array("row"=>"UseWinder", "type"=>'i', "operator"=>"="),
				"SKU"=>array("row"=>"SKU", "type"=>'s', "operator"=>"="),
				"PrinterTypes"=>array("row"=>"PrinterTypeID", "type"=>'array', "operator"=>"="),

				"DPI"=>array("row"=>"DpiID", "type"=>'array', "operator"=>"="),

				"Windings"=>array("row"=>"WindingID", "type"=>'array', "operator"=>"="),
				"PrintingTypes"=>array("row"=>"PrintingTypeID", "type"=>'array', "operator"=>"="),
				"ModelID"=>array("row"=>"ModelID", "type"=>'i', "operator"=>"="),
				"Vendors"=>array("row"=>"VendorID", "type"=>'array', "operator"=>"="),
				"DisplayTypes"=>array("row"=>"DisplayTypeID", "type"=>'array', "operator"=>"="),
				"ModelTypes"=>array("row"=>"ModelTypeID", "type"=>'array', "operator"=>"=")
			);

			$this->minMaxRows = array(
				"CountTickets"=>array(),
				"Speed"=>array(),
				"DiamSleeveTicket"=>array(),
				"MaxDiamRollTicket"=>array(),
				"DiamSleeveRibbon"=>array(),
				"MaxWoundRibbon"=>array(),
				"MaxPrintingWidth"=>array()
			);

			foreach ($this->minMaxRows as $key => $value) {
				$this->minMaxRows[$key] = $this->backend->getVariantsForRow("$key");

				$parametersWithTypes[$key."Min"] = array("row"=>"$key", "type"=>'d', "operator"=>">=");
				$parametersWithTypes[$key."Max"] = array("row"=>"$key", "type"=>'d', "operator"=>"<=");
			}

			$this->allGet = $this->parseMultipleGET(array_keys($parametersWithTypes));

			foreach ($this->allGet as $key => $value) {
				if ($value!=-1) $this->backend->addWhereParameter($parametersWithTypes[$key]["row"], $value, $parametersWithTypes[$key]["type"], $parametersWithTypes[$key]["operator"]);
			}

			$this->resultPrinters = $this->backend->getData();
			
			if($this->isAjax) {
				echo count($this->resultPrinters);
				return;
			}
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Поиск');
	 		include_once("View/FilterView.php");
		}
	}

	$index = new FilterController();
?>