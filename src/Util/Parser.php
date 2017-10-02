<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/10/13
 * Time: 10:39
 */

namespace Util;

class Parser
{
     public function toArr($file,$readerName = 'Word2007'){
        $php_word = \PhpOffice\PhpWord\IOFactory::load($file,$readerName);
        $obj_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word, 'HTML');
        $file = tempnam(sys_get_temp_dir(), 'Tux');
        $obj_writer->save($file);
         return $this->htmlToArr(file_get_contents($file));
    }
    public function xmlToArr($xml){
        $xml = simplexml_load_string($xml);
        return unserialize(serialize(json_decode(json_encode((array) $xml), 1)));
    }




    public function htmlToArr($str){
        $html_dom = new \HtmlParser\ParserDom($str);
        return $this->getArr($html_dom->node);
    }

    /**
     * @param  \DOMDocument $node
     * @return array
     */
    protected function getArr($node)
    {
        $attr = [];
        if(!empty($node->attributes))
            foreach ($node->attributes as $k => $v) {
                $attr[$k] = $node->attributes->getNamedItem($k)->nodeValue;
            }
        $rs = ['_attr' => $attr, '_tag' => $node->nodeName, '_text' => $node->textContent];
        if (!empty($node->childNodes)) {
//            $rs['_text'] = [];
            if ($node->childNodes->length == 1  && $node->childNodes->item(0)->nodeName == '#text') {
                $rs['_text'] = $node->childNodes->item(0)->textContent;
            }else{
                $nodes = [];
                foreach ($node->childNodes as $k => $v) {
                    if($v->nodeName == '#text' && $v->textContent===''){
                        continue;
                    }
                    $nodes[] = $v;
                }

                foreach ($nodes as $k => $v) {
                    $rs[$v->nodeName . $k] = $this->getArr($v);
                }
            }

        }

        return $rs;
    }

}