<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Validator;

class Validator {
    
    /**
     * 已注册的验证器
     * 
     * @var array
     */
    private static $validators = array(
        'email'     => 'self::validateEmail',
        'required'  => 'self::validateRequired',
        'minLength' => 'self::validateMinLength',
        'maxLength' => 'self::validateMaxLength',
        'min'       => 'self::validateMin',
        'max'       => 'self::validateMax',
        'number'    => 'self::validateNumber',
        'int'       => 'self::validateInt',
        'mobile'    => 'self::validateMobile',
        'phone'     => 'self::validatePhone',
        'time'      => 'self::validateTime',
        'url'       => 'self::validateUrl',
        'array'     => 'self::validateArray',
        'inArray'   => 'self::validateInArray',
    );
    
    /**
     * 验证结果
     * 
     * @var array
     */
    private $results = array();
    
    /**
     * 验证错误
     * 
     * @var array
     */
    private $errors = array();
    
    /**
     * 最后一次错误
     * 
     * @var array
     */
    private $lastError = array();
    
    /**
     * 设置
     * 
     * @var array
     */
    private static $options = array(
        'breakOnError' => true
    );
    
    public function __construct() {
        \System\Bootstrap::invokeHook('onValidatorInit', $this);
    }
    
    /**
     * 设置选项
     * 
     * @param array $options 选项
     */
    public function setOptions(array $options) {
        self::$options = array_merge(self::$options, $options);
    }
    
    /**
     * 验证数据
     * 
     * @param array $data 数据和规则
     */
    public function validate(array $data) {
        foreach ($data as $key => $field) {
            $result = array();
            foreach ($field['rules'] as $validator => $params) {
                if (is_callable($params)) {
                    $result = call_user_func_array($params, array($field));
                } else {
                    $v = self::$validators[$validator];
                    if (! isset($v)) continue;
                    $args = array($field, is_array($params) ? $params : array($params));
                    $result = call_user_func_array($v, $args);
                }
                $this->results[$key][$validator] = $result;
                if (! $result['match']) {
                    $this->errors[$key][$validator] = $result;
                    $this->lastError = $result;
                    if (self::$options['breakOnError']) {
                        return $this->lastError;
                    }
                }
            }
        }
        return $this->results;
    }
    
    /**
     * 注册验证器
     * 
     * @param string $name 验证器名
     * @param callback $callback 验证函数
     */
    public static function registerValidator($name, $callback) {
        self::$validators[$name] = $callback;
    }
    
    /**
     * 获取验证结果
     * 
     * @return array 所有验证结果
     */
    public function getResults() {
        return $this->results;
    }
    
    /**
     * 获取错误结果
     * 
     * @return array 所有错误结果
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * 获取最后一个错误
     * 
     * @return array 最后一个错误
     */
    public function getLastError() {
        return $this->lastError;
    }
    
    /**
     * 验证是否为空
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateRequired(array $field, array $params = array()) {
        $params = array_merge(array(
            'strict'  => false,
            'trim'    => true,
            'message' => '"{fieldName}"不能为空'
        ), $params);
        $field['value'] = $params['trim'] ? trim($field['value']) : $field['value'];
        $match = $params['strict'] ? $field['value'] !== '' : !empty($field['value']);
        $message = str_replace('{fieldName}', $field['name'], $params['message']);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否是email
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateEmail($field, array $params = array()) {
        $params = array_merge(array(
            'message' => '邮箱格式不正确'
        ), $params);
        $match = (bool) filter_var($field['value'], FILTER_VALIDATE_EMAIL);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $params['message'];

        return $params;
    }
    
    /**
     * 验证是否小于最小长度
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateMinLength($field, array $params = array()) {
        $params = array_merge(array(
            'value'     => 3,
            'fullWidth' => true,
            'message'   => '{fieldName}不能少于{value}个字符'
        ), $params);
        $len = $params['fullWidth']
            ? mb_strlen($field['value'], 'UTF-8')
            : strlen($field['value']);
        $match = $len >= $params['value'];
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $message = str_replace('{value}', $params['value'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否大于最小长度
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateMaxLength($field, array $params = array()) {
        $params = array_merge(array(
            'value' => 30,
            'fullWidth' => true,
            'message' => '{fieldName}长度不能大于{value}'
        ), $params);
        $len = $params['fullWidth']
            ? mb_strlen($field['value'], 'UTF-8')
            : strlen($field['value']);
        $match = $len <= $params['value'];
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $message = str_replace('{value}', $params['value'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }

    /**
     * 验证是否小于指定值
     * @param $field
     * @param array $params
     * @return array
     */
    public function validateMin($field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}取值应不小于{value}'
        ), $params);
        $match = $field['value'] >= $params['value'];
        $params['message'] = str_replace('{fieldName}', $field['name'], $params['message']);
        $params['message'] = str_replace('{value}', $params['value'], $params['message']);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $params['message'];

        return $params;
    }

    /**
     * 验证是否大于指定值
     * @param $field
     * @param array $params
     * @return array
     */
    public function validateMax($field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}取值应不大于{value}'
        ), $params);
        $match = $field['value'] <= $params['value'];
        $params['message'] = str_replace('{fieldName}', $field['name'], $params['message']);
        $params['message'] = str_replace('{value}', $params['value'], $params['message']);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $params['message'];

        return $params;
    }
    
    /**
     * 验证是否为整数
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateInt(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}必须为整数'
        ), $params);
        $match = preg_match('#\d+#', $field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为数字
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateNumber(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}必须为数字'
        ), $params);
        $match = is_numeric($field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为手机号
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateMobile(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}格式不正确'
        ), $params);
        $match = preg_match('#^1\d{10}$#', $field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为电话号
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validatePhone(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}格式不正确'
        ), $params);
        $mobile = preg_match('#^1\d{10}$#', $field['value']);
        $tel = preg_match('#^\d{3,4}-?\d{7,9}$#', $field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $match = $mobile || $tel;
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为时间（日期）
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateTime(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}格式不正确'
        ), $params);
        $format = str_replace(
            array('d', 'm', 'H', 'i', 's'), '\d{2}', $params['format']
        );
        $format = str_replace(
            array('Y', 'G'), array('\d{4}', '\d{1,2}'), $format
        );
        $match = preg_match('#^' . $format . '$#', $field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为url
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateUrl(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}不是合法的URL'
        ), $params);
        $match = filter_var($field['value'], FILTER_VALIDATE_URL);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
    
    /**
     * 验证是否为array
     * 
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateArray(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}不是合法的数组'
        ), $params);
        $match = is_array($field['value']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }

    /**
     * 验证是否存在数组中
     *
     * @param array $field 字段信息
     * @param array $params 验证参数
     * @return array 验证结果
     */
    public function validateInArray(array $field, array $params = array()) {
        $params = array_merge(array(
            'message' => '{fieldName}不是合法的数据'
        ), $params);
        $match = in_array($field['value'], $params['array']);
        $message = $params['message'];
        $message = str_replace('{fieldName}', $field['name'], $message);
        $params['match'] = $match;
        $params['message'] = $match ? 'ok' : $message;

        return $params;
    }
}
