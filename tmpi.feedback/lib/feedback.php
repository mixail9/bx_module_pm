<?
namespace Tmpi\Feedback;

use \Bitrix\Main\Entity;

class FeedbackTable extends Entity\DataManager
{
	public static function getTableName()
    {
        return 'tmpi_feedback';
    }
    
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
				'primary' => true,
				'autocomplete' => true,
			)),
            new Entity\IntegerField('FROM_USER_ID', array(
				'required' => true
			)),
            new Entity\IntegerField('TO_USER_ID', array(
				'required' => true
			)),
            new Entity\StringField('TITLE', array(
				'required' => true
			)),
            new Entity\TextField('MESSAGE', array(
				'required' => true
			)),
			new Entity\ReferenceField('FROM_USER',
                'Bitrix\Main\UserTable',
                array('=this.FROM_USER_ID' => 'ref.ID')
            ),
			new Entity\ReferenceField('TO_USER',
                'Bitrix\Main\UserTable',
                array('=this.TO_USER_ID' => 'ref.ID')
            ),
        );
    }

	public static function onBeforeAdd(Entity\Event &$data)
	{
		$params = $data->getParameters();

		if(empty($params['fields']['TO_USER_ID']))
			return false;

		$userTo = \Bitrix\Main\UserTable::getList(array(
			'filter'=>array('LOGIC' => 'OR', array('=LOGIN' => $params['fields']['TO_USER_ID']), array('ID' => $params['fields']['TO_USER_ID'])),
			'select' => array('ID', 'LOGIN')
		))->fetchAll();


		if(empty($userTo))
			return false;

		
		$params['fields']['TO_USER_ID'] = $userTo[0]['ID'];
		$data->setParameters($params);
		return $data;
	}

	public static function onAdd(Entity\Event $data)
	{
		$params = $data->getParameters();
		$params = $params['fields'];

		\CEvent::Send('FEEDBACK_MESSAGE', $params['SITE_ID'], $params, 'N');
	}
}

?>