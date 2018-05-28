<?php

namespace common\models\services;

use Yii;

/**
 * This is the model class for table "tbl_test".
 *
 * @property int $test_id
 * @property int $rstl_id
 * @property string $testname
 * @property string $method
 * @property string $payment_references
 * @property string $fee
 * @property int $duration
 * @property int $testcategory_id
 * @property int $sample_type_id
 * @property int $lab_id
 *
 * @property Analysis[] $analyses
 * @property Analysis[] $analyses0
 * @property Lab $lab
 * @property Testcategory $testcategory
 * @property Sampletype $sampleType
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_test';
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
            [['rstl_id', 'testname', 'method', 'testcategory_id', 'sample_type_id'], 'required'],
            [['rstl_id', 'duration', 'testcategory_id', 'sample_type_id', 'lab_id'], 'integer'],
            [['fee'], 'number'],
            [['testname'], 'string', 'max' => 200],
            [['method'], 'string', 'max' => 150],
            [['payment_references'], 'string', 'max' => 100],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
            [['testcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testcategory::className(), 'targetAttribute' => ['testcategory_id' => 'testcategory_id']],
            [['sample_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sampletype::className(), 'targetAttribute' => ['sample_type_id' => 'sample_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'test_id' => 'Test ID',
            'rstl_id' => 'Rstl ID',
            'testname' => 'Testname',
            'method' => 'Method',
            'payment_references' => 'Payment References',
            'fee' => 'Fee',
            'duration' => 'Duration',
            'testcategory_id' => 'Testcategory ID',
            'sample_type_id' => 'Sample Type ID',
            'lab_id' => 'Lab ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(Analysis::className(), ['test_id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses0()
    {
        return $this->hasMany(Analysis::className(), ['test_id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestcategory()
    {
        return $this->hasOne(Testcategory::className(), ['testcategory_id' => 'testcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampleType()
    {
        return $this->hasOne(Sampletype::className(), ['sample_type_id' => 'sample_type_id']);
    }
}
