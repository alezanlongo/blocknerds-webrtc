<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

/*
	Container Closure Definition

	frontend\AthenaClient::class =>
			function ($container, $params, $config) {
    			$client = new frontend\AthenaClient;
    			return $client;
    		}

*/

Yii::$container->setDefinitions(
	[

		common\components\Athena\AthenaClient::class => common\components\Athena\AthenaClient::class,
		common\components\Snomed\Snomed::class => common\components\Snomed\Snomed::class
    ]
);