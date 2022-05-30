<?php


namespace App\Handle;

use GuzzleHttp\Client;
use QL\QueryList;

class ClientHandle
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function queryBody($url, $rules)
    {
        $html = $this->sendRequest($url);

        $data = QueryList::Query($html, $rules)->getData(function ($item) {
            if (array_key_exists('link',$item)){
                $content = $this->sendRequest($item['link']);
                $item['post'] = QueryList::Query($content, [
                    'title' => ['div.pull-left>span', 'text'],
                    'review' => ['p>span.text-mute:eq(0)', 'text'],
                    'comment' => ['p>span.text-mute:eq(1)', 'text'],
                    'content' => ['div.content-body', 'html'],
                    'created_at' => ['p>a>span', 'title'],
                    'updated_at' => ['p>a:eq(2)', 'data-tooltip']
                ])->data[0];
            }
            return $item;
        });
//查看采集结果
        return $data;
    }

    private function sendRequest($url)
    {

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'Accept' => 'application/json',
                'X-Foo' => ['Bar', 'Baz']
            ],
            'form_params' => [
                'foo' => 'bar',
                'baz' => ['hi', 'there!']
            ],
            'timeout' => 3.14,
        ]);

        $body = $response->getBody();

//获取到页面源码
        $html = (string)$body;

        return $html;
    }
}
