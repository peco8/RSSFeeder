<?php

    // configuration & settings
    $configs = require_once('./configs/locale.php');
    $input_settings = require_once('./settings/inputSetting.php');
    $output_settings = require_once('./settings/outputSetting.php');

    // handlers
    require_once('./handlers/fetchHandler.php');
    require_once('./handlers/renderHandler.php');

    /////////////////////////////////////
    //
    //  Configuration
    //
    /////////////////////////////////////

    date_default_timezone_set($configs['timezone']);

    mb_language($configs['language']);
    mb_internal_encoding($configs['internal_encoding']);
    mb_http_output($configs['output_encoding']);

    // Error Reporting
    //error_reporting(E_ERROR | E_PARSE);
    //ini_set("display_errors", 1);


    /////////////////////////////////////
    //
    //  Settings
    //
    /////////////////////////////////////

    $url = $input_settings['url'];
    $limit = $output_settings['limit'];

    $limitTitle = $output_settings['title_limit'];
    $limitDesc = $output_settings['desc_limit'];


    /////////////////////////////////////
    //
    //  Fetching & Rendering
    //
    /////////////////////////////////////

    try
    {
        $rss = new FetchFromUrlService(new DoMDocument, $url);
    }
    catch(Exception $e)
    {

        die($e->getMessage());
    }

    $fetchServiceProvider = new FetchServiceProvider($rss);
    $fetchServiceProvider->load();
    $fetchServiceProvider->fetch();
    $totalFeed = $fetchServiceProvider->countTotalFeed();
    $feed = $rss->feed();



    // If the setting limit is over the total feed, it automatically set the total feed number as the limit
    if ($limit > $totalFeed)
    {
        $limit = $totalFeed - 1;
    }

    /*  Example 1 ( Output to Html normally) */

        $renderService = new RenderToHtmlService($feed, $limit);
        (new RenderServiceProvider($renderService))->render();

    /*
     *  Example 2 ( Output with Character limit)
     */

    $renderService = new RenderWithCharLimitService($feed, $limit, $limitTitle, $limitDesc);
    (new RenderServiceProvider($renderService))->render();





?>
