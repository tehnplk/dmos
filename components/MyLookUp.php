<?php

namespace app\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class MyLookUp extends Component {

    public static function chw() {
        $sql = "select code, name from c_changwat order by name asc";
        $raw = \Yii::$app->db->createCommand($sql)->queryAll();
        $items = ArrayHelper::map($raw, 'code', 'name');
        return $items;
    }

    public static function amp($chw_code) {
        $sql = "select codefull code, name from camp where changwat = '$chw_code'";
        $raw = \Yii::$app->db->createCommand($sql)->queryAll();
        $items = ArrayHelper::map($raw, 'code', 'name');
        return $items;
    }

    public static function amp_plk() {
        $items = [
            '01' => 'เมือง',
            '02' => 'นครไทย',
            '03' => 'ชาติตระการ',
            '04' => 'บางระกำ',
            '05' => 'บางกระทุ่ม',
            '06' => 'พรหมพิราม',
            '07' => 'วัดโบสถ์',
            '08' => 'วังทอง',
            '09' => 'เนินมะปราง'
        ];
        return $items;
    }

    public static function list_tmb($amp) {
        $sql = "select code as id, name from ctmb where amp = '$amp'";
        $raw = \Yii::$app->db->createCommand($sql)->queryAll();
        $items = ArrayHelper::map($raw, 'id', 'name');
        return $items;
    }
    
     public static function list_moo($tmb) {
        $sql = "select code as id, concat(RIGHT(code,2),'-',name) name from cmoo where tmb = '$tmb'";
        $raw = \Yii::$app->db->createCommand($sql)->queryAll();
        $items = ArrayHelper::map($raw, 'id', 'name');
        return $items;
    }

    public static function byear() {
        $max = date('Y');
        $min = $max - 120;
        $items = [];

        for ($i = $max; $i >= $min; $i--) {
            $items[$i] = $i;
        }
        return $items;
    }

    public static function bmon() {
        $bmon = [];
        $bmon['01'] = 'มกราคม';
        $bmon['02'] = 'กุมภาพันธ์';
        $bmon['03'] = 'มีนาคม';
        $bmon['04'] = 'เมษายน';
        $bmon['05'] = 'พฤษภาคม';
        $bmon['06'] = 'มิถุนายน';
        $bmon['07'] = 'กรกฎาคม';
        $bmon['08'] = 'สิงหาคม';
        $bmon['09'] = 'กันยายน';
        $bmon['10'] = 'ตุลาคม';
        $bmon['11'] = 'พฤศจิกายน';
        $bmon['12'] = 'ธันวาคม';

        return $bmon;
    }

    public static function bdate() {
        $items = [];
        for ($i = 1; $i <= 31; $i++) {
            if (strlen($i) == 1) {
                $i = "0" . $i;
            }
            $items[$i] = $i;
        }
        return $items;
    }

    public static function marital() {
        return [
            'โสด' => 'โสด',
            'สมรส' => 'สมรส',
            'หม้าย' => 'หม้าย',
            'หย่า' => 'หย่า',
            'แยกกันอยู่' => 'แยกกันอยู่',
            'ไม่ทราบ' => 'ไม่ทราบ'
        ];
    }

   

  
   

   

    

    

   

}
