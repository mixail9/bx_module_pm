<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use \Tmpi\Feedback\FeedbackTable;
Loc::loadMessages(__FILE__);

if (class_exists('maycat_d7dull')) {
    return;
}
class tmpi_feedback extends CModule
{
    public $MODULE_ID;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS;
    public $PARTNER_NAME;
    public $PARTNER_URI;
    public function __construct()
    {
        $this->MODULE_ID = 'tmpi.feedback';
        $this->MODULE_VERSION = '0.0.1';
        $this->MODULE_VERSION_DATE = '25.04.2016';
        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = "";
        $this->PARTNER_URI = "";

		
    }
    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
		if (Loader::includeModule($this->MODULE_ID)) {
            FeedbackTable::getEntity()->createDbTable();
			CopyDirFiles(__DIR__ . '/components/', $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components");
        }
    }
    public function doUninstall()
    {
		DeleteDirFilesEx($_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/tmpi");
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getInstance()->getConnection();
            $connection->dropTable(FeedbackTable::getTableName());
        }
        ModuleManager::unregisterModule($this->MODULE_ID);
    }

}