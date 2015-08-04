<?php

require_once('./helpers/fetchRuleHelper.php');


/////////////////////////////////////
//
//  Interface
//
/////////////////////////////////////

/**
 * Interface RenderInterface
 */
interface RenderInterface {

    /**
     * @return mixed
     */
    public function render();
}

/////////////////////////////////////
//
//  Abstract Class
//
/////////////////////////////////////


/**
 * Class RenderServiceAbstract
 */
abstract class RenderServiceAbstract {

    /**
     * @var
     */
    protected $feed;
    /**
     * @var
     */
    protected $limit;

    /**
     * @param $feed
     * @param $limit
     */
    abstract public function __construct($feed, $limit);

    /**
     * @return mixed
     */
    abstract public function render();

}


/////////////////////////////////////
//
//  Class List
//
/////////////////////////////////////


/**
 * Class RenderToHtmlService
 */
class RenderToHtmlService extends RenderServiceAbstract implements RenderInterface {


    /**
     * @param $feed
     * @param $limit
     */
    public function __construct($feed, $limit)
    {
        $this->feed = $feed;
        $this->limit = $limit;
    }

    /**
     *
     */
    public function render()
    {
        $limit = $this->limit;
        for ($x = 0; $x < $limit; $x ++)
        {
            $title = fetchRuleHelper::titleGenerate($this->feed, $x);
            $link = fetchRuleHelper::linkGenerate($this->feed, $x);
            $description = fetchRuleHelper::descGenerate($this->feed, $x);
            $date = fetchRuleHelper::dateGenerate($this->feed, $x);

            echo '<p><strong><a href="' . $link . '" title="' . $title . '">' . $title . '</a></strong>';
            echo '<small><em>Posted on ' . $date . '</em></small></p>';
            echo '<p>' . $description . '</p>';
        }

    }

}


/**
 * Class RenderWithCharLimitService
 */
class RenderWithCharLimitService extends RenderServiceAbstract implements RenderInterface {

    /**
     * @var string
     */
    protected $limitTitle;
    /**
     * @var string
     */
    protected $limitDesc;

    /**
     * @param $feed
     * @param $limit
     * @param string $limitTitle
     * @param string $limitDesc
     */
    public function __construct($feed, $limit, $limitTitle = '', $limitDesc = '')
    {
        $this->feed = $feed;
        $this->limit = $limit;
        $this->limitTitle = $limitTitle;
        $this->limitDesc = $limitDesc;

    }

    /**
     *
     */
    public function render()
    {

        $limit = $this->limit;
        for ($x = 0; $x < $limit; $x ++)
        {
            $title = fetchRuleHelper::titleGenerateWithLimit($this->feed, $x, $this->limitTitle);
            $description = fetchRuleHelper::descGenerateWithLimit($this->feed, $x, $this->limitDesc);
            $date = fetchRuleHelper::dateGenerate($this->feed, $x);

            echo '<p>' . $title . '</p>';
            echo '<p>' . 'Posted on ' . $date . '</p>';
            echo '<p>' . $description . '</p>';
        }
    }

}


/////////////////////////////////////
//
// Service Provider Class
//
/////////////////////////////////////

/**
 * Class RenderServiceProvider
 */
class RenderServiceProvider {

    /**
     * @var RenderInterface
     */
    protected $renderService;

    /**
     * @param RenderInterface $renderService
     */
    public function __construct(RenderInterface $renderService)
    {
        $this->renderService = $renderService;
    }

    /**
     *
     */
    public function render()
    {
        $this->renderService->render();
    }
}