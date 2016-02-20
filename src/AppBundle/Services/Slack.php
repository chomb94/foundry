<?php

namespace AppBundle\Services;

use AppBundle\Base\BaseService;

class Slack extends BaseService
{
    public function send($botname, $channel, $title, $link, $text, $type='default')
    {
        $client = new \Guzzle\Http\Client();
        switch ($type) {
          case 'create_family':
            $color = "good";
            break;
          default:
            $color = '#0084BB';
        }
        $content =  json_encode([
          'username' => $botname,
          'channel'  => $channel,
          'attachments' => [[
              'fallback' => $title.' - '.$text.' - '.$link,
              'title' => $title,
              'title_link' => $link,
              'text'=> $text,
              'color'=> $color,
              ]],
          ]);

        $request = $client->post(
           $this->getParameter('slack.endpoint'), [], $content
        );
        $client->send($request);
    }
}

