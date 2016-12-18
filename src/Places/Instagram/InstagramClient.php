<?php

namespace Places\Instagram;

use GuzzleHttp\Client;

class InstagramClient
{
    const INSTAGRAM_API_URL = "https://api.instagram.com/v1";

    private $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getMediaFromShortCode($shortCode)
    {
        $client = new Client;
        $response = $client->request(
            'GET', sprintf("%s/media/shortcode/%s?access_token=%s", self::INSTAGRAM_API_URL, $shortCode, $this->accessToken)
        );

        return json_decode((string) $response->getBody(), true);
    }
}
