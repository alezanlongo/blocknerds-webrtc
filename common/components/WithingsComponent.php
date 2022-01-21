<?php

namespace common\components;

use common\components\Withings\models\inline_response_200_2_body;
use Yii;
use yii\base\Component;
use common\components\Withings\WithingsClient;
use yii\helpers\VarDumper;

class WithingsComponent extends Component
{
    private $client;

    public function __construct(WithingsClient $client)
    {
        $this->client = $client;
    }

    public function getMeasureGetmeas()
    {
        $measureGetmeasApi = $this->client->measureGetmeas([
            'action' => 'getmeas',
        ]);
VarDumper::dump($measureGetmeasApi, $depth = 10, $highlight = true);
die;        
        return inline_response_200_2_body::createFromApiObject($measureGetmeasApi['body']);
    }
}
