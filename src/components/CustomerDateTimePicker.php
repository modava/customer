<?php

namespace modava\customer\components;

use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\Html;

class CustomerDateTimePicker extends DateTimePicker
{
    public $pickIconContent = '';
    public function run()
    {

        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);

        if (!$this->inline) {
            $resetIcon = Html::tag('span', '', ['class' => $this->resetButtonIcon]);
            $pickIcon = Html::tag('button', $this->pickIconContent, ['class' => $this->pickButtonIcon]);
            $resetAddon = Html::tag('span', $resetIcon, ['class' => 'input-group-addon']);
            $pickerAddon = Html::tag('span', $pickIcon, ['class' => 'input-group-addon']);
        } else {
            $resetAddon = $pickerAddon = '';
        }

        if (strpos($this->template, '{button}') !== false || $this->inline) {
            $input = Html::tag(
                'div',
                strtr($this->template, ['{input}' => $input, '{reset}' => $resetAddon, '{button}' => $pickerAddon]),
                $this->containerOptions
            );
        }
        echo $input;
        $this->registerClientScript();
    }
}