<?php

/**
 *
 * @see XenForo_DataWriter_Forum
 */
class ThemeHouse_ForumEmailNot_Extend_XenForo_DataWriter_Forum extends XFCP_ThemeHouse_ForumEmailNot_Extend_XenForo_DataWriter_Forum
{
    
    /**
     *
     * @see XenForo_DataWriter_Forum::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        $fields['xf_forum']['emails_th'] = array(
            'type' => self::TYPE_SERIALIZED,
            'default' => 'a:0:{}'
        );
        return $fields;
    } /* END _getFields */
    
    /**
     *
     * @see XenForo_DataWriter_Forum::_preSave()
     */
    protected function _preSave()
    {
        if (isset($GLOBALS['XenForo_ControllerAdmin_Forum'])) {
            /* @var $input XenForo_Input */
            $input = $GLOBALS['XenForo_ControllerAdmin_Forum']->getInput();
            $emails = $input->filterSingle('emails_th', XenForo_Input::STRING);
            $emails = explode(',', $emails);
            $this->set('emails_th', $emails);
        }

        parent::_preSave();
    } /* END _preSave */
}