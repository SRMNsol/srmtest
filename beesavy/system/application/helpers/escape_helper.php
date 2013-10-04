<?php
/**
 * Output escaping
 */

function escape($string, $mode = 'html', $enc = 'UTF-8')
{
    switch ($mode) {
        case 'html' :
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $enc);
        case 'html_attr' :
            if ($enc !== 'UTF-8') {
                $string = iconv($enc, 'UTF-8', $string);
            }
            return preg_replace_callback('#[^a-zA-Z0-9,\.\-_]#Su', 'escape_html_attr_callback', $string);
    }

    throw new RuntimeException("Invalid escape mode $mode");
}

/**
 * This function is adapted from code coming from Zend Framework.
 *
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
function escape_html_attr_callback($matches)
{
    /*
     * While HTML supports far more named entities, the lowest common denominator
     * has become HTML5's XML Serialisation which is restricted to the those named
     * entities that XML supports. Using HTML entities would result in this error:
     *     XML Parsing Error: undefined entity
     */
    static $entityMap = array(
        34 => 'quot', /* quotation mark */
        38 => 'amp',  /* ampersand */
        60 => 'lt',   /* less-than sign */
        62 => 'gt',   /* greater-than sign */
    );

    $chr = $matches[0];
    $ord = ord($chr);

    /**
     * The following replaces characters undefined in HTML with the
     * hex entity for the Unicode replacement character.
     */
    if (($ord <= 0x1f && $chr != "\t" && $chr != "\n" && $chr != "\r") || ($ord >= 0x7f && $ord <= 0x9f)) {
        return '&#xFFFD;';
    }

    /**
     * Check if the current character to escape has a name entity we should
     * replace it with while grabbing the hex value of the character.
     */
    if (strlen($chr) == 1) {
        $hex = strtoupper(substr('00'.bin2hex($chr), -2));
    } else {
        $chr = iconv('UTF-8', 'UTF-16BE', $chr);
        $hex = strtoupper(substr('0000'.bin2hex($chr), -4));
    }

    $int = hexdec($hex);
    if (array_key_exists($int, $entityMap)) {
        return sprintf('&%s;', $entityMap[$int]);
    }

    /**
     * Per OWASP recommendations, we'll use hex entities for any other
     * characters where a named entity does not exist.
     */

    return sprintf('&#x%s;', $hex);
}
