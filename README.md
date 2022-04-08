# webman-validate

> 基于PHP7.4 + 的Validate实现。基于ThinkPHP6修改的可用于 webman 的通用validate数据验证器。

* 支持助手函数validate(),无需手动创建。
* 支持场景验证scene
* 支持表单令牌token
* 支持unique唯一性验证(基于TP think-orm Db类)
* 支持图片验证

## 安装

```shell
composer require yzh52521/webman-validate
```

## 使用

> 用法跟TP6完全一致

###定义验证器：

```php
namespace app\validate;

use yzh52521\validate\Validate;

class User extends Validate
{
    protected $rule =   [
        'name'  => 'require|max:25',
        'age'   => 'require|number|between:1,120',
        'email' => 'require|email'
    ];

    protected $message  =   [
        'name.require' => '名称必须填写',
        'name.max'     => '名称最多不能超过25个字符',
        'age.require'   => '年龄必须填写',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email.require' => '邮箱必须填写',
        'email.email'   => '邮箱格式错误'
    ];

}

```

##验证器调用代码如下：

```
$data = [
    'name'  => 'thinkphp',
    'age'  => 24,
    'email' => 'thinkphp@163.com'
];
$validate = new \app\validate\User;

if (!$validate->check($data)) {
    var_dump($validate->getError());
}
```
##助手函数（推荐）
自定义函数 functions.php 添加validate()函数
```
/**
 * @desc 验证器助手函数
 * @param string|array $validate 验证器类名或者验证规则数组
 * @param array $message 错误提示信息
 * @param bool $batch 是否批量验证
 * @param bool $failException 是否抛出异常
 * @return bool
 * @author yzh52521
 */
function validate($validate = '', array $message = [], bool $batch = false, bool $failException = true)
{
    if (is_array($validate) || ''===$validate) {
        $v = new \yzh52521\validate\Validate();
        $v->rule($validate);
    } else {
        if (strpos($validate, '.')) {
            [$validate, $scene] = explode('.', $validate);
        }
        $v = new $validate();
        if (!empty($scene)) {
            $v->scene($scene);
        }
    }
     return $v->message($message)->batch($batch)->failException($failException);
}

```
>验证器调用代码如下：

```php
namespace app\controller;

use app\validate\User;
use yzh52521\validate\exception\ValidateException;

class Index
{
    public function index()
    {
        try {
            validate(User::class)->check([
                'name'  => 'thinkphp',
                'email' => 'thinkphp@qq.com',
            ]);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            dump($e->getError());
        }
    }
}

    //场景校验方法
    $data = [
        'name'  => 'thinkphp',
        'age'   => 10,
        'email' => 'thinkphp@qq.com',
    ];

    try {
        validate(app\validate\User::class)
            ->scene('edit')
            ->check($data);
    } catch (ValidateException $e) {
        // 验证失败 输出错误信息
        dump($e->getError());
    }

    // 静态方法验证
    $validate = \yzh52521\validate\facade\Validate::rule('age', 'number|between:1,120')
    ->rule([
        'name'  => 'require|max:25',
        'email' => 'email'
    ]);

    $data = [
        'name'  => 'thinkphp',
        'email' => 'thinkphp@qq.com'
    ];

    if (!$validate->check($data)) {
        dump($validate->getError());
    }
```
更多用法可以参考6.0完全开发手册的[验证](https://www.kancloud.cn/manual/thinkphp6_0/1037623)章节
