<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2017/2/14
 * Time: 下午11:53
 */

namespace Util;


class DnspodApi
{
    protected $base_params;

    /**
     * DnspodApi constructor.
     * @param $base_params $base_params = [
     * 'login_email' => '348578429@qq.com',
     * 'login_password' => 'hyl2004346hyl',
     * 'format' => 'json',
     * ];
     */
    public function __construct($base_params)
    {
        $this->base_params = $base_params;
        $this->http = new \Util\SpiderHttp();

    }

    /**记录信息
     * @param $domain_id
     * @param $record_id
     * @return mixed|null
     */
    public function getRecord($domain_id, $record_id)
    {
        return $this->http->postApi('https://dnsapi.cn/Record.Info',
            array_merge($this->base_params, [
                'domain_id' => $domain_id,
                'record_id' => $record_id
            ])
        );
    }

    /**域名列表
     * @return mixed|null
     */
    public function getDomains()
    {
        return $this->http->postApi('https://dnsapi.cn/Domain.List',
            array_merge($this->base_params, [

            ])
        );
    }

    /** 记录列表
     * @param $domain_id
     * @return mixed|null
     */
    public function getRecords($domain_id)
    {
        return $this->http->postApi('https://dnsapi.cn/Record.List',
            array_merge($this->base_params, [
                'domain_id' => $domain_id,
            ])
        );
    }

    /** 修改记录
     * @param $domain_id
     * @param $record
     * @param $value
     * @return mixed|null
     */
    public function setRecord($domain_id, $record, $value)
    {
        return $this->http->postApi('https://dnsapi.cn/Record.Modify',
            array_merge($this->base_params, [
                'domain_id' => $domain_id,
                'record_id' => $record['id'],
                'sub_domain' => $record['sub_domain'],
                'record_type' => $record['record_type'],
                'record_line' => $record['record_line'],
                'record_line_id' => $record['record_line_id'],
                'value' => $value,
                'mx' => $record['mx'],
                'ttl' => $record['ttl'],
                'status' => $record['enabled'],
                'weight' => $record['weight'],
            ])
        );

    }
    //记录信息
//$rs = postApi('https://dnsapi.cn/Record.Info',
//        array_merge($base_params, [
//            'domain_id' => 1,
//            'record_id' => 1
//        ])
//    );
//域名列表
//$rs = postApi('https://dnsapi.cn/Domain.List',
//        array_merge($base_params, [
//
//        ])
//    );
//记录列表
//$rs = postApi('https://dnsapi.cn/Record.List',
//    array_merge($base_params, [
//        'domain_id' => 1,
//    ])
//);
//修改记录
//postApi('https://dnsapi.cn/Record.Modify',
//    array_merge($base_params, [
//        'domain_id'      => $domain_id,
//        'record_id'      => $record['id'],
//        'sub_domain'     => $record['name'],
//        'record_type'    => $record['type'],
//        'record_line'    => $record['line'],
//        'record_line_id' => $record['line_id'],
//        'value'          => $ip,
//        'mx'             => $record['mx'],
//        'ttl'            => $record['ttl'],
//        'status'         => $record['status'],
//        'weight'         => $record['weight'],
//    ])
//);
}