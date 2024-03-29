<?php

/*
 * This file is part of the BaicProject/NowPay-PHP-SDK.
 *
 * (c) gl <gl@baic.io>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BaicProject\NowPaySDK;

use GuzzleHttp\Client;
use BaicProject\NowPaySDK\Exceptions\HttpException;

/**
 * Class Baic.
 */
class Baic
{
    protected $apiPrefix = 'http://140.143.225.189:8080/paygateway';
    protected $apiGetToken = '/sdk/getToken';                                           //获取Token
    protected $apiGetPorder = '/sdk/getPorder';                                         //获取Porder
    protected $apiSelectByTransactionNo = '/sdk/selectByTransactionNo';                 //根据交易号订单查询
    protected $apiSelectOrderByTime = '/sdk/selectOrderByTime';                         //根据时间区间订单查询
    protected $apiSelectOrderByPage = '/sdk/selectOrderByPage';                         //订单分页查询
    protected $apiSelectRefundByTransactionNo = '/sdk/selectRefundByTransactionNo';     //根据交易号退款查询
    protected $apiSelectRefundRecordByPage = '/sdk/selectRefundRecordByPage';           //退款订单分页查询
    protected $apiSdkRefundRequest = '/sdk/sdkRefundRequest';                           //退款

    /**
     * @var string
     */
    protected $sdkId;

    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var array
     */
    protected $guzzleOptions = [];

    /**
     * Baic constructor.
     *
     * @param string $sdkId
     * @param string $appKey
     */
    public function __construct($sdkId, $appKey)
    {
        $this->sdkId = $sdkId;
        $this->appKey = $appKey;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $options
     */
    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 获取Token
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function getToken()
    {
        $url = $this->apiPrefix . $this->apiGetToken;
        $options = [
            'connect_timeout' => 3,
            'query' => [
                'sdkId' => $this->sdkId,
                'appKey' => $this->appKey
            ],
        ];

        $this->setGuzzleOptions($options);
        try {
            $response = $this->getHttpClient()->get($url)->getBody()->getContents();
            return \json_decode($response, true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取Porder
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function getPorder($data)
    {
        $url = $this->apiPrefix . $this->apiGetPorder;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 订单号订单查询
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function selectByTransactionNo($data)
    {
        $url = $this->apiPrefix . $this->apiSelectByTransactionNo;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 时间区间订单查询
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function selectOrderByTime($data)
    {
        $url = $this->apiPrefix . $this->apiSelectOrderByTime;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 订单分页查询
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function selectOrderByPage($data)
    {
        $url = $this->apiPrefix . $this->apiSelectOrderByPage;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 根据交易号退款查询
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function selectRefundByTransactionNo($data)
    {
        $url = $this->apiPrefix . $this->apiSelectRefundByTransactionNo;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 退款订单分页查询
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function selectRefundRecordByPage($data)
    {
        $url = $this->apiPrefix . $this->selectRefundRecordByPage;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * 退款操作
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function sdkRefundRequest($data)
    {
        $url = $this->apiPrefix . $this->apiSdkRefundRequest;
        return $this->doPostFormUrlEncoded($url, $data);
    }

    /**
     * application/x-www-form-urlencoded POST请求
     * @param string $url
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \BaicProject\NowPaySDK\Exceptions\HttpException
     */
    public function doPostFormUrlEncoded($url, $data)
    {
        $options = [
            'connect_timeout' => 3,
            'form_params' => $data
        ];
        $this->setGuzzleOptions($options);

        try {
            $response = $this->getHttpClient()->post($url)->getBody()->getContents();
            return \json_decode($response, true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}