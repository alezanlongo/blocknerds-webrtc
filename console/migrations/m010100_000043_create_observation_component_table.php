<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000043_create_observation_component_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%observation_component}}', [
            'id' => $this->primaryKey(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'valueQuantity__value' => $this->string(),
            'valueQuantity__comparator' => $this->string(),
            'valueQuantity__unit' => $this->decimal(),
            'valueQuantity__system' => $this->string(),
            'valueQuantity__code' => $this->string(),
            'valueCodeableConcept__coding' => $this->json(),
            'valueCodeableConcept__text' => $this->string(),
            'valueString' => $this->json(),
            'valueRange__low' => $this->string(),
            'valueRange__high' => $this->string(),
            'valueRatio__numerator' => $this->json(),
            'valueRatio__denominator' => $this->json(),
            'valueSampledData__origin' => $this->json(),
            'valueSampledData__period' => $this->decimal(),
            'valueSampledData__factor' => $this->decimal(),
            'valueSampledData__lowerLimit' => $this->decimal(),
            'valueSampledData__upperLimit' => $this->decimal(),
            'valueSampledData__dimensions' => $this->integer(),
            'valueSampledData__data' => $this->string(),
            'valueAttachment__contentType' => $this->string(),
            'valueAttachment__language' => $this->string(),
            'valueAttachment__data' => $this->string(),
            'valueAttachment__uri' => $this->string(),
            'valueAttachment__size' => $this->integer(),
            'valueAttachment__hash' => $this->string(),
            'valueAttachment__title' => $this->string(),
            'valueAttachment__creation' => $this->string(),
            'valueTime' => $this->string(),
            'valueDateTime' => $this->string(),
            'valuePeriod__start' => $this->string(),
            'valuePeriod__end' => $this->string(),
            'dataAbsentReason__coding' => $this->json(),
            'dataAbsentReason__text' => $this->string(),
            'observation_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-component-observation_id',
            'observation_component',
            'observation_id',
            'observation',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%observation_component}}');
    }
}
