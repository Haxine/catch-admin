<?php

return [
        /**
        * set domain if you need
        *
        */
        'domain' => '',

        /**
        * 权限配置
        *
        */
        'permissions' => [
        /**
        * get 请求不验证
        */
        'is_allow_get' => true,

        /**
        * 超级管理员 ID
        *
        */
        'super_admin_id' => 1,
    ],
    /**
    *  auth 认证
    *
    */
    'auth' => [
        // 默认
        'default' => [
        'guard' => 'admin',
    ],
    // 门面设置
    'guards' => [
        // admin 认证
        'admin' => [
            'driver' => 'jwt',
            'provider' => 'admin_users',
        ],
        // 开发者认证
        'developer' => [
            'driver' => 'jwt',
            'provider' => 'developer',
        ],
    ],
    // 服务提供
    'providers' => [
        // 后台用户认证服务
        'admin_users' => [
                'driver' => 'orm',
                'model' =>  \catchAdmin\permissions\model\Users::class,
            ],
        // 开发这认证服务
        'developer' => [
            'driver'=> 'orm',
            'model' => \catchAdmin\system\model\Developers::class
            ]
        ],
    ],

    /**
    * 自定义验证规则
    *
    */
    'validates' => [
        \catcher\validates\Sometimes::class,
        \catcher\validates\SensitiveWord::class,
    ],
    /**
    * 上传设置
    *
    */
    'upload' => [
        'image' => 'fileSize:' . 1024 * 1024 * 5 . '|fileExt:jpg,png,gif,jpeg',
        'file' => 'fileSize:' . 1024 * 1024 * 10 . '|fileExt:txt,pdf,xlsx,xls,html,mp4,mp3,amr'
    ],

    /**
     *
     * 定时任务配置
     *
     */
    'crontab' => [
        /**
         * 存储目录
         */
        'store_path' => runtime_path('catch/crontab'),

        /**
         * 主进程 pid 存储
         */
        'master_pid_file' => runtime_path('catch/crontab') . 'master.pid',

        /**
         * 日志配置
         */
        'log' => [
            // 日志记录方式
            'type'           => 'File',
            // 日志保存目录
            'path'           => runtime_path('catch/schedule'),
            // 单文件日志写入
            'single'         => false,
            // 独立日志级别
            'apart_level'    => [],
            // 最大日志文件数量
            'max_files'      => 0,
            // 使用JSON格式记录
            'json'           => false,
            // 日志处理
            'processor'      => null,
            // 关闭通道日志写入
            'close'          => false,
            // 日志输出格式化
            'format'         => '[%s][%s] %s',
            // 是否实时写入
            'realtime_write' => false,
        ],

        /**
         * crontab 任务命名空间
         */
        'task_namespace' => '',
    ],
];
