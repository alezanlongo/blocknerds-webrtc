<?= '<?php' ?>


namespace <?= $namespace ?>;

use Yii;
use yii\base\Model;


class <?= $className ?> extends \common\components\<?= $component ?>\AthenaOauth
{
    <?php /*foreach ($clientEndPoints as $clientEndPoint => $endpoint): ?>
        <?php if(strpos($endpoint['finalPathName'], "{") == FALSE): ?>
        const URL_SERVICE_<?= strtoupper($endpoint['finalPathName']) ?> = "<?= $endpoint['finalPathName'] ?>";
        <?php endif; ?>
    <?php endforeach;*/ ?>
<?php foreach ($clientEndPoints as $clientEndPoint => $endpoint): ?>

    public function <?= $endpoint['operationId'] ?>(array $queryParams = [], array $payload = [])
    {
<?php
$path = str_replace('v1', Yii::$app->params['version'], $endpoint['pathname']);
//$path = str_replace('{practiceid}', Yii::$app->params['practiceID'], $path);
?>
        $path = '<?= $path ?>';

        foreach($queryParams as $parameter => $paramValue){
            $path = str_replace('{'.$parameter.'}', $paramValue, $path);
        }
        //FIXME: add exception

        $dataResponse = $this->callMethod($path, '<?= $endpoint['verb'] ?>' , $payload);
        if($dataResponse['success']){
<?php if($endpoint['flagList'] === TRUE): ?>
 $dataApiModel = [];
 foreach ($dataResponse['data']['<?= $endpoint['finalPathName'] ?>'] as $key => $value){
    array_push($dataApiModel, new  \common\components\<?= $component ?>\apiModels\<?= $endpoint['schema'] ?>Api($value));
 }
    return $dataApiModel;
<?php elseif($endpoint['flagList'] === FALSE): ?>
            return new \common\components\<?= $component ?>\apiModels\<?= $endpoint['schema'] ?>Api($dataResponse['data']<?php if($endpoint['verb'] === 'get'): ?>[0]<?php endif; ?>);
<?php endif; ?>
        }else{
            return $dataResponse['message'];
        }
    }
<?php endforeach; ?>
}
