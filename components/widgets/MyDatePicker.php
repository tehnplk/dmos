<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\View;
use app\components\MyLookUp;

class MyDatePicker extends Widget {

    public $model;           // Model for the input
    public $attribute;       // Single date attribute name
    public $label;           // Label for the input field
    public $dayPlaceholder = 'DD';
    public $monthPlaceholder = 'MM';
    public $yearPlaceholder = 'YYYY';

    public function run() {

        $labelHtml = $this->model->getAttributeLabel($this->attribute) ? Html::tag('label', $this->model->getAttributeLabel($this->attribute), ['for' => "{$this->attribute}_container"]) : '';

        $date = $this->model->{$this->attribute};
        $day = $month = $year = '';

        if ($date) {
            list($year, $month, $day) = explode('-', date('Y-m-d', strtotime($date)));
        }
        //$year = (int)$year+543;

        $inputDay = Html::dropDownList("{$this->attribute}_day", $day, MyLookUp::bdate(), [
                    'prompt' => '',
                    'id' => "{$this->attribute}_day",
                    'class' => 'form-control',
                    'placeholder' => $this->dayPlaceholder,
                    'maxlength' => 2,
                    //'style' => 'width: 20%; display: inline-block; margin-right: 5px;',
                    'style' => 'width: 70px',
                    'data-attr' => 'day'
        ]);

        $inputMonth = Html::dropDownList("{$this->attribute}_month", $month, MyLookUp::bmon(), [
                    'prompt' => '',
                    'id' => "{$this->attribute}_month",
                    'class' => 'form-control',
                    'placeholder' => $this->monthPlaceholder,
                    'maxlength' => 2,
                    //'style' => 'width: 30%; display: inline-block;margin-right: 5px;',
                    'style' => 'width: 130px',
                    'data-attr' => 'month'
        ]);

        $inputYear = Html::dropDownList("{$this->attribute}_year", $year, MyLookUp::byear(), [
                    'prompt' => '',
                    'id' => "{$this->attribute}_year",
                    'class' => 'form-control',
                    'placeholder' => $this->yearPlaceholder,
                    'maxlength' => 4,
                    //'style' => 'width: 30%; display: inline-block;',
                    'style' => 'width: 100px',
                    'data-attr' => 'year'
        ]);

        $inputHidden = Html::activeHiddenInput($this->model, $this->attribute, [
                    'id' => "{$this->attribute}_hidden"
        ]);

        $btnClear = Html::button('x', [
                    'class' => 'form-control',
                    'style' => 'width: 40px;color:#505250',
                    'id' => "{$this->attribute}_btn_clear"
        ]);

        $htmlOutput = Html::tag('div', $labelHtml . Html::tag('div', $inputDay . $inputMonth . $inputYear . $btnClear, [
                            'style' => 'display: flex;  gap: 3px;'
                        ]) . $inputHidden, [
                    //'class' => 'dmy-input-widget',
                    'id' => "{$this->attribute}_container",
                    'style' => 'padding-bottom:10px;padding-right:15px'
        ]);

        $js = <<<JS
            function {$this->attribute}_update() {
                var container = $('#{$this->attribute}_container');
                var day = container.find('[data-attr="day"]').val().padStart(2, '0');
                if(day=='00'){day='01';container.find('[data-attr="day"]').val('01');}
                var month = container.find('[data-attr="month"]').val();
                if(month==''){month='01';container.find('[data-attr="month"]').val('01')}
                var year = container.find('[data-attr="year"]').val();
                var y = (new Date).getFullYear();
                if(year==''){year=y;container.find('[data-attr="year"]').val(y)}
           
                //year = year-543;              
                var fullDate = year + '-' + month + '-' + day;
                console.log('{$this->attribute}' + fullDate)
                $('#{$this->attribute}_hidden').val(fullDate);
                $('#patienthos-{$this->attribute}').val(fullDate);
                
            }
            
            $('#{$this->attribute}_container input').on('input', {$this->attribute}_update);
            $('#{$this->attribute}_container select').on('change', {$this->attribute}_update);
            
            $('#{$this->attribute}_btn_clear').click(function(e){
                $('#{$this->attribute}_hidden').val('');
                $('#patienthos-{$this->attribute}').val('');
                $('#{$this->attribute}_day').val('');
                $('#{$this->attribute}_month').val('');
                $('#{$this->attribute}_year').val('');
            });
JS;

        $this->view->registerJs($js, View::POS_READY);

        return $htmlOutput;
    }

}
