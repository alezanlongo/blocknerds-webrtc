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
     * @inheritdoc
     */
    public $generateUrls = false;

    /**
     * @inheritdoc
     */
    public $generateControllers = false;

    /**
     * @inheritdoc
     */
    public $generateModelFaker = false;

    /**
     * @var bool whether to generate Api models from the spec.
     */
    public $generateApiModels = true;
    public $folderPath = 'common\\components';
    /**
     * @inheritDoc
     */
    public function generate() {
        $this->modelNamespace = $this->folderPath.'\\'.'models';
        $modelApiNamespace = $this->folderPath.'\\'.'apiModels';
        $this->migrationPath = $this->getPathFromNamespace($this->folderPath).'/'.'migrations';

        //$files = parent::generate();
        $files = [];

        if ($this->generateUrls) {
            $urls = [];
            $optionsUrls = [];
            foreach ($this->generateUrls() as $urlRule) {
                $urls["{$urlRule['method']} {$urlRule['pattern']}"] = $urlRule['route'];
                // add options action
                $parts = explode('/', $urlRule['route']);
                unset($parts[count($parts) - 1]);
                $optionsUrls[$urlRule['pattern']] = implode('/', $parts) . '/options';
            }
            $urls = array_merge($urls, $optionsUrls);
            $files[] = new CodeFile(
                Yii::getAlias($this->urlConfigFile),
                $this->render('urls.php', [
                    'urls' => $urls,
                ])
            );
        }

        if ($this->generateControllers) {
            $controllers = $this->generateControllers();
            $controllerNamespace = $this->controllerNamespace ?? Yii::$app->controllerNamespace;
            $controllerPath = $this->getPathFromNamespace($controllerNamespace);
            foreach ($controllers as $controller => $actions) {
                $className = \yii\helpers\Inflector::id2camel($controller) . 'Controller';
                $files[] = new CodeFile(
                    Yii::getAlias($controllerPath . "/$className.php"),
                    $this->render('controller.php', [
                        'className' => $className,
                        'namespace' => $controllerNamespace,
                        'actions' => $actions,
                    ])
                );
            }
        }

        if ($this->generateModels) {
            $models = $this->generateModels();
            $modelPath = $this->getPathFromNamespace($this->modelNamespace);
            foreach ($models as $modelName => $model) {
                $className = $modelName;
                $files[] = new CodeFile(
                    Yii::getAlias("$modelPath/$className.php"),
                    $this->render('model.php', [
                        'className' => $className,
                        'tableName' => $model['tableName'],
                        'namespace' => $this->modelNamespace,
                        'description' => $model['description'],
                        'attributes' => $model['attributes'],
                        'relations' => $model['relations'],
                        'extIdField' => $model['extIdField'],
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

        if ($this->generateMigrations) {
            if (!isset($models)) {
                $models = $this->generateModels();
            }
            $migrationPath = Yii::getAlias($this->migrationPath);
            $migrationNamespace = $this->migrationNamespace;
            foreach ($models as $modelName => $model) {
                // migration files get invalidated directly after generating
                // if they contain a timestamp
                // use fixed time here instead
                if ($migrationNamespace) {
                    $m = date('ymd000000');
                    $className = "M{$m}$modelName";
                } else {
                    $m = date('ymd_000000');
                    $className = "m{$m}_$modelName";
                }
                $tableName = $model['tableName'];


                $files[] = new CodeFile(
                    Yii::getAlias("$migrationPath/$className.php"),
                    $this->render('migration.php', [
                        'className' => $className,
                        'namespace' => $migrationNamespace,
                        'tableName' => $tableName,
                        'attributes' => $model['attributes'],
                        'relations' => $model['relations'],
                        'description' => 'Table for ' . $modelName,
                    ])
                );
            }
        }

        if ($this->generateApiModels) {
            $models = $this->generateApiModels();
            $modelPath = $this->getPathFromNamespace($this->folderPath);
            foreach ($models as $modelName => $model) {
                $className = $modelName;
                $files[] = new CodeFile(
                    Yii::getAlias("$modelPath/apiModels/$className.php"),
                    $this->render('apiModel.php', [
                        'className' => $className,
                        'namespace' => $modelApiNamespace,
                        'description' => $model['description'],
                        'attributes' => $model['attributes'],
                        'relations' => $model['relations'],
                    ])
                );
                // echo "$modelPath/$className.php";
                if (!$this->generateModelFaker) {
                    continue;
                }
                $files[] = new CodeFile(
                    Yii::getAlias("$modelPath/models/{$className}Faker.php"),
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

        $clientEndPoints = $this->generateClients();
        $modelPath = $this->getPathFromNamespace($this->folderPath);
        $component = explode('\\', $this->folderPath);
        $component = $component[count($component) - 1];
        $files[] = new CodeFile(
            Yii::getAlias("$modelPath/{$component}Client.php"), // fix me, ask Ricardo
            $this->render('client.php', [
                'component'         => $component,
                'className'         => $component.'Client', // fix me, ask Ricardo
                'namespace'         => $this->folderPath,
                'clientEndPoints'   => $clientEndPoints,
            ])
        );

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['folderPath', 'required'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function generateModels()
    {
        $models = [];
        $externalId = 'externalId';
        foreach ($this->getOpenApi()->components->schemas as $schemaName => $schema) {
            if ($schema instanceof Reference) {
                $schema = $schema->resolve();
            }
            $extIdField = false;
            if( array_key_exists('x-external-id', $schema->getExtensions()) ) {
                $extIdField = $schema->getExtensions()['x-external-id'];
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

            $hasId = false;
            foreach ($schema->properties as $name => $property) {
                $unique = false;
                if ($property instanceof Reference) {
                    $ref = $property->getJsonReference()->getJsonPointer()->getPointer();
                    $resolvedProperty = $property->resolve();
                    $dbName = "{$name}_id";
                    $dbType = '$this->integer()'; // for a foreign key
                    if (strpos($ref, '/components/schemas/') === 0) {
                        // relation
                        $type = substr($ref, 20);

                        //START FLATTENING
                        if( array_key_exists('x-flatten', $schema->getExtensions()) ) {
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
                    if( !$hasId and $name === 'id') {
                        $hasId = true;
                    }
                    $unique = array_key_exists('x-unique', $property->getExtensions());
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
                    'unique' => $unique,
                ];
            }
            if( $hasId ) { //ENQUIRY what happens if the schema has an id and ext_id is set to a different field?
                $attributes['id']['name'] = $externalId;
                $attributes['id']['dbType'] = '$this->integer()';//IMPROVEME could be string
                $attributes['id']['dbName'] = $externalId;
                $attributes[$externalId] = $attributes['id'];
                unset($attributes['id']);
            } else {
                $attributes[$externalId] = [
                    'name' => $externalId,
                    'type' => 'integer',
                    'dbType' => '$this->string()',
                    'dbName' => $externalId,
                    'required' => false,
                    'readOnly' => false,
                    'description' => 'API Primary Key',
                    //'faker' => $this->guessModelFaker($name, $type, $resolvedProperty),
                    'unique' => false,
                ];
            }
            $attributes['id'] = [
                'name' => 'id',
                'type' => 'integer',
                'dbType' => '$this->primaryKey()',
                'dbName' => 'id',
                'required' => false,
                'readOnly' => false,
                'description' => 'Primary Key',
                //'faker' => $this->guessModelFaker($name, $type, $resolvedProperty),
                'unique' => false,
            ];
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
                'extIdField' => $extIdField,
            ];
        }

        // TODO generate hasMany relations and inverse relations

        return $models;
    }


    protected function generateClients()
    {
        $arrayClient = [];
        foreach ($this->getOpenApi()->paths as $pathName => $path) {
            $arrPathName = explode("/", $pathName);
            $finalPathName = $arrPathName[(count($arrPathName) - 1)];

            foreach ($path->getOperations() as $verb => $operation){
                $arrPath = [];
                foreach ($operation->parameters as $parameter){
                    if($parameter->in == 'path'){
                        array_push($arrPath, $parameter->name);
                    }
                }

                foreach ($operation->responses->getResponses() as $responseCode => $response){
                    foreach ($response->content as $responseType => $responseItem){
                        $flagList = NULL;
                        if(get_class($responseItem->schema) == Reference::class){
                            $flagList = FALSE;
                            $arrSchema = explode("/", $responseItem->schema->getReference());
                        }else if(get_class($responseItem->schema) == Schema::class){
                            $flagList = TRUE;
                            $arrSchema = explode("/", $responseItem->schema->items->getReference());
                        }

                        

                        array_push($arrayClient, [
                            'pathname'      => $pathName,
                            'finalPathName' => $finalPathName,
                            'verb'          => $verb,
                            'parameters'    => $arrPath,
                            'operationId'   => $operation->operationId,
                            'schema'        => $arrSchema[(count($arrSchema) - 1)],
                            'flagList'      => $flagList
                        ]);//var_dump($arrayClient); exit();
                    }
                }
            }
        }

        return $arrayClient;
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

    /**
     * @inheritdoc
     */
    private function getPathFromNamespace($namespace)
    {
        return Yii::getAlias('@' . str_replace('\\', '/', $namespace));
    }

    /**
     * @inheritdoc
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

    /**
     * @inheritdoc
     */
    public function autoCompleteData()
    {
        $vendor = Yii::getAlias('@vendor');
        $app = Yii::getAlias('@common');
        $runtime = Yii::getAlias('@runtime');
        $paths = [];
        $pathIterator = new \RecursiveDirectoryIterator($app);
        $recursiveIterator = new \RecursiveIteratorIterator($pathIterator);
        $files = new \RegexIterator($recursiveIterator, '~.+\.(json|yaml|yml)$~i', \RegexIterator::GET_MATCH);
        foreach ($files as $file) {
            if (strpos($file[0], $vendor) === 0) {
                $file = '@vendor' . substr($file[0], strlen($vendor));
                if (DIRECTORY_SEPARATOR === '\\') {
                    $file = str_replace('\\', '/', $file);
                }
            } elseif (strpos($file[0], $runtime) === 0) {
                $file = null;
            } elseif (strpos($file[0], $app) === 0) {
                $file = '@common' . substr($file[0], strlen($app));
                if (DIRECTORY_SEPARATOR === '\\') {
                    $file = str_replace('\\', '/', $file);
                }
            } else {
                $file = $file[0];
            }

            if ($file !== null) {
                $paths[] = $file;
            }
        }

        $namespaces = array_map(function ($alias) {
            $path = Yii::getAlias($alias, false);
            if (in_array($alias, ['@web', '@runtime', '@vendor', '@bower', '@npm'])) {
                return [];
            }
            if (!file_exists($path)) {
                return [];
            }
            try {
                return array_map(function ($dir) use ($path, $alias) {
                    return str_replace('/', '\\', substr($alias, 1) . substr($dir, strlen($path)));
                }, FileHelper::findDirectories($path, ['except' => [
                    'vendor/',
                    'runtime/',
                    'assets/',
                    '.git/',
                    '.svn/',
                ]]));
            } catch (\Throwable $e) {
                // ignore errors with file permissions
                Yii::error($e);
                return [];
            }
        }, array_keys(Yii::$aliases));
        $namespaces = array_merge(...$namespaces);

        return [
            'openApiPath' => $paths,
            'controllerNamespace' => $namespaces,
            'modelNamespace' => $namespaces,
            'migrationNamespace' => $namespaces,
//            'urlConfigFile' => [
//                '@app/config/urls.rest.php',
//            ],
        ];
    }

    /**
     * @param string $name
     * @param Schema $schema
     * @return string
     */
    protected function getDbType($name, $schema)
    {
        if ($name === 'id') {
            return '$this->primaryKey()';
        }

        switch ($schema->type) {
            case 'string':
                if (isset($schema->maxLength)) {
                    return '$this->string(' . ((int) $schema->maxLength) . ')';
                }
                return '$this->string()';
            case 'integer':
                return '$this->integer()';
            case 'boolean':
                return '$this->boolean()';
            case 'number': // can be double and float
                return '$this->float()';//$schema->format ?? 'float';
//            case 'array':
        // TODO array might refer to has_many relation
//                if (isset($schema->items) && $schema->items instanceof Reference) {
//                    $ref = $schema->items->getJsonReference()->getJsonPointer()->getPointer();
//                    if (strpos($ref, '/components/schemas/') === 0) {
//                        return substr($ref, 20) . '[]';
//                    }
//                }
//                // no break here
            default:
                return '$this->string()';
        }
    }
}