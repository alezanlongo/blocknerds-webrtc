<?php
namespace common\components;

use Yii;
use common\components\Snomed\Snomed;
use yii\base\Component;

class SnomedComponent extends Component
{
    private $client;

    public function __construct(Snomed $client)
    {
        $this->client = $client;
    }

    public function searchByTerm($term)
    {
        $results = $this->client->getConceptByString($term);

        return array_map(function($snomed){
                return [
                    'id' => $snomed['conceptId'],
                    'name' => $snomed['fsn']['term']
                ];
            },$results['items']);
    }

}
