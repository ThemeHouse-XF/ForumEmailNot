<?php

class ThemeHouse_ForumEmailNot_Install_Controller extends ThemeHouse_Install
{
    
    protected $_resourceManagerUrl = 'http://xenforo.com/community/resources/forum-email-notifications-by-th.3386/';
    
    protected function _getTableChanges()
    {
        return array(
            'xf_forum' => array(
                'emails_th' => 'TEXT', /* END 'emails_th' */
            ), /* END 'xf_forum' */
        );
    } /* END _getTableChanges */


	protected function _postInstall()
	{
		$addOn = $this->getModelFromCache('XenForo_Model_AddOn')->getAddOnById('YoYo_');
		if ($addOn) {
			$db->query("
				UPDATE xf_forum
					SET emails_th=emails_waindigo");
		}
	}
}