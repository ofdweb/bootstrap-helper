<?php

namespace razmik\helper;

class Form
{
    public static $inputOptions = ['class' => 'form-control'];
    public static $options = ['class' => 'form-group'];
    public static $labelOptions = ['class' => 'control-label'];
        
    public static function textInput($name, $value = null, $options = [])
    {
        $options = array_merge(static::$inputOptions, $options);
        $input = Html::textInput($name, $value, $options);
        return static::render($input, $options);
    }
    
    public static function hiddenInput($name, $value = null, $options = [])
    {
        return Html::hiddenInput($name, $value, $options);
    }
    
    public static function textArea($name, $value = null, $options = [])
    {
        $options = array_merge(static::$inputOptions, $options);
        $input = Html::textArea($name, $value, $options);
        return static::render($input, $options);
    }
    
    public static function submitButton($content = 'Submit', $options = [])
    {
        return Html::submitButton($content, $options); 
    }
    
    protected static function render($input = null, $options = [])
    {
        $parts[] = Html::beginTag('div', static::$options);
        if ($options['label']) {
            $parts[] = Html::label($options['label'], null, static::$labelOptions);
        }
        $parts[] = $input;
        $parts[] = Html::endTag('div');

        return implode("\n", $parts);
    }
    
    public static function beginForm($action = '', $method = 'post', $options = [])
    {
        if (!$action) {
            $action = $_SERVER["REQUEST_URI"];
        }
        
        $action = Url::to($action);

        $options['action'] = $action;
        $options['method'] = $method;

        return Html::beginTag('form', $options);
    }
    
    public static function endForm()
    {
        return '</form>';
    }
}