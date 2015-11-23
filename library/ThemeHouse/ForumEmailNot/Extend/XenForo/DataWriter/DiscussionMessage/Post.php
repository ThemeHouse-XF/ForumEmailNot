<?php

/**
 *
 * @see XenForo_DataWriter_DiscussionMessage_Post
 */
class ThemeHouse_ForumEmailNot_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XFCP_ThemeHouse_ForumEmailNot_Extend_XenForo_DataWriter_DiscussionMessage_Post
{

    /**
     *
     * @see XenForo_DataWriter_DiscussionMessage_Post::_postSaveAfterTransaction()
     */
    protected function _postSaveAfterTransaction()
    {
        // perform alert actions if the message is visible, and is a new insert,
        // or is an update where the message state has changed from 'moderated'
        if ($this->get('message_state') == 'visible') {
            if ($this->isInsert() || $this->getExisting('message_state') == 'moderated') {
                $post = $this->getMergedData();
                $thread = $this->getDiscussionData();
                $forum = $this->_getForumInfo();
                
                if (!empty($forum['emails_th']) && !empty($post)) {
                    $emailMembers = unserialize($forum['emails_th']);
                    $post = $this->_parseMessageForNotification($post);
                    
                    if (!$this->isDiscussionFirstMessage()) {
                        if (XenForo_Application::get('options')->th_forumEmailNotify_notifyForMessages) {
                            //sends default 'new message in forum'
                            foreach ($emailMembers as $email) {
                                $this->_sendNotificationEmail($post, $thread, $email, 
                                    'th_forum_message_forumemailnotify');
                            }
                        }
                    } else {
                        //sends 'new thread in forum' message
                        foreach ($emailMembers as $email) {
                            $this->_sendNotificationEmail($post, $thread, $email, 
                                'th_forum_thread_forumemailnotify');
                        }
                    }
                }
            }
        }
        parent::_postSaveAfterTransaction();
    } /* END _postSaveAfterTransaction */

    protected function _sendNotificationEmail($post, $thread, $email, $emailTemplate)
    {
        $params = array(
            'post' => $post,
            'thread' => $thread,
            'boardTitle' => XenForo_Application::get('options')->boardTitle,
            'boardUrl' => XenForo_Application::get('options')->boardUrl
        );
        
        $mail = XenForo_Mail::create($emailTemplate, $params);
        
        $mail->send($email);
    } /* END _sendNotificationEmail */

    protected function _parseMessageForNotification(array $post)
    {
        $bbCodeParserText = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('Text'));
        $post['messageText'] = new XenForo_BbCode_TextWrapper($post['message'], $bbCodeParserText);
        $bbCodeParserHtml = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('HtmlEmail'));
        $post['messageHtml'] = new XenForo_BbCode_TextWrapper($post['message'], $bbCodeParserHtml);
        return $post;
    } /* END _parseMessageForNotification */
}