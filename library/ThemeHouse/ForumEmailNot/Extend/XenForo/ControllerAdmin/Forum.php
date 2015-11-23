<?php

/**
 *
 * @see XenForo_ControllerAdmin_Forum
 */
class ThemeHouse_ForumEmailNot_Extend_XenForo_ControllerAdmin_Forum extends XFCP_ThemeHouse_ForumEmailNot_Extend_XenForo_ControllerAdmin_Forum
{

    /**
     *
     * @see XenForo_ControllerAdmin_Forum::actionEdit()
     */
    public function actionEdit()
    {
        $response = parent::actionEdit();
        if (!empty($response->params['forum']['emails_th'])) {
            $response->params['forum']['emails_th'] = implode(',', unserialize($response->params['forum']['emails_th']));
        }
        return $response;
    } /* END actionEdit */
    
    
    /**
     *
     * @see XenForo_ControllerAdmin_Forum::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerAdmin_Forum'] = $this;
        return parent::actionSave();
    } /* END actionSave */
}