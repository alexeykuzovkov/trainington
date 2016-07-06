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
	#Список пунктов главного меню (верхннее меню и его дубль внизу)
	protected $menuItems;
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

	/**
	* Функциональные переменные
	**/

	#Индикатор авторизации
	protected $logined;
	#Сообщение об ошибке
	protected $errorMessage;
	#Информационное сообщение
	protected $infoMessage;
	#Индикатор режима редактирования
	protected $editMode;

	#Массив ключей get запроса
	protected $getKeys;
	#Массив ключей post запроса
	protected $postKeys;

	#Ссылка на корневой каталог
	protected $__ROOT;
	#Ссылка на папку шаблонов
	protected $__TEMPR;

	protected $pageError;
	protected $pageErrorMessage;
	
	//Мой собственный уровень зарегистрированного пользователя
	protected $mylevel;
	//Уровень пользователя, на чей странице мы оказались
	protected $level;

	//Информация о владельце страницы
	protected $userInfo;

	//Информация обо мне 
	protected $myuserInfo;

	protected $__SESSIONID;

	//Мы — незарегестрированный пользователь

	protected $sideMenu;
	protected $pageId;

	protected $membershipInfo;
	protected $allMembershipInfo;
	protected $unpaidInfo;
	protected $membershipExpireSoon;
	protected $membershipBeginSoon;
	protected $trainerID;
	protected $programExpiredDate;
	protected $programBeginDate;

	#Массив со строками из locals.json
	protected $locals;
	protected $localsJSON;
	protected $lang;

	protected $isAjax;

	protected $config;
	/**
	* Конструктор 
	**/
	function __construct($rootFolder = '')
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
	}

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
	* Формирование списка главного меню в зависимости от авторизации пользователя 
	**/
	protected function createMainMenu() {
		$this->menuItems = array('?main' => $this->NSLocalizedString("Главная"));
		$this->menuItems['trainers'] = $this->NSLocalizedString("Тренеры");
		foreach ($this->backend->getMenuPages() as $value) {
			$this->menuItems["?".$value['url']] = $value['name'];
		}
		if ($this->logined) {
			$this->menuItems['lk'] = $this->NSLocalizedString("Личный кабинет");
			if ($this->linkTitle!='') $this->menuItems['?logout&next='.$this->linkTitle] = $this->NSLocalizedString("Выход");
			else $this->menuItems['?logout'] = $this->NSLocalizedString("Выход");
		}
		else {
			if ($this->linkTitle!='') $this->menuItems['?sign&next='.$this->linkTitle] = $this->NSLocalizedString("Вход/Регистрация");
			else $this->menuItems['?sign'] = $this->NSLocalizedString("Вход/Регистрация");
		}
		
	}

	/**
	* Формирование бокового меню, в зависимости от уровня пользователя.
	**/
	protected function createSideMenu() {
		$pageError = false;		
		switch ($this->mylevel) {
			case 1: {
				$this->sideMenu = array(
				$this->NSLocalizedString("Личная страница") => 'lk',
				$this->NSLocalizedString("Моя программа") => 'program',
				$this->NSLocalizedString("Мои результаты") => 'results',
				$this->NSLocalizedString("Мои друзья") => 'friends',
				$this->NSLocalizedString("Лента" )=> 'news',
				$this->NSLocalizedString("Сообщения") => 'messages',
				$this->NSLocalizedString("Уведомления") => 'notifications',
				$this->NSLocalizedString("Профиль") => 'profile'
				);
				break;
			}
			case 2: {
				$this->sideMenu = array(
				$this->NSLocalizedString("Личная страница") => 'lk',
				$this->NSLocalizedString("Мои клиенты") => 'clients',
				$this->NSLocalizedString("Мои цены") => 'pricelist',
				$this->NSLocalizedString("Мои друзья") => 'friends',
				$this->NSLocalizedString("Заявки пользователей")=> 'UserRequest',
				$this->NSLocalizedString("Лента") => 'news',
				$this->NSLocalizedString("Сообщения") => 'messages',
				$this->NSLocalizedString("Уведомления") => 'notifications',
				$this->NSLocalizedString("Профиль") => 'profile'
				);	
				break;
			}
			case 3: {
				$this->sideMenu = array(
				$this->NSLocalizedString("Личная страница") => 'lk',
				$this->NSLocalizedString("Заявки тренеров")=> 'UserRequest',
				$this->NSLocalizedString("Сообщения") => 'messages'
				);	
				break;
			}
			default:
				$this->sideMenu = array();
				break;
		}
//
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
	 * Проверка авторизации пользователя
	 */
	protected function checkLogin() {
		$this->__SESSIONID = $this->backend->checkLogin();
		if ($this->__SESSIONID==0) $this->logined = false;
		else $this->logined = true;
	}
	
	/**
	 * Проверка включения режима редактирования
	 */
	protected function checkEditMode() {
		$this->editMode = false;
		if (isset($_GET['edit']) && $this->logined==true) {
			$this->editMode = true;
		}
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
	* Загрузка файла
	*/
	protected function uploadFile($datapart, $myid, $uploadid, $pathid) {	
		$append = true;
		
		if ($uploadid<=0) {
			$append = false;
			$uploadid = $this->backend->createNewUpload($myid, microtime(TRUE)."_".rand(1000, 2000).".jpg", $pathid);
			if ($uploadid==false) {
				echo json_encode(array("status"=>"error"));
				return;
			}
			//$uploadInfo = $this->backend->getUploadData($uploadid);
		}

		$uploadInfo = $this->backend->getUploadData($uploadid);
		
		if(!isset($uploadInfo[0]) || $uploadInfo[0]["userid"]!=$myid) {
			echo json_encode(array("status"=>"error"));
			return;
		}

		
		
		$uploadPath = $this->__ROOT."images/".$uploadInfo[0]['path']."/$myid";
		$filename = $uploadInfo[0]['filename'];
		
		if (!file_exists($uploadPath)) mkdir($uploadPath, 0777);

		/*$array = explode("/", $path);
		if($array[0] == "/") array_shift($array);
		$path = implode("/", $array);

		$array = explode("/", $path);
		if($array[count($array)-1] == "/") array_pop($array);
		$path = implode("/", $array);*/

		$filelink = $uploadPath. "/".$filename;

		$data = base64_decode($datapart, true);

		if ($append) file_put_contents($filelink, $data, FILE_APPEND);
		else {
			echo json_encode(array("status"=>$uploadid, "filename"=>"$myid/$filename"));
			file_put_contents($filelink, $data);
		}
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
	 * Функция для получения локализованной строки
	 */
	protected function NSLocalizedString($string, $wrapInSingleQuotes = false)
	{
		if (isset($this->locals[$this->lang][$string])) {
			if ($wrapInSingleQuotes==true) {
				return "'".$this->locals[$this->lang][$string]."'";
			}
			return $this->locals[$this->lang][$string];
		}
		return ">>>>>NOSTRING!: ".$string."<<<<";
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

	protected function getUserActualNotifications() {
		if (!$this->logined) return;

		$prev = $this->backend->getLastRequest($this->__SESSIONID);
		$lastRequest = count($prev)==0 ? false : $prev[count($prev)-1];

		if ($this->mylevel<3) {
			if ($this->mylevel==2) {
				$pricelist = $this->backend->getPriceListForTrainer($this->__SESSIONID);

				if (!isset($pricelist['active']) || count($pricelist['active'])<=0) {
					$this->setToastNotification(
						$this->NSLocalizedString("<No_Active_Programs_Trainer>"), 
						$this->__ROOT."pricelist", 
						$this->NSLocalizedString("Мои цены"));
				}
			}
			if ((int)$this->myuserInfo[0]['userinfo']==0  && (int)$this->myuserInfo[0]['userlevel']==1) {
				$this->setToastNotification(
					$this->NSLocalizedString("Необходимо заполнить"), 
					$this->__ROOT."profile/?poll=true", 
					$this->NSLocalizedString("анкету"));
			}
			if (count($this->unpaidInfo)>0 && $this->mylevel==1) {
				$this->setToastNotification(
					$this->NSLocalizedString("Необходимо оплатить подписку."), 
					$this->__ROOT."membership", 
					$this->NSLocalizedString("Перейти к оплате"));
			}
			elseif (count($this->allMembershipInfo)==0 && $this->mylevel==1) {
				$this->setToastNotification(
					$this->NSLocalizedString("Оформите подписку для доступа к расширенным возможностям."), 
					$this->__ROOT."membership", 
					$this->NSLocalizedString("Оформить"));
			}

			if ($this->membershipBeginSoon) {
				$this->setToastNotification(
					$this->NSLocalizedString("Ваша подписка скоро начнется").": ".$this->dateToPrintableDate($this->getProgramBeginDate()));
			}
			elseif ($lastRequest && (int)$lastRequest["fortrainer"]==0) {
				$this->setToastNotification(
					$this->NSLocalizedString("Вы подали заявку, просмотрите все ли верно."), 
					$this->__ROOT."request", 
					$this->NSLocalizedString("Ваша заявка"));
			}
			elseif ($this->membershipExpireSoon) {
				$this->setToastNotification(
					$this->NSLocalizedString("Ваша подписка заканчивается").": ".$this->dateToPrintableDate($this->getProgramExpiredDate()), 
					$this->__ROOT."membership/?id=".$this->getTrainerID()."&renew=1", 
					$this->NSLocalizedString("Продлить"));
			}
		}
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
