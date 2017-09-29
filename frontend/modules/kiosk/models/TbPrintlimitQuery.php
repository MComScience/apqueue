<?php

namespace frontend\modules\kiosk\models;

/**
 * This is the ActiveQuery class for [[TbPrintlimit]].
 *
 * @see TbPrintlimit
 */
class TbPrintlimitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbPrintlimit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbPrintlimit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
