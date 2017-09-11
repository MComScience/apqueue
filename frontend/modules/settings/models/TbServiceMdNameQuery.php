<?php

namespace frontend\modules\settings\models;

/**
 * This is the ActiveQuery class for [[TbServiceMdName]].
 *
 * @see TbServiceMdName
 */
class TbServiceMdNameQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbServiceMdName[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbServiceMdName|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
