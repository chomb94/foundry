<?php

namespace AppBundle\Services;

use AppBundle\Base\BaseService;

class Slack extends BaseService
{
    public function send($botname, $channel, $text)
    {
        $client = new \Guzzle\Http\Client();

        $request = $client->post(
           $this->getParameter('slack.endpoint'), [],
               json_encode([
                   'username' => $botname,
                   'channel'  => $channel,
                   'text'     => $text,
               ])
        );

        $client->send($request);
    }
}

