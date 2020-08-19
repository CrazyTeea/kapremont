<?php

namespace app\models;

use yii\db\ActiveRecord;

class AtzTableFour extends ActiveRecord
{
    // public $stage_number;
    // public $stage_name;
    // public $method;
    // public $type_document;
    // public $name_object;
    // public $cost_full;
    // public $cost_budjet;
    // public $cost_vb;
    // public $number_contract;
    // public $date_doc;
    // public $number_deal;
    // public $name_deller_by_doc;
    // public $inn_deller_by_doc;
    // public $date_start;
    // public $date_end;
    // public $docs;
    // public $comment_vuz;
    // public $mon_expert;
    // public $comment_mon;

    public static function tableName()
    {
        return 'atz_table_four';
    }

    public static function destroy($id)
    {
        $atz_table_four = self::find()->where(['id' => $id])->one();
        if(empty($atz_table_four)) return false;
        $atz_table_four_addresses = AtzAddress::find()->where(['id_atz_table_four' => $atz_table_four->id])->all();
        foreach ($atz_table_four_addresses as $atz_table_four_one_address) {
            $atz_table_four_event_types = AtzTypeActivity::find()->where(['id_atz_table_for_address' => $atz_table_four_one_address->id])->all();
            foreach ($atz_table_four_event_types as $atz_table_four_event_type) {
                $atz_table_four_event_type->delete();
            }
            $atz_table_four_one_address->delete();
        }

        return $atz_table_four->delete();
    }
}