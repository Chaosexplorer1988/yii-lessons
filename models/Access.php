<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table_access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $date
 *
 * @property User $userOwner
 * @property User $userGuest
 */
class Access extends \yii\db\ActiveRecord
{
    const ACCESS_CREATOR = 1;
    const ACCESS_GUEST = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'table_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guest', 'date'], 'required'],
            [['user_owner', 'user_guest'], 'integer'],
            [['date'], 'safe'],
            [['user_owner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_owner' => 'id']],
            [['user_guest'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_guest' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_owner' => Yii::t('app', 'User Owner'),
            'user_guest' => Yii::t('app', 'User Guest'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public static function checkAccess($model)
    {
        if ($model->creator==Yii::$app->user->id) {
            return self::ACCESS_CREATOR;
        }
        $accessNote = self::find()
            ->withGuest($model->id)
            ->withDate(date('Y-m-d'))
            ->exists();
        if ($accessNote) {
            return self::ACCESS_GUEST;
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->getIsNewRecord()) {
                $this->user_owner = Yii::$app->user->id;
            }
            $this->date = date('Y-m-d');
        }
        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGuest()
    {
        return $this->hasOne(User::className(), ['id' => 'user_guest']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AccessQuery(get_called_class());
    }
}
