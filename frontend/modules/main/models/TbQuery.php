<?php

namespace frontend\modules\main\models;

/**
 * This is the ActiveQuery class for [[TbServicegroup]].
 *
 * @see TbServicegroup
 */
class TbQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbServicegroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbServicegroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
