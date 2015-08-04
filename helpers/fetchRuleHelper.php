<?php


/*
|--------------------------------------------------------------------------
| Fetch Rule Helper
|--------------------------------------------------------------------------
|
| You can set up your own helper to define how to fetch data
|
*/


class FetchRuleHelper {


////////////////////////////////////
//
//  For Title
//
///////////////////////////////////////

    public static function titleGenerate($feed, $x)
    {
        return str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    }

    public static function titleGenerateWithLimit($feed, $x, $limit)
    {
        $title = $feed[$x]['title'];
        $titleCutOff = mb_substr($title, 0, $limit);

        if (mb_strlen($title) > $limit)
        {
            return str_replace(' & ', ' &amp; ', $titleCutOff . '...');
        }

        return str_replace(' & ', ' &amp; ', $titleCutOff);
    }

////////////////////////////////////
//
//  For Links
//
///////////////////////////////////////

    public static function linkGenerate($feed, $x)
    {
        return $feed[$x]['link'];
    }


////////////////////////////////////
//
//  For Description
//
///////////////////////////////////////

    public static function descGenerate($feed, $x)
    {
        return $feed[$x]['desc'];
    }


    public static function descGenerateWithLimit($feed, $x, $limit)
    {
        $desc = $feed[$x]['desc'];
        $descCutOff = mb_substr($desc, 0, $limit);

        if (mb_strlen($desc) > $limit)
        {
            return str_replace(' & ', ' &amp; ', $descCutOff . '...');
        }

        return str_replace(' & ', ' &amp; ', $descCutOff);
    }


////////////////////////////////////
//
//  For Date
//
///////////////////////////////////////

    public static function dateGenerate($feed, $x)
    {
        return date('l F d, Y', strtotime($feed[$x]['date']));
    }


}
