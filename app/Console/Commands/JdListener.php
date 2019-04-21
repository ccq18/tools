<?php

namespace App\Console\Commands;


use App\Console\Commands\Jd\JdSpider;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;
use Util\ClientHelper;
use Util\SpiderHelper;

class JdListener extends Command
{
    protected $signature = 'jd:listener {--show=true}';
    protected $client;


    public function __construct()
    {
        parent::__construct();

        $this->client = new ClientHelper();

    }

    public function handle()
    {

        ClientHelper::debug();
        $url = "";
        $infos = $this->getHeadList($url);
        // $itemUrl = "https://so.m.jd.com/list/itemSearch._m2wq_list?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&datatype=1&callback=jdSearchResultBkCbE&page=6&pagesize=10&ext_attr=no&brand_col=no&price_col=no&color_col=no&size_col=no&ext_attr_sort=no&multi_suppliers=yes&rtapi=no&area_ids=1,72,2819";
        // $rs = $this->getHeadItems($itemUrl);
        //  SpiderHelper::formatUrlToCode("https://so.m.jd.com/list/itemSearch.action?ptag=37287.6.5&promotion_aggregation=yes&activityId=50004594574&skuId=36700607795&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83");
       // SpiderHelper::formatUrlToCode("https://so.m.jd.com/list/itemSearch._m2wq_list?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&datatype=1&callback=jdSearchResultBkCbE&page=6&pagesize=10&ext_attr=no&brand_col=no&price_col=no&color_col=no&size_col=no&ext_attr_sort=no&multi_suppliers=yes&rtapi=no&area_ids=1,72,2819");



    }


    public function getHeadItems(
        $activityId,
        $page = 1,
        $pagesize = 10
    ) {

        $params = [
            'activityId'            => $activityId,
            'promotion_aggregation' => 'yes',
            'neverpop'              => 'yes',
            'datatype'              => '1',
            'callback'              => 'jdSearchResultBkCbE',
            'page'                  => $page,
            'pagesize'              => $pagesize,
            'ext_attr'              => 'no',
            'brand_col'             => 'no',
            'price_col'             => 'no',
            'color_col'             => 'no',
            'size_col'              => 'no',
            'ext_attr_sort'         => 'no',
            'multi_suppliers'       => 'yes',
            'rtapi'                 => 'no',
            'area_ids'              => '1,72,2819',
        ];
        $url = SpiderHelper::buildUrl('https://so.m.jd.com/list/itemSearch._m2wq_list', $params);
        $content = $this->client->get($url);
        preg_match('/jdSearchResultBkCbE\((.*)\)/is', $content, $match);

        return $this->decode($match[1]);
    }


    public function getHeadList($url)
    {

        // $params =
        // ?ptag=37287.6.5&promotion_aggregation=yes&activityId=50004594574&skuId=36700607795&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83
        // $url = SpiderHelper::buildUrl('https://so.m.jd.com/list/itemSearch.action', $params);
        $content = $this->client->get($url);
        preg_match('/mcoupon_index_json(.*?)\<\/script\>/is', $content, $match);

        preg_match('/_sfpageinit\((.*)\);/is', $match[1], $match);

        return $this->decode($match[1]);
    }


    public function getProduct($productId)
    {
        $content = $this->client->get("https://item.m.jd.com/product/{$productId}.html");
        preg_match('/window._itemInfo = (.*?)\<\/script\>/is', $content, $match);
        $content = trim($match[1], ";\n() ");
        $this->logfile('data', $content);

        return $this->decode($content);
    }

    protected function decode($json)
    {
        return json_decode(str_replace('\x', '\u00', $json), true);
    }


}