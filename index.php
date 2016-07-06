<?php
	#Подключение корневого класса контроллера
	include_once('php/controller.php');

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
			$this->pageEditorSaveCheck();
			$this->showPage();
		}

		/**
		 * Функция формирования страниц главного меню
		 */
		private function showPage() {
			#Определение текущей страницы
			$page = false;
			if (count($this->getKeys)>0) $page = $this->getKeys[0];
			$this->setSelectedMenuItem($page);
			/**
		 	* Конечный автомат проверяющий отображающий текущую страницу
		 	* Старницы main, sign и logout обрабатываются отдельно, т.к.
		 	* данные пункты соответствуют страницам, не сохраненным в БД
		 	*/
			switch ($page) {
				case 'main': {
					$this->setPageTitle('FitnessMessage');
					$this->includeTemplatePage('main');
					break;
				}
				case 'sign': {
					$this->setNextPage($this->parseGETParameter('next'));
					if ($this->logined) {
						if ($this->nextPage=="") $this->redirectTo('/lk');
						else $this->redirectTo('/'.$this->nextPage);
					}

					if ($this->parsePOSTParameter('email')!=false) $this->setErrorMessage('Wrong password or email!');
					$this->setPageTitle('Вход');
					$this->setArticleHeaderTitle('Вход');
					//$this->setMainContent($this->includeAsText('fixed/loginform.php'));
					$this->setArticleHeaderSubTitle('');
					if ($this->linkTitle!='') $this->setSelectedMenuItem('?sign&next='.$this->linkTitle);
					else $this->setSelectedMenuItem('?sign');
					//$this->includeTemplatePage('no-sidebar');
					$this->includeView('LoginView');
					break;
				}
				case 'register': {
					$this->postEmail = "";
					$this->postlastname = "";
					$this->postname = "";
					$this->postpassword = "";
					$this->postonemorepassword = "";
					$this->trainer = 0;

					if ($this->parsePOSTParameter("register")) {
						$post = $this->parseMultiplePOST(array("email",
									"lastname",
									"name",
									"password",
									"onemorepassword"));

						$post["trainer"] = $this->parsePOSTParameter("trainer");
						$this->postEmail = $post["email"];
						$this->postlastname = $post["lastname"];
						$this->postname = $post["name"];
						$this->postpassword = $post["password"];
						$this->postonemorepassword = $post["onemorepassword"];
						$this->trainer=$this->convertPollCheckBox($post["trainer"]);
						
						if ($post==false) {
							$this->setErrorMessage('Необходимо заполнить все поля');
						}
						else {
							if ($post['password']!=$post['onemorepassword']) {
								$this->setErrorMessage('Пароль и проверка не соответствуют друг другу');
							}
							else {
								if ($post["email"]=='' || $post["lastname"]=='' || $post["name"]=='' || $post["password"]=='' || $post["onemorepassword"]=='') {
									$this->setErrorMessage('Необходимо заполнить все поля');
								}
								else {
									if (!filter_var($post["email"], FILTER_VALIDATE_EMAIL)) {
										$this->setErrorMessage('Email указан неверно');
									}
									else {
										$result = $this->backend->registerUser($post["email"],$post["lastname"],$post["name"],$post["password"],$this->trainer);
										if ($result=="EmailExists") {
											$this->setErrorMessage('Данный Email уже используется');
										}
										elseif($result==true) {
											$this->checkLogin();
										}
									}
								}
							}
						}
					}
					

					$this->setNextPage($this->parseGETParameter('next'));
					if ($this->logined) 
						if ($this->nextPage=="") $this->redirectTo('/lk');
						else $this->redirectTo('/'.$this->nextPage);


					//
					//if ($this->parsePOSTParameter('email')!=false) $this->setErrorMessage('Wrong password or email!');
					$this->setPageTitle('Регистрация');
					//$this->setMainContent($this->includeAsText('fixed/registerForm.php'));
					$this->setArticleHeaderTitle('Регистрация');
					$this->setArticleHeaderSubTitle('');
					if ($this->linkTitle!='') $this->setSelectedMenuItem('?sign&next='.$this->linkTitle);
					else $this->setSelectedMenuItem('?sign');
					$this->includeView('RegisterView');
					break;
				}
				case 'logout': {
					$this->setNextPage($this->parseGETParameter('next'));
					$this->setPageTitle('Выход выполнен');
					// $this->setMainContent($this->includeAsText('fixed/loginform.php'));
					$this->setArticleHeaderTitle('Выход выполнен');
					$this->setArticleHeaderSubTitle('');
					if ($this->linkTitle!='') $this->setSelectedMenuItem('?sign&next='.$this->linkTitle);
					else $this->setSelectedMenuItem('?sign');

					$this->backend->logout();
					$this->logined = false;

					//Еще раз проверить логин и пересобрать меню, поскольку логаут происходит после того, как родитель проверяет сессию

					$this->checkLogin();
					$this->createMainMenu();
					$this->includeView('LoginView');
					// $this->includeTemplatePage('no-sidebar');
				}
				case false: {
					$this->setSelectedMenuItem('main');
					$this->includeTemplatePage('main');
				}
				default: {
					if (count($pageContent = $this->backend->getPageContent($page))>0) {
						$this->pageURL = $page;

						$this->fillPageData($pageContent[0]);

						$this->includeTemplatePage($pageContent[0]['template']);
						break;
					}

					$this->show404();

					break;	
				}
			}
		}
		/**
		 * Проверка режима редактирования и сохранение изменений
		 */
		private function pageEditorSaveCheck() {
			if (!$this->editMode) return; 

			$pageURL = false;
			$newContent = false;
			$result = false;

			if ($pageURL = $this->parsePOSTParameter("leftContentPageEdit")) {
				$newContent = $this->parsePOSTParameter('leftContent');
				if ($newContent!=false) $result = $this->backend->savePageLeftContent($pageURL, $newContent);
			}
			if ($pageURL = $this->parsePOSTParameter("rightContentPageEdit")) {
				$newContent = $this->parsePOSTParameter('rightContent');
				if ($newContent!=false) $result = $this->backend->savePageRightContent($pageURL, $newContent);
			}
			if ($pageURL = $this->parsePOSTParameter("mainContentPageEdit")) {
				$newContent = $this->parsePOSTParameter('mainContent');
				if ($newContent!=false) $result = $this->backend->savePageContent($pageURL, $newContent);
			}

			if ($pageURL==false) return;

			if ($result==true) {
				$this->setInfoMessage("Изменения сохранены");
			}
			else if ($result==false) {
				$this->setErrorMessage("Ошибка сохранения изменений");
			}

		}
	}

	$index = new IndexController();
?>