<?php

namespace common\components\athena\helpers;
use Faker\Provider\Base;
use yii\helpers\BaseHtml;
use common\components\Athena\models\VitalsReference;

class VitalsHelper extends BaseHtml
{

    public static function render(VitalsReference $vitalReference, $vitaltsByClinicalId = [])
    {
        $vital = [];
        if(!empty($vitaltsByClinicalId) && isset($vitaltsByClinicalId[$vitalReference->clinicalelementid])){
            $vital = $vitaltsByClinicalId[$vitalReference->clinicalelementid];
        }
        switch ($vitalReference->datatype) {
            case 'NUMERIC':
                return self::renderInput($vitalReference->name, $vitalReference->clinicalelementid, $vitalReference->group, $vital);
            case 'SET':
                return self::renderDropdown($vitalReference->name, $vitalReference->clinicalelementid, $vitalReference->group, $vitalReference->dataset, $vital);
            case 'CHECKBOX':
                return self::renderCheckbox($vitalReference->name, $vitalReference->abbreviation, $vitalReference->clinicalelementid, $vitalReference->group, $vital);
            case 'FREETEXT':
                return self::renderTextarea($vitalReference->name, $vitalReference->clinicalelementid, $vitalReference->group, $vital);
            case 'LARGETEXTAREA':
                return self::renderTextarea($vitalReference->name, $vitalReference->clinicalelementid, $vitalReference->group, $vital);
            default:
                return self::renderInput($vitalReference->name, $vitalReference->clinicalelementid, $vitalReference->group, $vital);
        }
    }

    private static function renderInput($name, $clinicalElementid, $group, $vital){

        return "<div class=\"form-group\"><label class=\"control-label\" for=\"".$name."\">$name</label>".BaseHtml::textInput((!empty($vital)) ? 'Vitals['.$vital->vitalid.']' : 'Vitals['.$clinicalElementid.']',(!empty($vital)) ? $vital->value : '', ['class'=> 'form-control']).BaseHtml::hiddenInput('VitalsGroup[_'.$clinicalElementid.']',$group)."</div>";

    }

    private static function renderDropdown($name, $clinicalElementid, $group, $dataset, $vital){
        return "<div class=\"form-group\"><label class=\"control-label\" for=\"".$name."\">$name</label>".BaseHtml::dropDownList((!empty($vital)) ? 'Vitals['.$vital->vitalid.']' : 'Vitals['.$clinicalElementid.']', (!empty($vital)) ? $vital->value  : '', json_decode($dataset, false), ['prompt'=>'Select '.$name, 'class'=> 'form-control']).BaseHtml::hiddenInput('VitalsGroup[_'.$clinicalElementid.']',$group)."</div>";
    }

    private static function renderCheckbox($name, $abbreviation, $clinicalElementid, $group, $vital){
        return "<div class=\"form-group\"><label class=\"control-label\" for=\"".$name."\">$name</label>".BaseHtml::radioList((!empty($vital)) ? 'Vitals['.$vital->vitalid.']' : 'Vitals['.$clinicalElementid.']', (!empty($vital->value) && $vital->value != 0) ? 1  : '', ['0' => 'No', '1' => 'Yes']).BaseHtml::hiddenInput('VitalsGroup[_'.$clinicalElementid.']',$group)."</div>";
    }

    private static function renderTextarea($name, $clinicalElementid, $group, $vital){
        return "<div class=\"form-group\"><label class=\"control-label\" for=\"".$name."\">$name</label>".BaseHtml::textarea((!empty($vital)) ? 'Vitals['.$vital->vitalid.']' : 'Vitals['.$clinicalElementid.']', (!empty($vital)) ? $vital->value  : '', ['class'=> 'form-control']).BaseHtml::hiddenInput('VitalsGroup[_'.$clinicalElementid.']',$group)."</div>";

    }
}