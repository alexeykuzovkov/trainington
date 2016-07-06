<?php
/**
 * Корневой класс контроллера
 */
class Controller
{

	#Экзампляр класса backend (для взаимодействия с БД)
	protected $backend;
	#Название страницы
	protected $pageTitle;

	#Массив ключей get запроса
	protected $getKeys;
	#Массив ключей post запроса
	protected $postKeys;

	protected $isAjax;
	/**
	* Конструктор 
	**/
	function __construct($rootFolder = '')
	{
		$this->isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest') ? true:false;
		$this->backend = include('backend.php');
		$this->__ROOT = $rootFolder;
	}

	/**
	 * Setter methods
	 */
	
	protected function setPageTitle($value) {
		$this->pageTitle = $value;		
	}
	/**
	* Parser get запросов
	*/
	protected function parseGETParameter($parameter) {
		if (isset($_GET[$parameter])) return $_GET[$parameter];
		return false;
	}

	/**
	* Parser post запросов
	*/
	protected function parsePOSTParameter($parameter) {
		if (isset($_POST[$parameter])) return $_POST[$parameter];
		return false;
	}

	/**
	 * Парсер нескольких POST параметров
	 */
	protected function parseMultiplePOST($post) {
		$ret = array();

		foreach ($post as $value) {
			if (isset($_POST[$value])) $ret[$value] = $_POST[$value];
			else $ret[$value] = -1;
		}

		return $ret;
	}
	/**
	 * Парсер нескольких GET параметров
	 */

	protected function parseMultipleGET($get) {
		$ret = array();

		foreach ($get as $value) {
			if (isset($_GET[$value])) $ret[$value] = $_GET[$value];
			else $ret[$value] = -1;
		}

		return $ret;
	}

	/**
	* Получение ключей всех get запросов
	*/
	protected function allGET() {
		$getKeys = [];
		foreach ($_GET as $key => $value) {
			$getKeys[] = $key;
		}

		return $getKeys;
	}

	/**
	* Получение ключей всех post запросов
	*/
	protected function allPOST() {
		$postKeys = [];
		foreach ($_POST as $key => $value) {
			$postKeys[] = $key;
		}

		return $postKeys;
	}

	/**
	* Подключение файла в виде текста
	*/
	protected function includeAsText($link)
	{
		ob_start();
		include $link;
		return ob_get_clean();
	}

	protected function dateToPrintableDate($Date) {
		$datetime1 = new DateTime($Date);
		$string = $datetime1->format('d').' '.$this->getMonthByNumber($datetime1->format('m')).' '.$datetime1->format('Y').' года';
		return $string;
	}

	protected function getMonthByNumber($Month) {
		switch ($Month) {
			case "01":
			    return "января";
			case "02":
			    return "февраля";
			case "03":
			    return "марта";
			case "04":
			    return "апреля";
			case "05":
			    return "мая";
			case "06":
			    return "июня";
			case "07":
			    return "июля";
			case "08":
			    return "августа";
			case "09":
			    return "сентября";
			case "10":
			    return "октября";
			case "11":
			    return "ноября";
			case "12":
			    return "декабря";
		}
		return "Нет такого месяца в этой функции";
	}

	protected function convertPollCheckBox($value) {
		if ($value=="on") return 1;
		else return 0;		
	}

	protected function setToastNotification($text, $linkHref = false, $linkText = false) {
		if ($linkHref!=false && $linkText!=false) {
			$this->toastNotifications[] = array('text' => $text, 'link' => array('href' => $linkHref, 'text'=>$linkText));
		}
		else {
			$this->toastNotifications[] = array('text' => $text, 'link' => false);
		}
	}
}
