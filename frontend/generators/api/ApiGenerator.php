<?php

namespace frontend\generators\api;

use Yii;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use cebe\yii2openapi\generator\ApiGenerator as ParentApiGenerator;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class ApiGenerator extends ParentApiGenerator
{
    /**
     * @var bool whether to generate Api models from the spec.
     */
    public $generateApiModels = true;

    /**
     * @inheritDoc
     */
    public function generate() {
        $files = parent::generate();
        if ($this->generateApiModels) {
            $models = $this->generateApiModels();
            $modelPath = $this->getPathFromNamespace($this->modelNamespace);
            foreach ($models as $modelName => $model) {
                $className = $modelName;
                $files[] = new CodeFile(
                    Yii::getAlias("$modelPath/$className.php"),
                    $this->render('apiModel.php', [
                        'className' => $className,
                        'namespace' => $this->modelNamespace,
                        'description' => $model['description'],
                        'attributes' => $model['attributes'],
                        'relations' => $model['relations'],
                    ])
                );
                if (!$this->generateModelFaker) {
                    continue;
                }
                $files[] = new CodeFile(
                    Yii::getAlias("$modelPath/{$className}Faker.php"),
                    $this->render('faker.php', [
                        'className' => "{$className}Faker",
                        'modelClass' => $className,
                        'namespace' => $this->modelNamespace,
                        'attributes' => $model['attributes'],
//                        'relations' => $model['relations'],
                    ])
                );
            }
        }

        return $files;
    }

    /**
     * @inheritDoc
     */
    protected function generateModels()
    {
        $models = [];
        foreach ($this->getOpenApi()->components->schemas as $schemaName => $schema) {
            if ($schema instanceof Reference) {
                $schema = $schema->resolve();
            }
            $attributes = [];
            $relations = [];
            if ((empty($schema->type) || $schema->type === 'object') && empty($schema->properties)) {
                continue;
            }
            if (!empty($schema->type) && $schema->type !== 'object') {
                continue;
            }
            if (in_array($schemaName, $this->excludeModels)) {
                continue;
            }

            $flattenSchema = false;
            if($schemaExtensions = $schema->getExtensions() ?? false ) {
                if( array_key_exists('x-flatten', $schemaExtensions) ) {
                    $flattenSchema = true;
                }
            }

            foreach ($schema->properties as $name => $property) {
                if ($property instanceof Reference) {
                    $ref = $property->getJsonReference()->getJsonPointer()->getPointer();
                    $resolvedProperty = $property->resolve();
                    $dbName = "{$name}_id";
                    $dbType = '$this->integer()'; // for a foreign key
                    if (strpos($ref, '/components/schemas/') === 0) {
                        // relation
                        $type = substr($ref, 20);

                        //START FLATTENING
                        if( $flattenSchema ) {
                            $flattenedAttributes = $this->flattenOneToOneRelation($type);
                            if ( $flattenedAttributes ) {
                                $attributes = array_merge($attributes, $flattenedAttributes);
                                continue;
                            }
                        }
                        //END FLATTENING

                        $relations[$name] = [
                            'class' => $type,
                            'method' => 'hasOne',
                            'link' => ['id' => $dbName], // TODO pk may not be 'id'
                        ];
                    } else {
                        $type = $this->getSchemaType($resolvedProperty);
                    }
                } else {
                    $resolvedProperty = $property;
                    $type = $this->getSchemaType($property);
                    $dbName = $name;
                    $dbType = $this->getDbType($name, $property);
                }
                // relation
                if (is_array($type)) {
                    $relations[$name] = [
                        'class' => $type[1],
                        'method' => 'hasMany',
                        'link' => [Inflector::camel2id($schemaName, '_') . '_id' => 'id'], // TODO pk may not be 'id'
                    ];
                    $type = $type[0];
                }

                $attributes[$name] = [
                    'name' => $name,
                    'type' => $type,
                    'dbType' => $dbType,
                    'dbName' => $dbName,
                    'required' => false,
                    'readOnly' => $resolvedProperty->readOnly ?? false,
                    'description' => $resolvedProperty->description,
                    'faker' => $this->guessModelFaker($name, $type, $resolvedProperty),
                ];
            }
            if (!empty($schema->required)) {
                foreach ($schema->required as $property) {
                    if (!isset($attributes[$property])) {
                        continue;
                    }
                    $attributes[$property]['required'] = true;
                }
            }

            $models[$schemaName] = [
                'name' => $schemaName,
                'tableName' => '{{%' . Inflector::camel2id(StringHelper::basename(Inflector::pluralize($schemaName)), '_') . '}}',
                'description' => $schema->description,
                'attributes' => $attributes,
                'relations' => $relations,
            ];
        }

        // TODO generate hasMany relations and inverse relations

        return $models;
    }

    protected function generateApiModels()
    {
        $models = [];
        foreach ($this->getOpenApi()->components->schemas as $schemaName => $schema) {
            if ($schema instanceof Reference) {
                $schema = $schema->resolve();
            }
            $attributes = [];
            $relations = [];
            if ((empty($schema->type) || $schema->type === 'object') && empty($schema->properties)) {
                continue;
            }
            if (!empty($schema->type) && $schema->type !== 'object') {
                continue;
            }
            if (in_array($schemaName, $this->excludeModels)) {
                continue;
            }

            foreach ($schema->properties as $name => $property) {
                if ($property instanceof Reference) {
                    $ref = $property->getJsonReference()->getJsonPointer()->getPointer();
                    $resolvedProperty = $property->resolve();
                    $dbName = "{$name}_id";
                    $dbType = 'integer'; // for a foreign key
                    if (strpos($ref, '/components/schemas/') === 0) {
                        // relation
                        $type = substr($ref, 20);
                        $relations[$name] = [
                            'class' => $type,
                            'method' => 'hasOne',
                            'link' => ['id' => $dbName], // TODO pk may not be 'id'
                        ];
                    } else {
                        $type = $this->getSchemaType($resolvedProperty);
                    }
                } else {
                    $resolvedProperty = $property;
                    $type = $this->getSchemaType($property);
                    $dbName = $name;
                    $dbType = $this->getDbType($name, $property);
                }
                // relation
                if (is_array($type)) {
                    $relations[$name] = [
                        'class' => $type[1],
                        'method' => 'hasMany',
                        'link' => [Inflector::camel2id($schemaName, '_') . '_id' => 'id'], // TODO pk may not be 'id'
                    ];
                    $type = $type[0];
                }

                $attributes[$name] = [
                    'name' => $name,
                    'type' => $type,
                    'dbType' => $dbType,
                    'dbName' => $dbName,
                    'required' => false,
                    'readOnly' => $resolvedProperty->readOnly ?? false,
                    'description' => $resolvedProperty->description,
                    'faker' => $this->guessModelFaker($name, $type, $resolvedProperty),
                ];
            }
            if (!empty($schema->required)) {
                foreach ($schema->required as $property) {
                    if (!isset($attributes[$property])) {
                        continue;
                    }
                    $attributes[$property]['required'] = true;
                }
            }

            $models[$schemaName.'Api'] = [
                'name' => $schemaName,
                'tableName' => '{{%' . Inflector::camel2id(StringHelper::basename(Inflector::pluralize($schemaName)), '_') . '}}',
                'description' => $schema->description,
                'attributes' => $attributes,
                'relations' => $relations,
            ];
        }

        // TODO generate hasMany relations and inverse relations

        return $models;
    }

    /**
     * Undocumented function
     *
     * @param string $referencedSchema
     * @param string|null $prefix
     * @param array|null $flattenedAttributes
     * @return array
     */
    private function flattenOneToOneRelation($referencedSchema, $prefix = '', $flattenedAttributes = [])
    {
        $prefix .= ($prefix == '') ? '' : '__';
        foreach ($this->getOpenApi()->components->schemas[$referencedSchema]->properties as $name => $property) {
            if ($property instanceof Reference) {
                $ref = $property->getJsonReference()->getJsonPointer()->getPointer();
                $property = $property->resolve();
            }
            $type = $this->getSchemaType($property);//'int', 'bool', 'float', array, string
            $dbType = $this->getDbType($name, $property);
            if ( is_array($type) ){
                //TODO handle this as JSON
                $dbType = 'json';
                $type = 'array';//$type[0];
            } elseif ( !in_array($type, ['int', 'bool', 'float', 'string']) ) { // type == 'object'
                $flattenedAttributes = $this->flattenOneToOneRelation(substr($ref, 20), $prefix.strtolower($referencedSchema), $flattenedAttributes);//only when its a second level object or below
                continue;
            }
            $flattenedName = $prefix.strtolower($referencedSchema).'__'.$name;
            $flattenedAttributes[$flattenedName] = [
                'name' => $flattenedName,
                'type' => $type,
                'dbType' => $dbType,
                'dbName' => $flattenedName,
                'required' => false,
                'readOnly' => $property->readOnly ?? false,
                'description' => $property->description,
                'faker' => $this->guessModelFaker($name, $type, $property),
                'flattened' => true,
            ];
        }

        return $flattenedAttributes;
    }

    private function getPathFromNamespace($namespace)
    {
        return Yii::getAlias('@' . str_replace('\\', '/', $namespace));
    }

    /**
     * Guess faker for attribute.
     * @param string $name
     * @param string $type
     * @return string|null the faker PHP code or null.
     * @link https://github.com/fzaninotto/Faker#formatters
     */
    private function guessModelFaker($name, $type, Schema $property)
    {
        if (isset($property->{'x-faker'})) {
            return $property->{'x-faker'};
        }

        $min = $max = null;
        if (isset($property->minimum)) {
            $min = $property->minimum;
        } elseif (isset($property->exclusiveMinimum)) {
            $min = $property->exclusiveMinimum + 1;
        }
        if (isset($property->maximum)) {
            $max = $property->maximum;
        } elseif (isset($property->exclusiveMaximum)) {
            $max = $property->exclusiveMaximum - 1;
        }

        switch ($type) {
            case 'string':
                if ($property->format === 'date') {
                    return '$faker->iso8601';
                }
                if (!empty($property->enum) && is_array($property->enum)) {
                    return '$faker->randomElement('.var_export($property->enum, true).')';
                }
                if ($name === 'title' && isset($property->maxLength) && $property->maxLength < 10) {
                    return '$faker->title';
                }

                $patterns = [
                    '~_id$~' => '$uniqueFaker->numberBetween(0, 1000000)',
                    '~uuid$~' => '$uniqueFaker->uuid',
                    '~firstname~i' => '$faker->firstName',
                    '~(last|sur)name~i' => '$faker->lastName',
                    '~(username|login)~i' => '$faker->userName',
                    '~(company|employer)~i' => '$faker->company',
                    '~(city|town)~i' => '$faker->city',
                    '~(post|zip)code~i' => '$faker->postcode',
                    '~streetaddress~i' => '$faker->streetAddress',
                    '~address~i' => '$faker->address',
                    '~street~i' => '$faker->streetName',
                    '~state~i' => '$faker->state',
                    '~county~i' => 'sprintf("%s County", $faker->city)',
                    '~country~i' => '$faker->countryCode',
                    '~lang~i' => '$faker->languageCode',
                    '~locale~i' => '$faker->locale',
                    '~currency~i' => '$faker->currencyCode',
                    '~hash~i' => '$faker->sha256',
                    '~e?mail~i' => '$faker->safeEmail',
                    '~timestamp~i' => '$faker->unixTime',
                    '~.*ed_at$~i' => '$faker->dateTimeThisCentury(\'Y-m-d H:i:s\')', // created_at, updated_at, ...
                    '~(phone|fax|mobile|telnumber)~i' => '$faker->e164PhoneNumber',
                    '~(^lat|coord)~i' => '$faker->latitude',
                    '~^lon~i' => '$faker->longitude',
                    '~title~i' => '$faker->sentence',
                    '~(body|summary|article|content|descr|comment|detail)~i' => '$faker->paragraphs(6, true)',
                    '~(url|site|website)~i' => '$faker->url',
                ];
                foreach ($patterns as $pattern => $faker) {
                    if (preg_match($pattern, $name)) {
                        if (isset($property->maxLength)) {
                            return 'substr(' . $faker . ', 0, ' . $property->maxLength . ')';
                        } else {
                            return $faker;
                        }
                    }
                }

                // TODO maybe also consider OpenAPI examples here

                if (isset($property->maxLength)) {
                    return 'substr($faker->text(' . $property->maxLength . '), 0, ' . $property->maxLength . ')';
                }
                return '$faker->sentence';
            case 'int':
                $fakerVariable = preg_match('~_?id$~', $name) ? 'uniqueFaker' : 'faker';

                if ($min !== null && $max !== null) {
                    return "\${$fakerVariable}->numberBetween($min, $max)";
                } elseif ($min !== null) {
                    return "\${$fakerVariable}->numberBetween($min, PHP_INT_MAX)";
                } elseif ($max !== null) {
                    return "\${$fakerVariable}->numberBetween(0, $max)";
                }

                $patterns = [
                    '~timestamp~i' => '$faker->unixTime',
                    '~.*ed_at$~i' => '$faker->unixTime', // created_at, updated_at, ...
                ];
                foreach ($patterns as $pattern => $faker) {
                    if (preg_match($pattern, $name)) {
                        return $faker;
                    }
                }

                return "\${$fakerVariable}->numberBetween(0, PHP_INT_MAX)";
            case 'bool':
                return '$faker->boolean';
            case 'float':
                if ($min !== null && $max !== null) {
                    return "\$faker->randomFloat(null, $min, $max)";
                } elseif ($min !== null) {
                    return "\$faker->randomFloat(null, $min)";
                } elseif ($max !== null) {
                    return "\$faker->randomFloat(null, 0, $max)";
                }
                return '$faker->randomFloat()';
        }


        return null;
    }
}