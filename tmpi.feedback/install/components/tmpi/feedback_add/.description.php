<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => '������ ���������',
	"DESCRIPTION" => '������ ���������',
	"ICON" => "/images/cat_detail.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "user",
		"CHILD" => array(
			"ID" => "user_messages",
			"NAME" => '������ ���������',
			"SORT" => 30
		),
	),
);

?>