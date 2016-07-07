<?php
	#Подключение корневого класса контроллера
	include_once('controller.php');

	/**
	 * Класс контроллера главного меню
	 */

	class IndexController extends Controller {
		/**
		 * Конструктор
		 */
		function __construct()
		{
			parent::__construct();
			if ($this->isAjax) {
				//echo "shit";
				if (isset($_GET['search'])) {
					$search = $_GET['search'];
					error_log("shit".$search);
					$Vendors = $this->backend->searchVendors($search);
					$SKU = $this->backend->searchSKU($search);
					$DPI = $this->backend->searchDPI($search);
					$Disp = $this->backend->searchDisplayTypes($search);
					$Model = $this->backend->searchModelName($search);
					$ModelTypes = $this->backend->searchModelTypes($search);
					$PrintingType = $this->backend->searchPrintingTypes($search);

					echo json_encode(array_merge ($Model,$ModelTypes,$PrintingType,$Vendors, $SKU, $DPI,$Disp));
				}
				
				return;
			}
			$this->showPage();
		}

		/**
		 * Функция формирования страниц главного меню
		 */
		private function showPage() {
	 		$this->setPageTitle('Главная');
	 		include_once("View/MainView.php");
		}
	}

	$index = new IndexController();
?>