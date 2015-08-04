<?php

/////////////////////////////////////
//
//  Interface
//
/////////////////////////////////////

interface FetchInterface {


    /**
     * @return mixed
     */
    public function load();

    /**
     * @return mixed
     */
    public function countTotalFeed();

    /**
     * @return mixed
     */
    public function fetch();

    /**
     * @return mixed
     */
    public function feed();
}


/**
 * Class FetchFromUrlService
 */


/////////////////////////////////////
//
//  Abstract Class
//
/////////////////////////////////////

abstract class FetchServiceAbstract {

    /**
     * @return mixed
     */
    abstract public function load();

    /**
     * @return mixed
     */
    abstract public function countTotalFeed();

    /**
     * @return mixed
     */
    abstract public function fetch();

    /**
     * @return mixed
     */
    abstract public function feed();

}

/////////////////////////////////////
//
// Class List
//
/////////////////////////////////////

class FetchFromUrlService extends FetchServiceAbstract implements FetchInterface {

    /**
     * @var DOMDocument
     */
    protected $rss;

    /**
     * @var array
     */
    protected $url = [];

    /**
     * @var
     */
    protected $feed;

    /**
     * @param DOMDocument $domDoc
     * @param $url
     */
    public function __construct(DOMDocument $domDoc, $url)
    {
        $this->rss = $domDoc;
        $this->url = $url;
    }

    /**
     * @param $url
     */
    /*
    public function addUrl($url) // => Not really working yet
    {
        $this->url[] = $url;
    }
    */

    /**
     *
     */
    public function load()
    {
        if (@$this->rss->load($this->url) == false) // => change here when you want to implement multiple urls
        {
            throw new Exception('Can not load the url. You may want to check that again !');
        };
    }

    /**
     * @return int
     */
    public function countTotalFeed()
    {
        $x = $this->rss->getElementsByTagName('title');
        return $x->length;
    }

    /**
     *
     */
    public function fetch()
    {

        $this->feed = array();
        foreach ($this->rss->getElementsByTagName('item') as $node)
        {

            // Should be more scalable
            $item = array(
                'title'=> $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
            );
            array_push($this->feed, $item);

        }
    }

    /**
     * @return mixed
     */
    public function feed()
    {
        return $this->feed;
    }

}



/////////////////////////////////////
//
//  Service Provider Class
//
/////////////////////////////////////

class FetchServiceProvider {

    /**
     * @var FetchInterface
     */
    protected $fetchService;

    /**
     * @param FetchInterface $fetchService
     */
    public function __construct(FetchInterface $fetchService)
    {
        $this->fetchService = $fetchService;
    }

    /**
     *
     */
    public function load()
    {
        $this->fetchService->load();
    }

    /**
     * @return mixed
     */
    public function countTotalFeed()
    {
        return $this->fetchService->countTotalFeed();
    }

    /**
     *
     */
    public function fetch()
    {
        $this->fetchService->fetch();
    }

    /**
     * @return mixed
     */
    public function feed()
    {
        return $this->fetchService->feed();
    }


}