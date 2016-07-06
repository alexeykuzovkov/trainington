<?php
	include_once('controller.php');

	class ProductController extends Controller {
		public $result;
		public $parametersWithTranslate;

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

			$this->parametersWithTranslate = array(
				"RowID"=>'АйДи Приблуды',
				"CountTickets"=>'Кол-во этикеток',
				"Speed"=>'Скорость печати',
				"UseKnife"=>'Наличие ножа',
				"UseSeparator"=>'Наличие отделителя',
				"UseEthernet"=>'Наличие Ethernet',
				"Price"=>'Цена',
				"DiamSleeveTicket"=>'Диаметр втулки этикетки',
				"MaxDiamRollTicket"=>'Максимальный диаметр рулона этикеток',
				"DiamSleeveRibbon"=>'Диаметр втулки риббона',
				"MaxWoundRibbon"=>'Максимальная намотка риббона',
				"MaxPrintingWidth"=>'Максимальная ширина печати',
				"UseWinder"=>'Наличие смотчика',
				"SKU"=>'Парт номер',
				"PrinterType"=>'Тип принтера',
				"DPI"=>'DPI',
				"Winding"=>'Намотки',
				"PrintingType"=>'Тип печати',
				"ModelName"=>'Модель',
				"VendorName"=>'Производитель',
				"DisplayTypeName"=>'Дисплей',

				"Direct Thermal"=>'DT',
				"Thermal Transfer"=>'TT',
				"DT & TT"=>'DT&TT',
				"Dot Matrix"=>'Матричный',
				"Mobile"=>'Мобильный',
				"Desktop"=>'Настольный',
				"Industrial"=>'Промышленный',
				"1"=>"Есть",
				"0"=>"Нет",
				1=>"Есть",
				0=>"Нет",

				"in"=>"Внутренняя",
				"out"=>"Наружная",
				"all"=>"Внутренняя и наружная",
				"no winding"=>"Нет"
			);
			$id=$this->parseGETParameter('id');
			$id=10;
			$this->backend->addWhereParameter('RowID', $id, 'i');
			$this->result=$this->backend->getData()[0];
			
			$this->showPage();
		}

		private function showPage() {
	 		$this->setPageTitle('Модель продукта');
	 		include_once("View/ProductView.php");
		}
	}

	$index = new ProductController();
?>