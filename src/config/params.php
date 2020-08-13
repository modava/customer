<?php

use modava\customer\CustomerModule;
use modava\customer\models\CustomerStatusDongY;
use modava\customer\models\CustomerStatusDatHen;
use modava\customer\models\CustomerStatusCall;
use modava\customer\models\Customer;

return [
    'customerName' => 'Customer',
    'customerVersion' => '1.0',
    'sex' => [
        Customer::SEX_WOMEN => CustomerModule::t('customer', 'Nữ'),
        Customer::SEX_MEN => CustomerModule::t('customer', 'Nam'),
    ],
    'status' => [
        '0' => CustomerModule::t('customer', 'Tạm ngưng'),
        '1' => CustomerModule::t('customer', 'Hiển thị'),
    ],
    'statusOrder' => [
        CustomerStatusDongY::STATUS_DISABLED => CustomerModule::t('customer', 'Chưa hoàn thành'),
        CustomerStatusDongY::STATUS_PUBLISHED => CustomerModule::t('customer', 'Đã hoàn thành'),
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
