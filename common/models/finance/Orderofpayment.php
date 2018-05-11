<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_orderofpayment".
 *
 * @property int $orderofpayment_id
 * @property int $rstl_id
 * @property string $transactionnum
 * @property int $collectiontype_id
 * @property int $payment_mode_id
 * @property string $order_date
 * @property int $customer_id
 * @property string $purpose
 * @property int $created_receipt
 * @property int $allow_erratum
 *
 * @property Collectiontype $collectiontype
 * @property Paymentmode $paymentMode
 * @property Paymentitem[] $paymentitems
 * @property Receipt[] $receipts
 */
class Orderofpayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_orderofpayment';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'transactionnum', 'collectiontype_id', 'payment_mode_id', 'order_date', 'customer_id', 'purpose'], 'required'],
            [['rstl_id', 'collectiontype_id', 'payment_mode_id', 'customer_id', 'created_receipt', 'allow_erratum'], 'integer'],
            [['order_date'], 'safe'],
            [['transactionnum'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
            [['collectiontype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collectiontype::className(), 'targetAttribute' => ['collectiontype_id' => 'collectiontype_id']],
            [['payment_mode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentmode::className(), 'targetAttribute' => ['payment_mode_id' => 'payment_mode_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderofpayment_id' => 'Orderofpayment ID',
            'rstl_id' => 'Rstl ID',
            'transactionnum' => 'Transactionnum',
            'collectiontype_id' => 'Collectiontype ID',
            'payment_mode_id' => 'Payment Mode ID',
            'order_date' => 'Order Date',
            'customer_id' => 'Customer ID',
            'purpose' => 'Purpose',
            'created_receipt' => 'Created Receipt',
            'allow_erratum' => 'Allow Erratum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectiontype()
    {
        return $this->hasOne(Collectiontype::className(), ['collectiontype_id' => 'collectiontype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMode()
    {
        return $this->hasOne(Paymentmode::className(), ['payment_mode_id' => 'payment_mode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentitems()
    {
        return $this->hasMany(Paymentitem::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['orderofpayment_id' => 'orderofpayment_id']);
    }
}