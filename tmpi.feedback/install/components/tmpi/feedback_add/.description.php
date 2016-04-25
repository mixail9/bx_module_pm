<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => 'Личные сообщения',
	"DESCRIPTION" => 'Личные сообщения',
	"ICON" => "/images/cat_detail.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "user",
		"CHILD" => array(
			"ID" => "user_messages",
			"NAME" => 'Личные сообщения',
			"SORT" => 30
		),
	),
);

?>