<?php

use yii\db\Migration;

/**
 * Class m200716_104206_create_permission_for_customer
 */
class m200716_104206_create_permission_for_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-fanpageGet-fanpage-by-origin'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-fanpageGet-fanpage-by-origin', 2, 'Backend - Customer - Get fanpage by origin', NULL, NULL, 1594883283, 1594883283)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderCreate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderCreate', 2, 'Backend - Customer - Create order', NULL, NULL, 1594885640, 1594885640)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderGet-order-by-customer'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderGet-order-by-customer', 2, 'Backend - Customer - Get order by customer', NULL, NULL, 1594887574, 1594887574)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderIndex'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderIndex', 2, 'Backend - Customer - Index order', NULL, NULL, 1594885687, 1594885687)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderUpdate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderUpdate', 2, 'Backend - Customer - Update order', NULL, NULL, 1594886169, 1594886169)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderValidate-order'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderValidate-order', 2, 'Backend - Customer - Validate order', NULL, NULL, 1594886098, 1594886098)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-orderView'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-orderView', 2, 'Backend - Customer - View order', NULL, NULL, 1594885704, 1594885704)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-originGet-origin-by-agency'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-originGet-origin-by-agency', 2, 'Backend - Customer - Get origin by agency', NULL, NULL, 1594883223, 1594883223)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-paymentCreate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-paymentCreate', 2, 'Backend - Customer - Create payment', NULL, NULL, 1594886462, 1594886462)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-paymentGet-payment-info'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-paymentGet-payment-info', 2, 'Backend - Customer - Get payment info', NULL, NULL, 1594886527, 1594886527)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-paymentIndex'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-paymentIndex', 2, 'Backend - Customer - Payment', NULL, NULL, 1594886416, 1594886416)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-paymentUpdate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-paymentUpdate', 2, 'Backend - Customer - Update payment', NULL, NULL, 1594886665, 1594886665)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-paymentView'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-paymentView', 2, 'Backend - Customer - View payment', NULL, NULL, 1594886476, 1594886476)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomer-productGet-product-info'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomer-productGet-product-info', 2, 'Backend - Customer - Get product info', NULL, NULL, 1594886071, 1594886071)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerCreate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerCreate', 2, 'Backend - Khách hàng - Tạo mới khách hàng', NULL, NULL, 1594640884, 1594640884)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerDelete'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerDelete', 2, 'Backend - Khách hàng - Xóa khách hàng', NULL, NULL, 1594640934, 1594640934)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerIndex'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerIndex', 2, 'Backend - Khách hàng - Danh sách khách hàng', NULL, NULL, 1594640867, 1594640867)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerUpdate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerUpdate', 2, 'Backend - Khách hàng - Cập nhật khách hàng', NULL, NULL, 1594640918, 1594640918)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerValidate'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerValidate', 2, 'Backend - Customer - Validate customer', NULL, NULL, 1594883347, 1594883347)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerCustomerView'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerCustomerView', 2, 'Backend - Customer - View', NULL, NULL, 1594883390, 1594883390)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='customerRemind-call'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('customerRemind-call', 2, 'Backend - Customer - Remind call', NULL, NULL, 1594873378, 1594873378)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='locationLocation-districtGet-district-by-province'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('locationLocation-districtGet-district-by-province', 2, 'Backend - Location - Get district by province', NULL, NULL, 1594873148, 1594873148)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='locationLocation-provinceGet-province-by-country'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('locationLocation-provinceGet-province-by-country', 2, 'Backend - Location - Get province by country', NULL, NULL, 1594873101, 1594873101)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `rbac_auth_item` WHERE type=2 AND name='locationLocation-wardGet-ward-by-district'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `rbac_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('locationLocation-wardGet-ward-by-district', 2, 'Backend - Location - Get ward by district', NULL, NULL, 1594873191, 1594873191)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `website_key_value` WHERE `key`='ROLE_SALES_ONLINE'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `website_key_value` (`title`, `key`, `value`, `status`, `language`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('Role Sales Online', 'ROLE_SALES_ONLINE', 'sales_online', 1, '', 1594893374, 1594893374, 1, 1)");
        }
        $check = Yii::$app->db->createCommand("SELECT * FROM `website_key_value` WHERE `key`='ROLE_DIRECT'")->queryAll(); //check permission
        if (count($check) <= 0) {
            $this->execute("INSERT INTO `website_key_value` (`title`, `key`, `value`, `status`, `language`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('Role Direct', 'ROLE_DIRECT', 'clinic', 1, '', 1594893389, 1594893389, 1, 1)");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200716_104206_create_permission_for_customer cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200716_104206_create_permission_for_customer cannot be reverted.\n";

        return false;
    }
    */
}
