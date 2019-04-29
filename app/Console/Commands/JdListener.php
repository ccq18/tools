<?php

namespace App\Console\Commands;


use App\Console\Commands\Jd\JdSpider;
use App\Model\JdProduct;
use App\Model\Task;
use Commands\SpiderBase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;
use Util\ClientHelper;
use Util\RequestHelper;

class JdListener extends SpiderBase
{
    protected $signature = 'jd:listener';
    protected $client;
    protected $baseUrl = '';
    protected $domain = 'jd.com';

    public function __construct()
    {
        parent::__construct();
        // $this->addTask()
        $this->client = new ClientHelper();
        ClientHelper::debug();

    }



//     // $url = "https://so.m.jd.com/list/itemSearch.action?ptag=37287.6.5&promotion_aggregation=yes&activityId=50004594574&skuId=36700607795&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83";
//
//     // // $itemUrl = "https://so.m.jd.com/list/itemSearch._m2wq_list?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&datatype=1&callback=jdSearchResultBkCbE&page=6&pagesize=10&ext_attr=no&brand_col=no&price_col=no&color_col=no&size_col=no&ext_attr_sort=no&multi_suppliers=yes&rtapi=no&area_ids=1,72,2819";
//
//     // $infos = $this->getAllItems('50004594574', '跨自营/店铺满减', '满299元减100元');
//     // // $infos = $this->getHeadItems(  '50004594574', 1,10);
//     // unset($infos['data']['searchm']['ObjB_TextCollection']);
// $product = $this->getProduct(25595409532);
//     // SpiderHelper::formatUrlToCode('https://so.m.jd.com/list/itemSearch.action?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&filt_type=catid,L12204M12204;&area_ids=1,72,2819&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83');
//
//     // print_r($rs);
//     // $infos = $this->getHeadItems(  '50004594574', 1,10);
//     //
//     // print_r($infos);
//     // $infos = $this->getProduct(  '50004594574', 1,10);
//
//     // print_r($infos);
//
//     // $product = $this->fetchProduct($productId);
//     // SpiderHelper::simpleShowArr($productId);
//     // // $itemUrl = "https://so.m.jd.com/list/itemSearch._m2wq_list?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&datatype=1&callback=jdSearchResultBkCbE&page=6&pagesize=10&ext_attr=no&brand_col=no&price_col=no&color_col=no&size_col=no&ext_attr_sort=no&multi_suppliers=yes&rtapi=no&area_ids=1,72,2819";
//     // $rs = $this->getHeadItems($itemUrl);
//     //  SpiderHelper::formatUrlToCode("https://so.m.jd.com/list/itemSearch.action?ptag=37287.6.5&promotion_aggregation=yes&activityId=50004594574&skuId=36700607795&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83");
//     SpiderHelper::formatUrlToCode("https://so.m.jd.com/list/itemSearch._m2wq_list?activityId=50004594574&promotion_aggregation=yes&neverpop=yes&datatype=1&callback=jdSearchResultBkCbE&page=6&pagesize=10&ext_attr=no&brand_col=no&price_col=no&color_col=no&size_col=no&ext_attr_sort=no&multi_suppliers=yes&rtapi=no&area_ids=1,72,2819");
//
//


    /**
     * @param $infos [
     * classes
     * ]
     */

    public function formatHead($infos)
    {
        $rs = [];
        $rs['classes'] = $infos['data']['searchm']['ObjCollection'];
        $rs['page'] = $infos['data']['searchm']['Head']['Summary']['Page'];
        $rs['page']['ResultCount'] = $infos['data']['searchm']['Head']['Summary']['ResultCount'];
        $rs['page']['OrgSkuCount'] = $infos['data']['searchm']['Head']['Summary']['OrgSkuCount'];

        return $rs;
    }


    public function search($keyword)
    {
        // keyword=Apple&searchFrom=search&sf=11&as=1
        $params = [
            'keyword'    => $keyword,//'50004594574',
            'searchFrom' => 'search',
            'sf'         => 11,
            'as'         => 1,
        ];
        $url = RequestHelper::buildUrl('https://so.m.jd.com/ware/search.action?', $params);
        $content = $this->client->get($url);
        preg_match('/mindex_json(.*?)\<\/script\>/is', $content, $match);

        preg_match('/_sfpageinit\((.*)\);/is', $match[1], $match);

        return $this->decode($match[1]);
    }

