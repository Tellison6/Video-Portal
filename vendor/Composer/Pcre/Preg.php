<?php

namespace Composer\Pcre;

class Preg
{
    public static function isMatch($pattern, $subject)
    {
        return preg_match($pattern, $subject) === 1;
    }

    public static function replace($pattern, $replacement, $subject)
    {
        return preg_replace($pattern, $replacement, $subject);
    }

    public static function match($pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);
        return $matches;
    }

    public static function matchAll($pattern, $subject)
    {
        preg_match_all($pattern, $subject, $matches);
        return $matches;
    }

    public static function split($pattern, $subject)
    {
        return preg_split($pattern, $subject);
    }
}
