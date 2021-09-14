<?php

namespace common\components;

use Yii;
use frontend\AthenaClient;
use yii\base\Component;

class AthenaComponent extends Component
{
    private $client;

    public function __construct(AthenaClient $client)
    {
        $this->client = $client;
    }

    public function postClient()
    {
        return $this->client->postClient();
    }
}