    public function searchItems($keyword, $page, $pagesize)
    {
        $params = [
            'keyword'         => $keyword,
            'datatype'        => '1',
            'callback'        => 'jdSearchResultBkCbA',
            'page'            => $page,
            'pagesize'        => $pagesize,
            'ext_attr'        => 'no',
            'brand_col'       => 'no',
            'price_col'       => 'no',
            'color_col'       => 'no',
            'size_col'        => 'no',
            'ext_attr_sort'   => 'no',
            'merge_sku'       => 'yes',
            'multi_suppliers' => 'yes',
            'area_ids'        => '1,72,2819',
            'qp_disable'      => 'no',
            'fdesc'           => '北京',
            't1'              => '1556132713017',
        ];
        $url = RequestHelper::buildUrl('https://so.m.jd.com/ware/search._m2wq_list', $params);


        $content = $this->client->get($url);

        return $this->decodeJsonP('jdSearchResultBkCbA', $content);
    }


    public function getHeadList($activityId, $search1, $search2)
    {
        // https://so.m.jd.com/ware/search.action?keyword=Apple&searchFrom=search&sf=11&as=1


        $params = [
            'ptag'                  => '37287.6.5',
            'promotion_aggregation' => 'yes',
            'activityId'            => $activityId,//'50004594574',
            'skuId'                 => '36700607795',
            'pro_d'                 => $search1,//'跨自营/店铺满减',
            'pro_s'                 => $search2,//满299元减100元',
        ];
        $url = RequestHelper::buildUrl('https://so.m.jd.com/list/itemSearch.action', $params);
        $content = $this->client->get($url);
        preg_match('/mcoupon_index_json(.*?)\<\/script\>/is', $content, $match);

        preg_match('/_sfpageinit\((.*)\);/is', $match[1], $match);

        return $this->decode($match[1]);
    }


    public function getItems(
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
        $url = RequestHelper::buildUrl('https://so.m.jd.com/list/itemSearch._m2wq_list', $params);
        $content = $this->client->get($url);

        return $this->decodeJsonP('jdSearchResultBkCbE', $content);
    }

    public function formatProducts($infos)
    {
        $rs = [];
        foreach ($infos['data']['searchm']['Paragraph'] as $v) {
            $rs[] = [
                'title'     => $v['Content']['warename'],
                'imageurl'  => $v['Content']['imageurl'],
                'productId' => $v['wareid'],
            ];
        }

        return $rs;
    }

    //197751398
    public function getCoupon($batchId)
    {
        // $content = $this->client->get("https://search.jd.com/Search?coupon_batch={$batchId}");
        $content = $this->client->get("https://a.jd.com/coupons.html?page=100");

        print_r($content);
    }

    public function getProduct($productId)
    {

        //https://wq.jd.com/commodity/promo/get?skuid=25595409532&callback=jsonp6574
        //[data][0][pis]

        $rs = [];

        $content = $this->client->get("https://item.m.jd.com/product/{$productId}.html");
        preg_match('/window._itemInfo = (.*?)\<\/script\>/is', $content, $match);
        $content = trim($match[1], ";\n() ");
        $product = $this->decode($content);
        $rs['promos'] = $product['promov2'][0]['pis'];
        //      "op" => "59.00"
        //       "m" => "128.00"
        //       "id" => "25595409532"
        //       "l" => "128.00"
        //       "p" => "59.00"

        $rs['price'] = $product['stock']['jdPrice']['op'];


        $content = $this->client->get("https://yx.3.cn/service/info.action?ids={$productId}&callback=jsonp424792");
        $info = $this->decodeJsonP('jsonp424792', $content);
        // $rs['info'] =$info[$productId.''];
        $rs['id'] = $productId;
        $rs['info'] = array_only($info[$productId . ''], ['imagePath', 'name']);
        // $content = $this->client->get("https://wq.jd.com/commodity/promo/get?skuid={$productId}&callback=jsonp6574");
        // $promos = $this->decodeJsonP('jsonp6574', $content);
        // $rs['promos'] =$promos['data'][0]['pis'];

//      {   15: "满299元减100元"
// adurl: ""
// customtag: "{}"
// d: "1555862399"
// etg: "25"
// ori: "1"
// pid: "50004594574_10"
// st: "1555603200"
// subextinfo: "{"extType":1,"subExtType":1,"subRuleList":[{"needMoney":"299","rewardMoney":"100","subRuleList":[],"subRuleType":1}]}"
//    }
        //
        $content = $this->client->get("https://wq.jd.com/mjgj/fans/queryusegetcoupon?callback=getCouponListCBA&platform=3&cid=12209&sku={$productId}&popId={$product['stock']['D']['vid']}&t=0.9722696676999263");

        $coupons = $this->decodeJsonP('getCouponListCBA', $content, ';');
        $rs['coupons'] = $coupons['coupons'];

        return $rs;
    }


//优惠券中心
    //https://a.jd.com/coupons.html?page=100
    //https://search.jd.com/Search?coupon_batch=197751398
    protected function decode($json)
    {
        return json_decode(str_replace('\x', '\u00', $json), true);
    }

