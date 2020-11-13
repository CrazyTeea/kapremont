<?php

namespace app\models;

/**
 * This is the model class for table "atz_table_four".
 *
 * @property int $id
 * @property int|null $id_org
 * @property string|null $stage_name
 * @property string|null $stage_number
 * @property int|null $card_number
 * @property string|null $method
 * @property string|null $type_document
 * @property string|null $name_object
 * @property string|null $cost_full
 * @property string|null $cost_budjet
 * @property string|null $cost_vb
 * @property string|null $number_contract
 * @property string|null $date_doc
 * @property string|null $number_deal
 * @property string|null $name_deller_by_doc
 * @property string|null $inn_deller_by_doc
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string|null $docs
 * @property string|null $comment_vuz
 * @property int|null $mon_expert
 * @property string|null $comment_mon
 * @property string $zakant
 */
class AtzTableFour extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atz_table_four';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org'], 'integer'],
            [['date_doc', 'date_start', 'date_end', 'card_number', 'mon_expert','cost_full'], 'safe'],
            [['comment_vuz',], 'string'],
            [['stage_name', 'stage_number', 'method', 'type_document', 'name_object', 'cost_budjet', 'cost_vb', 'number_contract', 'number_deal', 'name_deller_by_doc', 'inn_deller_by_doc', 'docs', 'comment_mon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'stage_name' => 'Stage Name',
            'stage_number' => 'Stage Number',
            'card_number' => 'Card Number',
            'method' => 'Method',
            'type_document' => 'Type Document',
            'name_object' => 'Name Object',
            'cost_full' => 'Cost Full',
            'cost_budjet' => 'Cost Budjet',
            'cost_vb' => 'Cost Vb',
            'number_contract' => 'Number Contract',
            'date_doc' => 'Date Doc',
            'number_deal' => 'Number Deal',
            'name_deller_by_doc' => 'Name Deller By Doc',
            'inn_deller_by_doc' => 'Inn Deller By Doc',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'docs' => 'Docs',
            'comment_vuz' => 'Comment Vuz',
            'mon_expert' => 'Mon Expert',
            'comment_mon' => 'Comment Mon',
        ];
    }

    public static function destroy($id)
    {
        $atz_table_four = self::find()->where(['id' => $id])->one();
        if (empty($atz_table_four)) return false;
        $atz_table_four_addresses = AtzAddress::find()->where(['id_atz_table_four' => $atz_table_four->id])->all();
        foreach ($atz_table_four_addresses as $atz_table_four_one_address) {
            $atz_table_four_event_types = AtzTypeActivity::find()->where(['id_atz_table_for_address' => $atz_table_four_one_address->id])->all();
            foreach ($atz_table_four_event_types as $atz_table_four_event_type) {
                $atz_table_four_event_type->delete();
            }
            $atz_table_four_one_address->delete();
        }

        $sub_systems = Sub_systems_table4::find()->where(['id_card' => $id])->all();
        foreach ($sub_systems as $sub_system) {
            $sub_system->delete();
        }

        return $atz_table_four->delete();
    }
}
