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
					$SKU = $this->backend->searchSKU($search);
					echo json_encode($SKU);
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
	 		include_once("View/MainView2.php");
		}
	}

	$index = new IndexController();
?>