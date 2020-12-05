<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string|null $color
 * @property string|null $appearance_date
 * @property string|null $fall_date
 * @property int|null $state
 * @property float|null $eaten
 *
 * @property AppleStates $state0
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'string'],
            [['appearance_date', 'fall_date'], 'safe'],
            [['state'], 'integer'],
            [['eaten'], 'number'],
            [['state'], 'exist', 'skipOnError' => true, 'targetClass' => AppleState::class, 'targetAttribute' => ['state' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'appearance_date' => 'Appearance Date',
            'fall_date' => 'Fall Date',
            'state' => 'State',
            'eaten' => 'Eaten',
        ];
    }

    /**
     * Gets query for [[State0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(AppleStates::class, ['id' => 'state']);
    }
}
