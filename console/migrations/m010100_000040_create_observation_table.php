<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000040_create_observation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%observation}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'category__coding' => $this->json(),
            'category__text' => $this->string(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'subject__display' => $this->json(),
            'subject__reference' => $this->string(),
            'encounter__display' => $this->json(),
            'encounter__reference' => $this->string(),
            'effectiveDateTime' => $this->string(),
            'effectivePeriod__start' => $this->string(),
            'effectivePeriod__end' => $this->string(),
            'issued' => $this->string(),
            'performer__display' => $this->json(),
            'performer__reference' => $this->string(),
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
            'interpretation__coding' => $this->json(),
            'interpretation__text' => $this->string(),
            'comments' => $this->string(),
            'bodySite__coding' => $this->json(),
            'bodySite__text' => $this->string(),
            'method__coding' => $this->json(),
            'method__text' => $this->string(),
        ]);

        $this->createTable('{{%observation_reference_range}}', [
            'id' => $this->primaryKey(),
            'low' => $this->string(),
            'high' => $this->string(),
            'meaning__coding' => $this->json(),
            'meaning__text' => $this->string(),
            'age__low' => $this->string(),
            'age__high' => $this->string(),
            'text' => $this->string(),
            'observation_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reference_range-observation_id',
            'observation_reference_range',
            'observation_id',
            'observation',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%observation_related}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'observation_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-related-observation_id',
            'observation_related',
            'observation_id',
            'observation',
            'id',
            'CASCADE'
        );

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
        $this->dropTable('{{%observation_related}}');
        $this->dropTable('{{%observation_reference_range}}');
        $this->dropTable('{{%observation}}');
    }
}
