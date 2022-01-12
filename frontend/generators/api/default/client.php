<?= '<?php' ?>


namespace <?= $namespace ?>;

use Yii;
use yii\base\Model;


class <?= $className ?> extends \<?= $clientBaseClass ?> 
{
<?php foreach ($clientEndPoints as $clientEndPoint => $endpoint):?>
<?php $paramMethodName = (in_array($endpoint['verb'], ['get', 'delete']))?"query":"body"; ?>
    /**
<?php foreach ($endpoint['parameters'] as $parameter):?>
     * @param <?= $parameter; ?>

<?php endforeach;?>
     * @return <?= $endpoint['schema']; ?>

     */
    public function <?= $endpoint['operationId'] ?>(<?php
foreach ($endpoint['parameters'] as $parameter):
    echo "\$".$parameter.", ";
endforeach;?>array $<?= $paramMethodName; ?> = [])
    {
<?php
$path = str_replace('v1', Yii::$app->params['version'], $endpoint['pathname']);
//$path = str_replace('{practiceid}', Yii::$app->params['practiceID'], $path);
?>
        $path = trim('<?= $path ?>');
<?php foreach ($endpoint['parameters'] as $parameter): ?>
        $path = str_replace('{<?= $parameter ?>}', $<?= $parameter ?>, $path);
<?php endforeach;?>

        $dataResponse = $this->callMethod($path, '<?= $endpoint['verb'] ?>' , $<?= $paramMethodName; ?>);
        if($dataResponse['success']){
<?php $apiModel = $endpoint['apiModel'] ?? $endpoint['schema'].'Api'; ?>
<?php if($endpoint['flagList'] === TRUE): ?>
            $dataApiModel = [];
            $responseData = (isset($dataResponse['data']['<?= ($endpoint['listKey']) ? $endpoint['listKey'] : $endpoint['finalPathName'] ?>'])) ? $dataResponse['data']['<?= ($endpoint['listKey']) ? $endpoint['listKey'] : $endpoint['finalPathName'] ?>'] : $dataResponse['data'];
            foreach ($responseData as $key => $value){
                array_push($dataApiModel, new  \common\components\<?= $component ?>\apiModels\<?= $apiModel ?>($value));
            }
            return $dataApiModel;
<?php elseif($endpoint['flagList'] === FALSE): ?>
            return new \common\components\<?= $component ?>\apiModels\<?= $apiModel ?>($dataResponse['data']);
<?php endif; ?>
        }else{
            return $dataResponse['message'];
        }
    }
<?php endforeach; ?>
}
