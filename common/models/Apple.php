<?php

namespace common\models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Exception;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string|null $color
 * @property string|null $appearance_date
 * @property string|null $fall_date
 * @property float|null $eaten
 */
class Apple extends ActiveRecord
{

    public function __construct($color = null) {
        $this->color = $color;
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        if ($this->isNewRecord) {
            if(is_null($this->color)) $this->color = '#'. dechex(rand(100, 255)) . dechex(rand(100, 255)) . dechex(rand(16, 50));
            $this->appearance_date = Carbon::createFromTimestamp(mt_rand());
            $this->left = 1;
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
            [['appearance_date'], 'required'],
            [['left'], 'number'],
            [['left'], 'required'],

            [['fall_date'], 'default', 'value' => null, 'on' => 'insert'],
            // [['state'], 'integer'],
            [['left'], 'default', 'value' => 1, 'on' => 'insert'],
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

    public function throw() {
        if($this->state != 'on_tree') throw new Exception('Already thrown Apple cannot be thrown');
        $this->fall_date = Carbon::now()->format('Y-m-d H:m:s');
        $this->save();
    }

    public function eat($amount) {
        if($this->state == 'on_tree') throw new Exception('Apple on the tree cannot be eaten');
        if($this->state == 'rotten') throw new Exception('Rotten Apple cannot be eaten');
        $left = $this->left - ($amount / 100);
        if($left <= 0) {
            $this->delete();
        }
        else {
            $this->left = $left;
            $this->save();
        }
    }
}
