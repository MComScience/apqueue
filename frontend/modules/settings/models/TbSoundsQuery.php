<?php

namespace frontend\modules\settings\models;

/**
 * This is the ActiveQuery class for [[TbSounds]].
 *
 * @see TbSounds
 */
class TbSoundsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TbSounds[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbSounds|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
