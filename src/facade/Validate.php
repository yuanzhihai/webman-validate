<?php
declare (strict_types=1);

namespace yzh52521\validate\facade;

use think\facade\Db;

/**
 * @see \yzh52521\validate\Validate
 * @package think\facade
 * @mixin \yzh52521\validate\Validate
 * @method static void setDb(Db $db) 设置Db对象
 * @method static void setRequest(\support\Request $request) 设置Request对象
 * @method static \yzh52521\validate\Validate rule(string|array $name, mixed $rule = '') 添加字段验证规则
 * @method static \yzh52521\validate\Validate extend(string $type, callable $callback = null, string $message = null) 注册验证（类型）规则
 * @method static void setTypeMsg(string|array $type, string $msg = null) 设置验证规则的默认提示信息
 * @method static Validate message(array $message) 设置提示信息
 * @method static \yzh52521\validate\Validate scene(string $name) 设置验证场景
 * @method static bool hasScene(string $name) 判断是否存在某个验证场景
 * @method static \yzh52521\validate\Validate batch(bool $batch = true) 设置批量验证
 * @method static \yzh52521\validate\Validate failException(bool $fail = true) 设置验证失败后是否抛出异常
 * @method static \yzh52521\validate\Validate only(array $fields) 指定需要验证的字段列表
 * @method static \yzh52521\validate\Validate remove(string|array $field, mixed $rule = null) 移除某个字段的验证规则
 * @method static \yzh52521\validate\Validate append(string|array $field, mixed $rule = null) 追加某个字段的验证规则
 * @method static bool check(array $data, array $rules = []) 数据自动验证
 * @method static bool checkRule(mixed $value, mixed $rules) 根据验证规则验证数据
 * @method static bool confirm(mixed $value, mixed $rule, array $data = [], string $field = '') 验证是否和某个字段的值一致
 * @method static bool different(mixed $value, mixed $rule, array $data = []) 验证是否和某个字段的值是否不同
 * @method static bool egt(mixed $value, mixed $rule, array $data = []) 验证是否大于等于某个值
 * @method static bool gt(mixed $value, mixed $rule, array $data = []) 验证是否大于某个值
 * @method static bool elt(mixed $value, mixed $rule, array $data = []) 验证是否小于等于某个值
 * @method static bool lt(mixed $value, mixed $rule, array $data = []) 验证是否小于某个值
 * @method static bool eq(mixed $value, mixed $rule) 验证是否等于某个值
 * @method static bool must(mixed $value, mixed $rule = null) 必须验证
 * @method static bool is(mixed $value, string $rule, array $data = []) 验证字段值是否为有效格式
 * @method static bool token(mixed $value, mixed $rule, array $data) 验证表单令牌
 * @method static bool activeUrl(mixed $value, mixed $rule = 'MX') 验证是否为合格的域名或者IP 支持A，MX，NS，SOA，PTR，CNAME，AAAA，A6， SRV，NAPTR，TXT 或者 ANY类型
 * @method static bool ip(mixed $value, mixed $rule = 'ipv4') 验证是否有效IP
 * @method static bool fileExt(mixed $file, mixed $rule) 验证上传文件后缀
 * @method static bool fileMime(mixed $file, mixed $rule) 验证上传文件类型
 * @method static bool fileSize(mixed $file, mixed $rule) 验证上传文件大小
 * @method static bool image(mixed $file, mixed $rule) 验证图片的宽高及类型
 * @method static bool json(mixed $value) 使用是否json格式
 * @method static bool dateFormat(mixed $value, mixed $rule) 验证时间和日期是否符合指定格式
 * @method static bool unique(mixed $value, mixed $rule, array $data = [], string $field = '') 验证是否唯一
 * @method static bool filter(mixed $value, mixed $rule) 使用filter_var方式验证
 * @method static bool requireIf(mixed $value, mixed $rule, array $data = []) 验证某个字段等于某个值的时候必须
 * @method static bool requireIfNot(mixed $value, mixed $rule, array $data = []) 验证某个字段不等于某个值的时候必须
 * @method static bool requireCallback(mixed $value, mixed $rule, array $data = []) 通过回调方法验证某个字段是否必须
 * @method static bool requireWith(mixed $value, mixed $rule, array $data = []) 验证某个字段有值的情况下必须
 * @method static bool requireWithout(mixed $value, mixed $rule, array $data = []) 验证某个字段没有值的情况下必须
 * @method static bool in(mixed $value, mixed $rule) 验证是否在范围内
 * @method static bool notIn(mixed $value, mixed $rule) 验证是否不在某个范围
 * @method static bool between(mixed $value, mixed $rule) between验证数据
 * @method static bool notBetween(mixed $value, mixed $rule) 使用notbetween验证数据
 * @method static bool length(mixed $value, mixed $rule) 验证数据长度
 * @method static bool max(mixed $value, mixed $rule) 验证数据最大长度
 * @method static bool min(mixed $value, mixed $rule) 验证数据最小长度
 * @method static bool after(mixed $value, mixed $rule, array $data = []) 验证日期
 * @method static bool before(mixed $value, mixed $rule, array $data = []) 验证日期
 * @method static bool afterWith(mixed $value, mixed $rule, array $data = []) 验证日期
 * @method static bool beforeWith(mixed $value, mixed $rule, array $data = []) 验证日期
 * @method static bool expire(mixed $value, mixed $rule) 验证有效期
 * @method static bool allowIp(mixed $value, mixed $rule) 验证IP许可
 * @method static bool denyIp(mixed $value, mixed $rule) 验证IP禁用
 * @method static bool regex(mixed $value, mixed $rule) 使用正则验证数据
 * @method static array|string getError() 获取错误信息
 * @method static bool __call(string $method, array $args) 动态方法 直接调用is方法进行验证
 */
class Validate
{

    protected static $_instance = null;

    public static function instance()
    {
        if (!static::$_instance) {
            static::$_instance = new \yzh52521\validate\Validate();
        }
        return static::$_instance;
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return static::instance()->{$name}(... $arguments);
    }
}