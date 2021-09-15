<?= '<?php' ?>


namespace <?= $namespace ?>;

use Yii;
use yii\base\Model;


class <?= $className ?> extends common\components\<?= $component ?>\AthenaOauth
{
    <?php /*foreach ($clientEndPoints as $clientEndPoint => $endpoint): ?>
        <?php if(strpos($endpoint['finalPathName'], "{") == FALSE): ?>
        const URL_SERVICE_<?= strtoupper($endpoint['finalPathName']) ?> = "<?= $endpoint['finalPathName'] ?>";
        <?php endif; ?>
    <?php endforeach;*/ ?>

    <?php foreach ($clientEndPoints as $clientEndPoint => $endpoint): ?>
        <?php if($endpoint['flagList'] === TRUE): ?>
        public function <?= $endpoint['operationId'] ?>(array $queryParams = [], array $payload = [])
        {
            $path = Yii::$app->params['version']."/".Yii::$app->params['practiceID']."/".<?= strtoupper($endpoint['finalPathName']) ?>;
            $dataResponse = $this->callMethod($path, '<?= $endpoint['verb'] ?>');
            $dataApiModel = [];
            if($dataResponse['success']){
                foreach ($dataResponse['data']['<?= $endpoint['finalPathName'] ?>'] as $key => $value){
                    array_push($dataApiModel, new common\components\<?= $component ?>\apiModels\<?= $endpoint['schema'] ?>Api($value));
                }

                return $dataApiModel;
            }else{
                return $dataResponse['message'];
            }
        }
        <?php elseif($endpoint['flagList'] === FALSE): ?>
        public function <?= $endpoint['operationId'] ?>(array $queryParams = [], array $payload = [], <?php if($endpoint['verb'] === 'get' || $endpoint['verb'] === 'delete' || $endpoint['verb'] === 'put'): ?>$id, <?php endif; ?>array $patientInfo)
        {
            $path = Yii::$app->params['version']."/".Yii::$app->params['practiceID']."/<?= $endpoint['pathname'] ?>"<?php if($endpoint['verb'] === 'get' || $endpoint['verb'] === 'delete'): ?>."/".$id<?php endif; ?>;
            $dataResponse = $this->callMethod($path, '<?= $endpoint['verb'] ?>' <?php if($endpoint['verb'] === 'post' || $endpoint['verb'] === 'put'): ?>, $patientInfo<?php endif; ?>);
            if($dataResponse['success']){
                return new common\components\<?= $component ?>\apiModels\<?= $endpoint['schema'] ?>Api($dataResponse['data']<?php if($endpoint['verb'] === 'get'): ?>[0]<?php endif; ?>);
            }else{
                return $dataResponse['message'];
            }
        }
        <?php endif; ?>
    <?php endforeach; ?>
}
