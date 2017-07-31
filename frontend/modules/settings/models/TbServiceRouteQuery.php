<?php

namespace frontend\modules\settings\models;

/**
 * This is the ActiveQuery class for [[TbServiceRoute]].
 *
 * @see TbServiceRoute
 */
class TbServiceRouteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbServiceRoute[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbServiceRoute|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
