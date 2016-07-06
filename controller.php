<?php
/**
 * Корневой класс контроллера
 */
class Controller
{

	#Экзампляр класса backend (для взаимодействия с БД)
	protected $backend;
	#Название шаблона (no-sidebar, left-sidebar и.т.д.)
	protected $templateName;
	#Индикатор подключения страницы шаблона
	private $templatePageIncluded;
	#Название выбранного в данный момент пункта главного меню
	protected $selectedMenuItem;

	/**
	* Элементы шаблона
	**/

	#Название страницы
	protected $pageTitle;
	#Название ссылки
	protected $linkTitle;
	#Основное содержание
	protected $mainContent;
	#Следующая страничка (для входа)
	protected $nextPage;
	#Содержание левого сайдбара
	protected $leftSidebarContent;
	#Содержание правого сайдбара
	protected $rightSidebarContent;
	#Заголовок статьи
	protected $articleHeaderTitle;
	#Подзаголовок статьи
	protected $articleHeaderSubTitle;


	#Массив ключей get запроса
	protected $getKeys;
	#Массив ключей post запроса
	protected $postKeys;


	protected $sideMenu;
	protected $pageId;

	protected $isAjax;

	protected $config;
	/**
	* Конструктор 
	**/
	function __construct($rootFolder = '')
	{
		$this->backend = include('backend.php');
	}
/*	function __construct($rootFolder = '')
	{
		$this->isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest') ? true:false;

		$this->config = include('config.php');
		$tempName = $this->config['template'];

		$this->__ROOT = $rootFolder;
		$this->__TEMPR = $this->__ROOT.'templates/'.$tempName.'/';
		
		$this->localsJSON = $this->includeAsText($this->__ROOT."locals.json");
		$this->locals = json_decode($this->localsJSON, true);
		$this->lang = "ru";
		
		$this->setDefaults($tempName);
		$this->checkLogin();

		if (!$this->isAjax) {
			$this->createMainMenu();
			$this->checkEditMode();

			if ($this->logined) {
				$this->membershipInfo = $this->backend->getMembershipInfo($this->__SESSIONID);
				$this->allMembershipInfo = $this->backend->getAllMembershipInfo($this->__SESSIONID);
				$this->unpaidInfo = $this->backend->getUnpaidMembershipInfo($this->__SESSIONID);

				if (count($this->allMembershipInfo)>0) {
					$this->trainerID = $this->allMembershipInfo[0]['TrainerID'];
					$this->programExpiredDate = $this->allMembershipInfo[count($this->allMembershipInfo)-1]['Expired'];
					$this->programBeginDate = $this->allMembershipInfo[0]['Begined'];
					$this->membershipExpireSoon = false;
					$this->membershipBeginSoon = false;
					$datetime1 = new DateTime($this->programExpiredDate);
					$datetime2 = new DateTime(date('Y-m-d'));
					$interval = $datetime1->diff($datetime2);
					if((int)$interval->format('%R%a')>(-5) && count($this->allMembershipInfo)<2 && (int)$interval->format('%R%a')<0) {
						$this->membershipExpireSoon = true;
					}
					//if (!$this->membershipExpireSoon) {
						$datetime1 = new DateTime($this->programBeginDate);
						$datetime2 = new DateTime(date('Y-m-d'));
						$interval = $datetime1->diff($datetime2);
						if((int)$interval->format('%R%a')>(-5) && count($this->allMembershipInfo)<2 && (int)$interval->format('%R%a')<0) {
							$this->membershipBeginSoon = true;
						}
					//}
				}
			}
		}
		$this->myuserInfo = $this->backend->getBasicUserInfo($this->__SESSIONID);
		$this->mylevel = count($this->myuserInfo)>0 ? $this->myuserInfo[0]["userlevel"]:0;
		
		if (!$this->isAjax) $this->createSideMenu();

		$this->pageId = $this->parseGETParameter('id')==false ? $this->__SESSIONID : $this->parseGETParameter('id');
		$this->userInfo = $this->backend->getBasicUserInfo($this->pageId);
		$this->level = count($this->userInfo)>0?$this->userInfo[0]["userlevel"]:0;
	}
	//Простые getterы
	protected function getTrainerID() {
		return $this->trainerID;
	}
	protected function getProgramExpiredDate() {
		return $this->programExpiredDate;
	}
	protected function getProgramBeginDate() {
		return $this->programBeginDate;
	}*/

