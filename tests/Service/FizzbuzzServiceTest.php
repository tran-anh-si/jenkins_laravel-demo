<?php

class FizzbuzzServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testGetOne()
    {
        $sd = new Slimdown();
        // var_dump($sd->render('# This is an # h1 tag\n## This is an #h2 tag'));
        // var_dump($sd->render('###### This is an h6 tag'));
        // var_dump($sd->render('############## This is an h6 tag'));
        var_dump($sd->render('https://github.com'));
        // var_dump($sd->render('=== [aa](http://google.com) === https://github.com === '));
        // var_dump($sd->render('*a*'));
    }
}

/**
 * Slimdown - A very basic regex-based Markdown parser.
 * Supports the
 * following elements (and can be extended via Slimdown::add_rule()):
 *
 * - Headers
 * - Links
 * - Bold
 * - Emphasis
 * - Deletions
 * - Quotes
 * - Inline code
 * - Blockquotes
 * - Ordered/unordered lists
 * - Horizontal rules
 *
 * Author: Johnny Broadway <johnny@johnnybroadway.com>
 * Website: https://gist.github.com/jbroadway/2836900
 * License: MIT
 */
class Slimdown
{

    public static $rules = array(
        '/(#+)(.*)/' => 'self::header', // headers
        '/^((?!\]\().)*(http|https):\/\/[^\s<]+[^\s<\.)]/' => '<a href=\'\0\'>\0</a>',
        '/\[([^\[]+)\]\(((http|https):\/\/[^\)]+)\)/' => '<a href=\'\2\'>\1</a>'
    );
    // '/(\*|_)(.*?)\1/' => '<em>\2</em>'
    
    // fix extra blockquote
    private static function para($regs)
    {
        $line = $regs[1];
        $trimmed = trim($line);
        if (preg_match('/^<\/?(ul|ol|li|h|p|bl)/', $trimmed)) {
            return "\n" . $line . "\n";
        }
        return sprintf("\n<p>%s</p>\n", $trimmed);
    }

    private static function ul_list($regs)
    {
        $item = $regs[1];
        return sprintf("\n<ul>\n\t<li>%s</li>\n</ul>", trim($item));
    }

    private static function ol_list($regs)
    {
        $item = $regs[1];
        return sprintf("\n<ol>\n\t<li>%s</li>\n</ol>", trim($item));
    }

    private static function blockquote($regs)
    {
        $item = $regs[2];
        return sprintf("\n<blockquote>%s</blockquote>", trim($item));
    }

    private static function header($regs)
    {
        list ($tmp, $chars, $header) = $regs;
        $level = strlen($chars);
        if ($level < 7) {
            return sprintf('<h%d>%s</h%d>', $level, trim($header), $level);
        }
        return $tmp;
    }

    /**
     * Add a rule.
     */
    public static function add_rule($regex, $replacement)
    {
        self::$rules[$regex] = $replacement;
    }

    /**
     * Render some Markdown into HTML.
     */
    public static function render($text)
    {
        var_dump($text);
        $text = "\n" . $text . "\n";
        foreach (self::$rules as $regex => $replacement) {
            if (is_callable($replacement)) {
                $text = preg_replace_callback($regex, $replacement, $text);
            } else {
                $text = preg_replace($regex, $replacement, $text);
            }
        }
        return trim($text);
    }
}