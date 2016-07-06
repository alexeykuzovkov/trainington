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
				"PrinterTypeID"=>array("row"=>"PrinterTypeID", "type"=>'i', "operator"=>"="),
				"DpiID"=>array("row"=>"DpiID", "type"=>'i', "operator"=>"="),
				"WindingID"=>array("row"=>"WindingID", "type"=>'i', "operator"=>"="),
				"PrintingTypeID"=>array("row"=>"PrintingTypeID", "type"=>'i', "operator"=>"="),
				"ModelID"=>array("row"=>"ModelID", "type"=>'i', "operator"=>"="),
				"VendorID"=>array("row"=>"VendorID", "type"=>'i', "operator"=>"="),
				"DisplayTypeID"=>array("row"=>"DisplayTypeID", "type"=>'i', "operator"=>"=")
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