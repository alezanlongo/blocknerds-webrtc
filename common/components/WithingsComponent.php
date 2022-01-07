<?php

use common\components\Withings\WithingsClient;
use yii\base\Component;

class WithingsComponent extends Component{
    private $client;

    public function __construct(WithingsClient $client)
    {
        $this->client = $client;
    }
    
    public function something()
    {
        # code...
    }




}