	/**
	* Установка значений по умолчанию 
	**/
	private function setDefaults($tempName) {
		$this->backend = include($this->__ROOT.'php/backend.php');
		$this->templateName = $tempName;
		$this->templatePageIncluded = false;
		$this->selectedMenuItem = 'main';

		$this->pageTitle = "";
		$this->mainContent = "";
		$this->leftSidebarContent ="";
		$this->rightSidebarContent = "";
		$this->articleHeaderTitle = "";
		$this->articleHeaderSubTitle = "";

		$this->errorMessage = '';
		$this->infoMessage = '';

		$this->getKeys = $this->allGET();
		$this->postKeys = $this->allPOST();
	}



	/** 
	 * Автоматичнское заполнение элементов шаблона из массива
	 */
	protected function fillPageData($arr) {
		$this->setPageTitle($arr['name']);
		$this->setMainContent($arr['content']);
		$this->setLeftSidebarContent($arr['contentLeft']);
		$this->setRightSidebarContent($arr['contentRight']);
		$this->setArticleHeaderTitle($arr['headerTitle']);
		$this->setArticleHeaderSubTitle($arr['headerSubTitle']);
	}


	/**
	 * Setter methods
	 */
	protected function setTemplateName($tempName) {
		$this->templateName = $tempName;
	}
	protected function setSelectedMenuItem($sel) {
		$this->selectedMenuItem = $sel;
	}
	protected function setPageTitle($value) {
		$this->pageTitle = $value;		
	}
	protected function setLinkTitle($value) {
		$this->linkTitle = $value;		
	}
	protected function setMainContent($value) {
		$this->mainContent = $value;
	}
	protected function setNextPage($value) {
		$this->nextPage = $value;
	}
	protected function setLeftSidebarContent($value) {
		$this->leftSidebarContent = $value;
	}
	protected function setRightSidebarContent($value) {
		$this->rightSidebarContent = $value;
	}
	protected function setArticleHeaderTitle($value) {
		$this->articleHeaderTitle = $value;
	}
	protected function setArticleHeaderSubTitle($value) {
		$this->articleHeaderSubTitle = $value;
	}
	protected function setInfoMessage($value) {
		$this->infoMessage = $value;
	}
	protected function setErrorMessage($value) {
		$this->errorMessage = $value;
	}

	/**
	* Отображени ошибки 404
	*/
	protected function show404() {
		$this->pageTitle = '404';
		$this->mainContent = 'Это не та страница, которую Вы ищете...';
		$this->articleHeaderTitle = '404: страница не найдена';
		$this->articleHeaderSubTitle = '';
		$this->includeTemplatePage('no-sidebar');
	}

	/**
	* Подключение страницы шаблона
	*/
	protected function includeTemplatePage($page) {
		return $this->includeScript($this->__ROOT.'templates/'.$this->templateName.'/'.$page);
	}
	protected function includeView($view) {
		return $this->includeScript($this->__ROOT.'View/'.$view);
	}
	private function includeScript($view) {
		if ($this->templatePageIncluded==false) {
			include($view.'.php');
			$this->templatePageIncluded = true;
			return true;
		}
		//Раньше здесь был exception, не нужен, просто не инклудится. 
		return false;
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
			else return false;
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
			else return false;
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

	/**
	* Редирект
	*/
	protected function redirectTo($url) {
		$redirectUrl = $url;
		include_once('redirect.php');
	}

	/**
	* Отображение критической ошибки
	*/
	protected function showPersistentErrorMessage($errorMessage) {
		$this->pageError = true;
		$this->pageErrorMessage = $errorMessage;
	}

	protected function showPersistentErrorMessageAndFinish($errorMessage) {
		$this->pageError = true;
		$this->pageErrorMessage = $errorMessage;

		$this->pageTitle = 'Ошибка';
		$this->mainContent = $errorMessage;
		$this->articleHeaderTitle = "Ошибка";
		$this->articleHeaderSubTitle = '';
		$this->includeTemplatePage('no-sidebar');
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
