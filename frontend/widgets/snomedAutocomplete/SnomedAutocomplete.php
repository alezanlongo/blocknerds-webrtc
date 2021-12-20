<?php

namespace frontend\widgets\snomedAutocomplete;

use yii\base\Widget;
use yii\helpers\Html;


class SnomedAutocomplete extends Widget
{

    public $name;
    public $model;
    public $form;

    public function init() {

    }

    public function run(): string {
        return $this->render('_autocomplete', [
        		'model' => $this->model,
        		'name' => $this->name,
        		'form'=> $this->form
        	]
    	);
    }

}
