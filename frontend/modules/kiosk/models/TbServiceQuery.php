<?php

namespace frontend\modules\kiosk\models;

/**
 * This is the ActiveQuery class for [[TbService]].
 *
 * @see TbService
 */
class TbServiceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbService[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbService|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
