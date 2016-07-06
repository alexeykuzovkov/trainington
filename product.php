<?php
	include_once('controller.php');

	class ProductController extends Controller {
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

			
			
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Модель продукта');
	 		include_once("View/ProductView.php");
		}
	}

	$index = new ProductController();
?>