<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Access]].
 *
 * @see \app\models\Access
 */
class AccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * Condition with user_guest
     * @param $user_guest
     * @return $this
     */
    public function withGuest($user_guest)
    {
        return $this->andWhere(
            'user_guest = :user_guest',
            [
                ":user_guest" => $user_guest
            ]
        );
    }
    /**
     * Condition with date
     * @param $user_owner
     * @return $this
     */

    public function withOwner($user_owner)
 	{
 		return $this->andWhere(
 			'user_owner = :user_owner',
            [
                ":user_owner" => $user_owner
            ]
 		);
 	}
    /**
     * Condition with date
     * @param $date
     * @return $this
     */
    public function withDate($date)
    {
        return $this->andWhere(
            'date = :date',
            [
                ":date" => $date
            ]
        );
    }
    /**
     * @inheritdoc
     * @return \app\models\Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * @inheritdoc
     * @return \app\models\Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}