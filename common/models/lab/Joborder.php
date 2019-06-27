<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_joborder".
 *
 * @property int $joborder_id
 * @property int $customer_id
 * @property string $joborder_date
 * @property string $sampling_date
 * @property string $lsono
 * @property string $sample_received
 */
class Joborder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_joborder';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['joborder_id', 'customer_id', 'joborder_date', 'sampling_date', 'lsono', 'sample_received'], 'required'],
            [['joborder_id', 'customer_id'], 'integer'],
            [['joborder_date', 'sampling_date', 'lsono', 'sample_received'], 'string', 'max' => 200],
            [['joborder_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'joborder_id' => 'L.S.O. No.',
            'customer_id' => 'Client',
            'joborder_date' => 'Date',
            'sampling_date' => 'Sampling Site',
            'lsono' => 'Lsono',
            'sample_received' => 'Sample Received',
        ];
    }
}
