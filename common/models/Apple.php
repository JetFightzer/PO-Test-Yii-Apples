<?php

namespace common\models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Exception;
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

    public function init()
    {
        parent::init();
        if ($this->isNewRecord) {
            $this->color = '#'. dechex(rand(100, 255)) . dechex(rand(100, 255)) . dechex(rand(0, 50));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['color'], 'string'],
            [['appearance_date'], 'safe'],
            [['left'], 'number'],

            [['fall_date'], 'default', 'value' => null, 'on' => 'insert'],
            // [['state'], 'integer'],
            [['left'], 'default', 'value' => 100, 'on' => 'insert'],
            // [['state'], 'exist', 'skipOnError' => true, 'targetClass' => AppleState::class, 'targetAttribute' => ['state' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'color'           => 'Color',
            'appearance_date' => 'Appearance Date',
            'fall_date'       => 'Fall Date',
            'state'           => 'State',
            'left'            => 'Left',
        ];
    }

    public $stateLabels = [
        'on_tree'              => 'ID',
        'falled_down'           => 'Color',
        'rotten'       => 'Fall Date',
    ];

    public function getState()
    {
        if( is_null($this->fall_date) ) {
            return 'on_tree';
        }
        else {
            $expire_date = Carbon::create($this->fall_date, 'Europe/Moscow')->addHours(5);
            if( !is_null($this->fall_date) && Carbon::now('Europe/Moscow') <= $expire_date ) {
                return 'falled_down';
            }
            elseif( !is_null($this->fall_date) && Carbon::now('Europe/Moscow') > $expire_date ) {
                return 'rotten';
            }
        }
        return 'error';
    }

    public function getStateLabeled()
    {
        $labels = [
            'on_tree'     => 'On Tree',
            'falled_down' => 'Falled On The Ground',
            'rotten'      => 'Rotten',
        ];
        return $labels[$this->getState()];
    }
}
