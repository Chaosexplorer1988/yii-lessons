<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clndr_calendar".
 *
 * @property integer $id
 * @property string $text
 * @property integer $creator
 * @property string $date_event
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clndr_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['creator'], 'integer'],
            [['date_event'], 'safe'],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }
    /**
     * Before save event handler
     * @param bool $insert
     * @return bool
     */
    public function beforeSave ($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord())
            {
                $this->creator = Yii::$app->getUser()->id;
            }

            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'creator' => Yii::t('app', 'Creator'),
            'date_event' => Yii::t('app', 'Date Event'),
        ];
    }
    public function getUserCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    public function getAccess()
    {
        return $this->hasMany(Access::className(), ['date' => 'date_event']);
    }
    /**
     * @inheritdoc
     * @return \app\models\query\ClndrCalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ClndrCalendarQuery(get_called_class());
    }
}
