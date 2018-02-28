<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Filter;

/**
 * XSS过滤
 * Class Xss
 * @package System\Component\Filter
 */
class Xss {
    
    /**
     * Filter选项
     * @var array
     */
    private $options = array(
        // 允许的协议
        'allowedProtocols' => array(
            'ftp', 'http', 'https', 'irc', 'mailto', 'news', 
            'nntp', 'rtsp', 'sftp', 'ssh', 'tel', 'telnet', 'webcal'
        ),
        // 允许的标签
        'allowedTags' => array(
            'a', 'em', 'strong', 'cite', 'blockquote', 'code', 'ul',
            'ol', 'li', 'dl', 'dt', 'dd'
        ),
        // 不允许的属性（所有js事件属性on*都被列为不允许）
        'disallowedAttrs' => array()
    );

    /**
     * 缓存的允许标签
     * @var array
     */
    private $allowedHtml = array();

    public function __construct(array $options = array()) {
        if ($options) {
            $this->setOptions($options);
        }
    }
    
    /**
     * 设置选项
     * 
     * @param array $options
     */
    public function setOptions(array $options) {
        $this->options = array_merge($this->options, $options);
    }
    
    /**
     * 获取纯文本
     */
    public static function checkPlain($string) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * 执行过滤
     * 
     * @param string $string 输入字符串
     * @return string flitered string
     */
    public function filter($string) {
        // Only operate on valid UTF-8 strings. This is necessary to prevent cross
        // site scripting issues on Internet Explorer 6.
        if (!$this->validateUtf8($string)) {
            return '';
        }
        // Remove NULL characters (ignored by some browsers).
        $string = str_replace(chr(0), '', $string);
        // Remove Netscape 4 JS entities.
        $string = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);

        // Defuse all HTML entities.
        $string = str_replace('&', '&amp;', $string);
        // Change back only well-formed entities in our whitelist:
        // Decimal numeric entities.
        $string = preg_replace('/&amp;#([0-9]+;)/', '&#\1', $string);
        // Hexadecimal numeric entities.
        $string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\1', $string);
        // Named entities.
        $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\1', $string);

