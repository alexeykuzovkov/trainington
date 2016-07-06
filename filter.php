<?php
	include_once('controller.php');

	class FilterController extends Controller {
		function __construct()
		{
			parent::__construct();

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
				$this->minMaxRows[$key] = $this->backend->getAllRowVariants("$key");
			}

			$this->Displaytypes = $this->backend->getDisplaytypes();
			$this->Dpis = $this->backend->getDpis();
			$this->PrinterTypes = $this->backend->getPrinterTypes();
			$this->PrintingTypes = $this->backend->getPrintingTypes();
			$this->Windings = $this->backend->getWindings();


			$parametersWithTypes = array(
				"CountTicketsMin"=>array("row"=>"CountTickets", "type"=>'i', "operator"=>">="),
				"CountTicketsMax"=>array("row"=>"CountTickets", "type"=>'i', "operator"=>"<="),

				"SpeedMin"=>array("row"=>"Speed", "type"=>'i', "operator"=>">="),
				"SpeedMax"=>array("row"=>"Speed", "type"=>'i', "operator"=>"<="),

				"UseKnife"=>array("row"=>"UseKnife", "type"=>'i', "operator"=>"="),
				"UseSeparator"=>array("row"=>"UseSeparator", "type"=>'i', "operator"=>"="),
				"UseEthernet"=>array("row"=>"UseEthernet", "type"=>'i', "operator"=>"="),
				"Price"=>array("row"=>"Price", "type"=>'i', "operator"=>"="),
				
				"DiamSleeveTicketMin"=>array("row"=>"DiamSleeveTicket", "type"=>'d', "operator"=>">="),
				"DiamSleeveTicketMax"=>array("row"=>"DiamSleeveTicket", "type"=>'d', "operator"=>"<="),

				"MaxDiamRollTicketMin"=>array("row"=>"MaxDiamRollTicket", "type"=>'i', "operator"=>">="),
				"MaxDiamRollTicketMax"=>array("row"=>"MaxDiamRollTicket", "type"=>'i', "operator"=>"<="),

				"DiamSleeveRibbonMin"=>array("row"=>"DiamSleeveRibbon", "type"=>'i', "operator"=>">="),
				"DiamSleeveRibbonMax"=>array("row"=>"DiamSleeveRibbon", "type"=>'i', "operator"=>"<="),

				"MaxWoundRibbonMin"=>array("row"=>"MaxWoundRibbon", "type"=>'i', "operator"=>">="),
				"MaxWoundRibbonMax"=>array("row"=>"MaxWoundRibbon", "type"=>'i', "operator"=>"<="),

				"MaxPrintingWidthMin"=>array("row"=>"MaxPrintingWidth", "type"=>'i', "operator"=>">="),
				"MaxPrintingWidthMax"=>array("row"=>"MaxPrintingWidth", "type"=>'i', "operator"=>"<="),

				"UseWinder"=>array("row"=>"UseWinder", "type"=>'i', "operator"=>"="),
				"SKU"=>array("row"=>"SKU", "type"=>'s', "operator"=>"="),
				"PrinterTypes"=>array("row"=>"PrinterTypeID", "type"=>'array', "operator"=>"="),

				"DPI"=>array("row"=>"DpiID", "type"=>'array', "operator"=>"="),

				"Windings"=>array("row"=>"WindingID", "type"=>'array', "operator"=>"="),
				"PrintingTypes"=>array("row"=>"PrintingTypeID", "type"=>'array', "operator"=>"="),
				"ModelID"=>array("row"=>"ModelID", "type"=>'i', "operator"=>"="),
				"VendorID"=>array("row"=>"VendorID", "type"=>'i', "operator"=>"="),
				"DisplayTypes"=>array("row"=>"DisplayTypeID", "type"=>'array', "operator"=>"=")
			);

			$get = $this->parseMultipleGET(array_keys($parametersWithTypes));

			foreach ($get as $key => $value) {
				if ($value!=false) $this->backend->addWhereParameter($parametersWithTypes[$key]["row"], $value, $parametersWithTypes[$key]["type"], $parametersWithTypes[$key]["operator"]);
			}

			$this->resultPrinters = $this->backend->getData();
			
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Поиск');
	 		include_once("View/FilterView.php");
		}
	}

	$index = new FilterController();
?>