<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\components\Athena\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agriculturalworker')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agriculturalworkertype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'caresummarydeliverypreference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimbalancedetails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confidentialitycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consenttocall')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consenttotext')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacthomephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactmobilephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_announcement_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_announcement_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_announcement_sms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_appointment_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_appointment_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_appointment_sms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_billing_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_billing_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_billing_sms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_lab_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_lab_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactpreference_lab_sms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactrelationship')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'countrycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'countrycode3166')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deceaseddate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'defaultpharmacyncpdpid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'departmentid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'donotcallyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driverslicenseexpirationdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driverslicensenumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driverslicensestateid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driverslicenseurl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driverslicenseyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emailexistsyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employeraddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employercity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employerfax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employerid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employername')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employerphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employerstate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employerzip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ethnicitycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstappointment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantoraddress1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantoraddress2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantoraddresssameaspatient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorcity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorcountrycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorcountrycode3166')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantordob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantoremail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantoremployerid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorfirstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorlastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantormiddlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorrelationshiptopatient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorssn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorstate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorsuffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantorzip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guardianfirstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guardianlastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guardianmiddlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guardiansuffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hasmobileyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hierarchicalcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homeboundyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homeless')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homelesstype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'industrycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastappointment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maritalstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maritalstatusname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medicationhistoryconsentverified')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobilecarrierid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobilephone')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'occupationcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'onlinestatementonlyyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientphotourl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientphotoyn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'portalaccessgiven')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'portalsignatureonfile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'portalstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'portaltermsonfile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelcalculated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelfamilysize')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelfamilysizedeclined')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelincomedeclined')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelincomepayperiod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelincomeperpayperiod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'povertylevelincomerangedeclined')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preferredname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'primarydepartmentid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'primaryproviderid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'privacyinformationverified')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publichousing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'race')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'racename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registrationdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schoolbasedhealthcenter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ssn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'veteran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'externalId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <div class="form-group" style="padding-bottom: 80px;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
