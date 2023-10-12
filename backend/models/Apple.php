<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Apple extends ActiveRecord
{
    const STATUS_ON_TREE = 0;
    const STATUS_ON_GROUND = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'appearance_date'], 'required'],
            [['appearance_date', 'fall_date'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_ON_TREE],
            [['eaten_percent'], 'number', 'min' => 0, 'max' => 100],
            [['is_rotten'], 'boolean'],
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
            'status' => 'Status',
            'eaten_percent' => 'Eaten Percent',
            'is_rotten' => 'Is Rotten',
        ];
    }
    
    /**
     * Падение яблока на землю.
     */
    public function fallToGround()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->status = self::STATUS_ON_GROUND;
            $this->fall_date = time();
            $this->save();
        }
    }
    
    /**
     * Съедение яблока.
     * @param int $percent процент откушенной части
     * @throws \Exception если яблоко на дереве, испорчено или передана неверная доля для съедения
     */
    public function eat($percent)
    {
        if ($this->status === self::STATUS_ON_TREE) {
            throw new \Exception('Съесть нельзя, яблоко на дереве');
        }
        
        if ($this->is_rotten) {
            throw new \Exception('Съесть нельзя, яблоко испорчено');
        }
        
        if ($percent < 0 || $percent > 100) {
            throw new \Exception('Неверно указан процент для съедения');
        }
        
        $this->eaten_percent += $percent;
        
        if ($this->eaten_percent >= 100) {
            $this->delete();
        } else {
            $this->save();
        }
    }
    
    /**
     * Проверка состояния яблока.
     * @return string состояние яблока
     */
    public function getState()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            return 'Висит на дереве';
        } elseif ($this->is_rotten) {
            return 'Гнилое яблоко';
        } else {
            $rottenTime = 5 * 60 * 60; // 5 часов в секундах
            $currentTime = time();
            $fallTime = $this->fall_date;
            
            if ($currentTime - $fallTime >= $rottenTime) {
                $this->is_rotten = true;
                $this->save();
                return 'Гнилое яблоко';
            }
            
            return 'Упало/лежит на земле';
        }
    }
}
