<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class FeedbackAdd extends CBitrixComponent
{

	function executeComponent()
	{
		global $USER;
		if((!$USER->isAuthorized()) || (!\Bitrix\Main\Loader::IncludeModule('tmpi.feedback')))
			return false;

		$this->actionAdd();
		$this->loadData();

		$this->includeComponentTemplate();
	}

	protected function loadData()
	{
		global $USER;

		$res = \Tmpi\Feedback\FeedbackTable::getList(array(
			'filter' => array('TO_USER_ID' => $USER->GetID()),
			'select' => array('THEME' => 'TITLE', 'FROM' => 'FROM_USER.LOGIN', 'MESSAGE')
		));

		while($message = $res->fetch())
			$this->arResult['ITEMS'][] = $message;
	}


	protected function actionAdd()
	{
		global $APPLICATION;
		global $USER;

		if(!check_bitrix_sessid())
			return false;

		if((empty($_POST['name'])) || (empty($_POST['theme'])) || (empty($_POST['message'])))
		{
			LocalRedirect($APPLICATION->GetCurPageParam('error=REQUIRED_FIELDS'));
			return false;
		}


		$userTo = \Bitrix\Main\UserTable::getList(array(
			'filter'=>array('LOGIC' => 'OR', array('=LOGIN' => $_POST['name']), array('ID' => $_POST['name'])),
			'select' => array('ID', 'LOGIN')
		))->fetchAll();

		if(empty($userTo))
		{
			LocalRedirect($APPLICATION->GetCurPageParam('error=REQUIRED_FIELDS'));
			return false;
		}

		$toUser = $userTo[0]['ID'];

		$data = array(
			'FROM_USER_ID' => $USER->GetID(),
			'TO_USER_ID' => $toUser,
			'TITLE' => $_POST['theme'],
			'MESSAGE' => $_POST['message']
		);
		$result = \Tmpi\Feedback\FeedbackTable::add($data);

		LocalRedirect($APPLICATION->GetCurPageParam('ok=SUCCESS'));

	}
}

?>