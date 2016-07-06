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