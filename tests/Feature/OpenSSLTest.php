<?php

namespace Tests\Feature;


use Tests\TestCase;

class OpenSSLTest extends TestCase
{

    /**
     * @test
     */
    public function testgenerate()
    {
        $privateKey = openssl_pkey_new([
            'private_key_bits' => 2048,  // private key的大小
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        openssl_pkey_export_to_file($privateKey, 'php-private.key');
        $key = openssl_pkey_get_details($privateKey);
        file_put_contents('php-public.key', $key['key']);

        openssl_free_key($privateKey); // 释放资源
        
    }
    /**
     * @test
     */
    public function encrypt()
    {
        
    }

    /**
     * @test
     */
    public function decrypt()
    {

    }
}