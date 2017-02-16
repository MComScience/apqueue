<?php

namespace frontend\modules\kiosk\models;

/**
 * This is the ActiveQuery class for [[TbQueueorderdetail]].
 *
 * @see TbQueueorderdetail
 */
class TbQueueorderdetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbQueueorderdetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbQueueorderdetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
