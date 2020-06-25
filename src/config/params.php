<?php

use modava\customer\CustomerModule;
use modava\customer\models\CustomerStatusDongY;
use modava\customer\models\CustomerStatusDatHen;
use modava\customer\models\CustomerStatusCall;

return [
    'availableLocales' => [
        'vi' => 'Tiếng Việt',
        'en' => 'English',
        'jp' => 'Japan',
    ],
    'customerName' => 'Customer',
    'customerVersion' => '1.0',
    'status' => [
        '0' => CustomerModule::t('customer', 'Tạm ngưng'),
        '1' => CustomerModule::t('customer', 'Hiển thị'),
    ],
    'acceptDongY' => [
        CustomerStatusDongY::STATUS_DISABLED => CustomerModule::t('customer', 'Không đồng ý'),
        CustomerStatusDongY::STATUS_PUBLISHED => CustomerModule::t('customer', 'Đồng ý'),
    ],
    'acceptDatHen' => [
        CustomerStatusDatHen::STATUS_DISABLED => CustomerModule::t('customer', 'Đặt hẹn không đến'),
        CustomerStatusDatHen::STATUS_PUBLISHED => CustomerModule::t('customer', 'Đặt hẹn đến'),
    ],
    'acceptCall' => [
        CustomerStatusCall::STATUS_DISABLED => CustomerModule::t('customer', 'Không đặt hẹn'),
        CustomerStatusCall::STATUS_PUBLISHED => CustomerModule::t('customer', 'Đặt hẹn'),
    ]
];
