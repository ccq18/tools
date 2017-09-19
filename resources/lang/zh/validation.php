<?php

return [


    ///
    'accepted'   => ':attribute是被接受的',
    'active_url' => ':attribute必须是一个合法的 URL',
    'after'      => ':attribute必须是 :date 之后的一个日期',
    'alpha'      => ':attribute必须全部由字母字符构成。',
    'alpha_dash' => ':attribute必须全部由字母、数字、中划线或下划线字符构成',
    'alpha_num'  => ':attribute必须全部由字母和数字构成',
    'array'      => ':attribute必须是个数组',


    'before'               => ':attribute 必须是 :date 之前的一个日期',
    'between'              =>
        [
            'numeric' => ':attribute 必须在 :min 到 :max之间',
            'file'    => ':attribute 必须在 :min 到 :max KB之间',
            'string'  => ':attribute 必须在 :min 到 :max 个字符之间',
            'array'   => ':attribute 必须在 :min 到 :max 项之间',
        ],
    'boolean'              => ':attribute 字符必须是 true 或 false',
    'confirmed'            => ':attribute 二次确认不匹配',
    'date'                 => ':attribute必须是一个合法的日期',
    'date_format'          => ':attribute 与给定的格式 :format 不符合',
    'different'            => ':attribute 必须不同于:other',
    'digits'               => ':attribute必须是 :digits 位',
    'digits_between'       => ':attribute 必须在 :min and :max 位之间',
    'email'                => ':attribute必须是一个合法的电子邮件地址。',
    'exists'               => '选定的 :attribute 是无效的',
    'filled'               => ':attribute的字段是必填的',
    'image'                => ':attribute 必须是一个图片 (jpeg, png, bmp 或者 gif)',
    'in'                   => '选定的 :attribute 是无效的',
    'integer'              => ':attribute 必须是个整数',
    'ip'                   => ':attribute必须是一个合法的 IP 地址。',
    'max'                  =>
        [
            'numeric' => ':attribute 的最大长度为:max位',
            'file'    => ':attribute 的最大为:max',
            'string'  => ':attribute 的最大长度为:max字符',
            'array'   => ':attribute 的最大个数为:max个',
        ],
    'mimes'                => ':attribute 的文件类型必须是:values',
    'min'                  =>
        [
            'numeric' => ':attribute的最小长度为:min位',
            'string'  => ':attribute的最小长度为:min字符',
            'file'    => ':attribute 大小至少为:min KB',
            'array'   => ':attribute 至少有 :min 项',
        ],
    'not_in'               => '选定的 :attribute 是无效的',
    'numeric'              => ':attribute 必须是数字',
    'regex'                => ':attribute 格式是无效的',
    'required'             => ':attribute是必填的',
    'required_if'          => ':attribute 字段是必须的当 :other 是 :value',
    'required_with'        => ':attribute 字段是必须的当 :values 是存在的',
    'required_with_all'    => ':attribute 字段是必须的当 :values 是存在的',
    'required_without'     => ':attribute 字段是必须的当 :values 是不存在的',
    'required_without_all' => ':attribute 字段是必须的当 没有一个 :values 是存在的',
    'same'                 => ':attribute和:other必须匹配',
    'size'                 =>
        [
            'numeric' => ':attribute 必须是 :size 位',
            'file'    => ':attribute 必须是 :size KB',
            'string'  => ':attribute 必须是 :size 个字符',
            'array'   => ':attribute 必须包括 :size 项',
        ],
    'timezone'             => ':attribute 必须是个有效的时区',
    'unique'               => ':attribute已存在',
    'url'                  => ':attribute 无效的格式',

//
    'after_or_equal'       => ':attribute 必须大于 :date.',

    'before_or_equal' => ':attribute 必须小于 :date.',

    'dimensions' => ':attribute 错误.',
    'distinct'   => ':attribute 错误.',

    'file' => ' :attribute不是文件.',

    'in_array' => ':attribute必须属于:other.',

    'ipv4' => ':attribute不是ipv4.',
    'ipv6' => ':attribute不是ipv6.',
    'json' => ':attribute必须是json.',

    'mimetypes' => ' :attribute 必须属于:values.',

    'present' => ':attribute必须存在.',

    'required_unless' => 'The :attribute field is required unless :other is in :values.',

    'string'   => ':attribute必须是字符串',
    'uploaded' => ':attribute 上传失败',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'     => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Custom Validation Attributes
   |--------------------------------------------------------------------------
   |
   | The following language lines are used to swap attribute place-holders
   | with something more reader friendly such as E-Mail Address instead
   | of "email". This simply helps us make messages a little cleaner.
   |
   */
    'attributes' =>
        [
            'username'     => '用户名',
            'verify_code'  => '验证码',
            'phone_number' => '手机号',
            'password'     => '密码',
            'content'      => '内容',
            'identity'     => '手机号/用户名',
        ],

];

