<?php

use yzh52521\validate\Validate;

if (!function_exists('validate')) {
    /**
     * 生成验证对象
     * @param array $data 数据
     * @param string|array $validate 验证器类名或者验证规则数组
     * @param array $message 错误提示信息
     * @param bool $batch 是否批量验证
     * @param bool $failException 是否抛出异常
     * @return Validate
     */
    function validate(array $data, $validate = '', array $message = [], bool $batch = false, bool $failException = true): Validate
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $validate;
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);
        $v->batch($batch);
        return $v->failException($failException)->check($data);
    }
}