        return preg_replace_callback('%
            (
            <(?=[^a-zA-Z!/])  # a lone <
            |                 # or
            <!--.*?-->        # a comment
            |                 # or
            <[^>]*(>|$)       # a string that starts with a <, up until the > or the end of the string
            |                 # or
            >                 # just a >
            )%x', array($this, 'filterXssSplit'), $string
        );
    }
    
    /**
     * 检查字符串是否是合法的UTF-8.
     * 
     * @param $text The text to check.
     * @return bool
     */
    public static function validateUtf8($text) {
        if (strlen($text) == 0) {
            return true;
        }
        // With the PCRE_UTF8 modifier 'u', preg_match() fails silently on strings
        // containing invalid UTF-8 byte sequences. It does not reject character
        // codes above U+10FFFF (represented by 4 or more octets), though.
        return (preg_match('/^./us', $text) == 1);
    }
    
    /**
     * 处理HTML标签
     * @param array $m 匹配到的标签
     * @return string
     */
    private function filterXssSplit($m) {

        if (! $this->allowedHtml) {
            $this->allowedHtml = array_flip($this->options['allowedTags']);
        }

        $string = $m[1];

        if (substr($string, 0, 1) != '<') {
            // We matched a lone ">" character.
            return '&gt;';
        }
        elseif (strlen($string) == 1) {
            // We matched a lone "<" character.
            return '&lt;';
        }

        if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?|(<!--.*?-->)$%', $string, $matches)) {
            // Seriously malformed.
            return '';
        }

        $slash = trim($matches[1]);
        $elem = &$matches[2];
        $attrlist = &$matches[3];
        $comment = &$matches[4];

        if ($comment) {
            $elem = '!--';
        }

        if (!isset($this->allowedHtml[strtolower($elem)])) {
            // Disallowed HTML element.
            return '';
        }

        if ($comment) {
            return $comment;
        }

        if ($slash != '') {
            return "</$elem>";
        }

        // Is there a closing XHTML slash at the end of the attributes?
        $attrlist = preg_replace('%(\s?)/\s*$%', '\1', $attrlist, -1, $count);
        $xhtml_slash = $count ? ' /' : '';

        // Clean up attributes.
        $attr2 = implode(' ', $this->filterXssAttributes($attrlist));
        $attr2 = preg_replace('/[<>]/', '', $attr2);
        $attr2 = strlen($attr2) ? ' ' . $attr2 : '';

        return "<$elem$attr2$xhtml_slash>";

    }
    
    /**
     * Processes a string of HTML attributes.
     */
    private function filterXssAttributes($attr) {
        $attrarr = array();
        $mode = 0;
        $attrname = '';
        $skip = false;

        while (strlen($attr) != 0) {
            // Was the last operation successful?
            $working = 0;

            switch ($mode) {
                case 0:
                    // Attribute name, href for instance.
                    if (preg_match('/^([-a-zA-Z]+)/', $attr, $match)) {
                        $attrname = strtolower($match[1]);
                        if (in_array($attrname, $this->options['disallowedAttrs'])
                            || substr($attrname, 0, 2) == 'on') {
                            $skip = true;
                        } else {
                            $skip = false;
                        }
                        $attr = preg_replace('/^[-a-zA-Z]+/', '', $attr);
                        $working = $mode = 1;
                    }
                    break;

                case 1:
                    // Equals sign or valueless ("selected").
                    if (preg_match('/^\s*=\s*/', $attr)) {
                        $working = 1;
                        $mode = 2;
                        $attr = preg_replace('/^\s*=\s*/', '', $attr);
                    break;
                    }

                    if (preg_match('/^\s+/', $attr)) {
                        $working = 1;
                        $mode = 0;
                        if (!$skip) {
                            $attrarr[] = $attrname;
                        }
                        $attr = preg_replace('/^\s+/', '', $attr);
                    }
                    break;

                case 2:
                    // Attribute value, a URL after href= for instance.
                    if (preg_match('/^"([^"]*)"(\s+|$)/', $attr, $match)) {
                        // 防止样式被过滤
                        $thisval = in_array($attrname, array('style'))
                            ? $match[1]
                            : $this->filterXssBadProtocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
                        break;
                    }

                    if (preg_match("/^'([^']*)'(\s+|$)/", $attr, $match)) {
                        $thisval = $this->filterXssBadProtocol($match[1]);
            
                        if (!$skip) {
                            $attrarr[] = "$attrname='$thisval'";
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
                        break;
                    }

                    if (preg_match("%^([^\s\"']+)(\s+|$)%", $attr, $match)) {
                        $thisval = $this->filterXssBadProtocol($match[1]);
            
                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
                    }
                    break;
            }

            if ($working == 0) {
                // Not well formed; remove and try again.
                $attr = preg_replace('/
                ^
                (
                "[^"]*("|$)     # - a string that starts with a double quote, up until the next double quote or the end of the string
                |               # or
                \'[^\']*(\'|$)| # - a string that starts with a quote, up until the next quote or the end of the string
                |               # or
                \S              # - a non-whitespace character
                )*              # any number of the above three
                \s*             # any number of whitespaces
                /x', '', $attr);
                $mode = 0;
            }
        }

        // The attribute list ends with a valueless attribute like "selected".
        if ($mode == 1 && !$skip) {
            $attrarr[] = $attrname;
        }
        return $attrarr;
    }
    
    /**
     * Filter xss bad protocols
     * 
     * @param string $string
     * @param bool $decode
     * @return string
     */
    private function filterXssBadProtocol($string, $decode = true) {
        // Get the plain text representation of the attribute value (i.e. its meaning).
        // @todo Remove the $decode parameter in Drupal 8, and always assume an HTML
        //   string that needs decoding.
        if ($decode) {
            $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        }
        return htmlspecialchars($this->stripDangerousProtocols($string), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Strip dangerous protocols
     * 
     * @param string $uri
     * @return string 
     */
    private function stripDangerousProtocols($uri) {
        static $allowed_protocols;
    
        if (!isset($allowed_protocols)) {
            $allowed_protocols = array_flip($this->options['allowedProtocols']);
        }
    
        // Iteratively remove any invalid protocol found.
        do {
            $before = $uri;
            $colonpos = strpos($uri, ':');
            if ($colonpos > 0) {
                // We found a colon, possibly a protocol. Verify.
                $protocol = substr($uri, 0, $colonpos);
                // If a colon is preceded by a slash, question mark or hash, it cannot
                // possibly be part of the URL scheme. This must be a relative URL, which
                // inherits the (safe) protocol of the base document.
                if (preg_match('![/?#]!', $protocol)) {
                    break;
                }
                // Check if this is a disallowed protocol. Per RFC2616, section 3.2.3
                // (URI Comparison) scheme comparison must be case-insensitive.
                if (!isset($allowed_protocols[strtolower($protocol)])) {
                    $uri = substr($uri, $colonpos + 1);
                }
            }
        } while ($before != $uri);
    
        return $uri;
    }
}