    protected function decodeJsonP($callbackName, $content, $end = '')
    {
        preg_match('/' . $callbackName . '\((.*)\)' . $end . '/is', $content, $match);

        return $this->decode($match[1]);
    }

    protected function initTask()
    {
        // https://so.m.jd.com/list/itemSearch.action?lng=121.260643&lat=31.329815&activityId=21194353928&un_area=2_2826_51943_0&sid=e77de29ffa406cef198378c1ae93ee3w&_ts=1556453451082&ShareTm=l%2BPXQS64PB1UTK6tW7hnWmXSwe6nyA5w9k59yqZCkxx1fHmHc2lE6WyuiehMn33jVPLXoXjSsCNznSMWIFS098WxzX1KLyhWmMzs5KEZpUGyR8nyuNWxn0BoRqj6KUBMS9u9EDBgfJ0lbcshhhOHpFDntEgY3VicJteHRiPoTyc%3D&ad_od=share&utm_source=androidapp&utm_medium=appshare&utm_campaign=t_335139774&utm_term=Wxfriends&from=singlemessage
        $this->addTask('actsearch', '', ['activityId' => '21194353928','search1'=>'','search2'=>'']);
        // $this->addTask('search', '', ['keyword' => 'apple']);
    }

    protected function runTask(Task $task)
    {


        return $this
            ->addCase('actsearch', function () use ($task) {
                $infos = $this->getHeadList($task->extra['activityId'], $task->extra['search1'],
                    $task->extra['search2']);

                $rs = $this->formatHead($infos);
                $pageSize = 50;
                $pageNum = RequestHelper::getPageNum($rs['page']['ResultCount'], $pageSize);
                for ($page = 1; $page <= $pageNum; $page++) {
                    $this->addTask('getActItems', '',
                        ['activityId' => $task->extra['activityId'], 'page' => $page, 'pageSize' => $pageSize]);

                }

                return $rs;
            })->addCase('getActItems', function () use ($task) {
                $infos = $this->getItems($task->extra['activityId'], $task->extra['page'], $task->extra['pageSize']);
                $products = $this->formatProducts($infos);
                foreach ($products as $product) {
                    $this->addTask('getProduct', '', ['productId' => $product['productId']]);
                }

                return $products;
            })
            ->addCase('search', function () use ($task) {
                $infos = $this->search($task->extra['keyword']);

                $rs = $this->formatHead($infos);
                $pageSize = 50;
                $pageNum = RequestHelper::getPageNum($rs['page']['ResultCount'], $pageSize);
                for ($page = 1; $page <= $pageNum; $page++) {
                    $this->addTask('searchItems', '',
                        ['keyword' => $task->extra['keyword'], 'page' => $page, 'pageSize' => $pageSize]);

                }

                return $rs;
            })->addCase('searchItems', function () use ($task) {
                $infos = $this->searchItems($task->extra['keyword'], $task->extra['page'], $task->extra['pageSize']);
                $products = $this->formatProducts($infos);
                foreach ($products as $product) {
                    $this->addTask('getProduct', '', ['productId' => $product['productId']]);
                }

                return $products;
            })->addCase('getProduct', function () use ($task) {
                $product = $this->getProduct($task->extra['productId']);
                /**
                 * @var JdProduct $jdProduct
                 */
                $jdProduct =JdProduct::findOrNew($task->extra['productId']);
                $jdProduct->name = $product['info']['name'];
                $promos = '';
                foreach ($product['promos'] as $v) {
                    if (isset($v[15])) {
                        $promos .= $v[15] . '|';
                    }

                }
                $jdProduct->promos = $promos;
                $coupons = '';
                foreach ($product['coupons'] as $v) {
                    $coupons .= "满{$v['quota']}减{$v['discount']}-{$v['name']}|";
                }
                $jdProduct->coupons = $coupons;
                $jdProduct->id = $product['id'];
                $jdProduct->url = "https://item.m.jd.com/product/{$product['id']}.html";
                $jdProduct->save();
                return $product;
            })
            ->doCase($task);


    }


    // public function handle()
    // {
    //     $rs = $this->client->getApi('http://service.issue.pw/api/ip');
    //     $rs = $this->getProduct(17757120747);
    //     print_r($rs);
    // }
}