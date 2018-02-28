<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace  Application\Component\Message;

/**
 * Message system based on session.
 * 
 * @author xlight <i@im87.cn>
 */
class Session {
    
    /**
     * Sets a message which reflects the status of the performed operation.
     * 
     * @see drupal's drupal_set_message()
     * @param string $message The message to be displayed to the user.
     * @param string $type 'status'|'warning'|'error'
     * @param bool $repeat If this is FALSE and the message is already set, then
     *  the message won't be repeated.
     */
    public static function set($message = '', $type = 'info', $repeat = TRUE) {
        if ($message) {
            if (!isset($_SESSION['messages'][$type])) {
                $_SESSION['messages'][$type] = array();
            }
            if ($repeat || !in_array($message, $_SESSION['messages'][$type])) {
                $_SESSION['messages'][$type][] = $message;
            }
        }
    
        return isset($_SESSION['messages']) ? $_SESSION['messages'] : NULL;
    }
    
    /**
     * Returns all messages that have been set.
     * 
     * @see drupal's drupal_get_messages()
     * @param string $type (Optional) Only return messages of this type.
     * @param bool $clear_queue (Optional) Set to FALSE if you do not want to 
     *  clear the messages queue
     * @return array
     */
    public static function get($type = '', $clear_queue = TRUE) {
        if ($messages = self::set()) {
            if ($type) {
                if ($clear_queue) {
                    unset($_SESSION['messages'][$type]);
                }
                if (isset($messages[$type])) {
                    return array($type => $messages[$type]);
                }
            } else {
                if ($clear_queue) {
                    unset($_SESSION['messages']);
                }
                return $messages;
            }
        }
        return array();
    }
    
    /**
     * Render a message set.
     * 
     * @return string HTML string.
     */
    public static function render() {
        $output = '';
        $types = array(
            'error'   => 'danger',
            'danger'  => 'danger',
            'success' => 'success',
            'info'    => 'info',
            'warning' => 'warning'
        );
        foreach (self::get() as $type => $messages) {
            $type = $type ?: 'info';
            $output .= "<div class=\"alert alert-{$types[$type]} alert-dismissable\">\n";
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            if (count($messages) > 1) {
                $output .= '<ul>';
                foreach ($messages as $message) {
                    $output .=  '<li>' . $message . '</li>';
                }
                $output .= '</ul>';
            } else {
                $output .= $messages[0];
            }
            $output .= "</div>";
        }
        
        return $output;
    }
}
