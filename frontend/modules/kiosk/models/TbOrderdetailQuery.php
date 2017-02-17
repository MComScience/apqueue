<?php

namespace frontend\modules\kiosk\models;

/**
 * This is the ActiveQuery class for [[TbOrderdetail]].
 *
 * @see TbOrderdetail
 */
class TbOrderdetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbOrderdetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbOrderdetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
