<?php
namespace Ddc\CoreBundle\Service\Express\SfExpress;
use Ddc\CoreBundle\Service\Express\SfExpress\Response as SFResponse;
use Ddc\StoreBundle\Entity\Deliver;
use Ddc\StoreBundle\Entity\OrderAddress;
use Ddc\CoreBundle\Service\Express\ExpressPlugin;
use Proxies\__CG__\Ddc\StoreBundle\Entity\OrderProduct;

class XmlHelper{



    /**
     * 格式化数据返回XML
     * @return String
     */
    public function returnXml($body, $service)
    {     

        //生成xml文件
        $xml0bj = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><Request ><Head></Head></Request>");
        
        return $this->arrayToXml(array('Body'=>$body), $xml0bj);
    }

    /**
     * 数组转XML
     * @param $arr
     * @param \SimpleXMLElement $xml
     * @param bool $root
     * @return String
     */
    public function arrayToXml($arr, $xml, $root = true)
    {
        foreach ($arr as $key => $value) {
            if (is_numeric($key)) {
                if (is_array($value)) {
                    $this->arrayToXml($value, $xml, false);
                }
            } else {
                //加入子节点
                $child = $xml->addChild($key);
                if (isset($value['_attr'])) {
                    foreach ($value['_attr'] as $k => $v) {
                        $child->addAttribute($k , $v);
                    }
                    unset($value['_attr']);
                }
                $this->arrayToXml($value, $child , false);
            }
        }

    	return $xml->asXml();
    }

    /**
     * 根据xml返回数组
     * @param \SimpleXMLElement|string $xml
     * @return array or false
     */
    protected function xmlToArray($xml)
    {
        if(is_string($xml)){
            $xml = simplexml_load_string($xml);
        }
        /**
         * @var  \SimpleXMLElement $xml
         */
        $array = array();
        if ($xml->Head != "OK") {
            $attr = array();
            foreach ($xml->ERROR[0]->attributes() as $key => $value) {
                $attr[$key] = $value->__toString();
            }
            $array['ERROR']['_attr'] = $attr;
            $array['_value'] = $xml->ERROR[0]->__toString();
        } else {
            foreach ($xml->Body->children() as $key => $value) {
                if ($value->attributes()->count()>0) {
                    foreach ($value->attributes() as $_k => $_v) {
                         $array[$key]['_attr'][$_k] = $_v->__toString();
                    }
                }
                if ($value->children()->count()>0) {
                    foreach ($value->children() as $_k => $_v) {
                        $valueArray = array();
                        foreach ($_v->attributes() as $__k => $__v) {
                             $valueArray[$__k] = $__v->__toString();
                         }
                         $array[$key]['_value'][] = $valueArray;
                    }
                }           
            }
        }

        return $array;
    }
}