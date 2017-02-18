<?php

namespace frontend\modules\main\classes;
use frontend\modules\main\models\TbCounterservice;

class MainQuery {

    public static function getTablecalling($ServiceGroupID) {
        $rows = (new \yii\db\Query())
                ->select([
                    'tb_caller.caller_ids',
                    'tb_caller.qnum',
                    'tb_service.service_name',
                    'tb_caller.counterserviceid',
                    'tb_caller.callerid',
                    'tb_caller.call_timestp',
                    'tb_caller.call_status',
                    'tb_caller.q_ids',
                    'tb_quequ.q_statusid',
                    'tb_counterservice.counterservice_name'
                ])
                ->from('tb_caller')
                ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                ->where(['tb_quequ.servicegroupid' => $ServiceGroupID])
                ->andWhere('tb_quequ.q_statusid in (1,2,3)')
                ->orderBy('tb_caller.caller_ids DESC')
                ->all();
        return $rows;
    }

    public static function getTablewaiting($ServiceGroupID) {
        $rows = (new \yii\db\Query())
                ->select(['tb_quequ.q_num', 'tb_service.service_name', 'tb_quequ.serviceid', 'tb_quequ.q_ids', 'tb_quequ.servicegroupid'])
                ->from('tb_quequ')
                ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                ->innerJoin('tb_qstatus', 'tb_qstatus.q_statusid = tb_quequ.q_statusid')
                ->leftJoin('tb_caller', 'tb_caller.q_ids = tb_quequ.q_ids')
                ->where(['tb_quequ.servicegroupid' => $ServiceGroupID, 'tb_quequ.q_statusid' => 1])
                ->andWhere('isnull (tb_caller.qnum)')
                ->all();
        return $rows;
    }
    
    public static function getTableholdlist($ServiceGroupID) {
        $rows = (new \yii\db\Query())
                ->select(['tb_quequ.q_num', 'tb_service.service_name', 'tb_quequ.serviceid', 'tb_quequ.q_ids', 'tb_qstatus.q_statusdesc'])
                ->from('tb_quequ')
                ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                ->innerJoin('tb_qstatus', 'tb_qstatus.q_statusid = tb_quequ.q_statusid')
                ->leftJoin('tb_caller', 'tb_caller.q_ids = tb_quequ.q_ids')
                ->where(['tb_quequ.servicegroupid' => $ServiceGroupID, 'tb_quequ.q_statusid' => 3])
                ->andWhere('isnull (tb_caller.qnum)')
                ->all();
        return $rows;
    }
    
    public static function getCounterlist($servicegroupid){
        return TbCounterservice::find()->where(['servicegroupid' => $servicegroupid])->all();
    }
    
    public static function getTablecallingOncall($q_ids) {
        $rows = (new \yii\db\Query())
                ->select([
                    'tb_caller.caller_ids',
                    'tb_caller.qnum',
                    'tb_service.service_name',
                    'tb_caller.counterserviceid',
                    'tb_caller.callerid',
                    'tb_caller.call_timestp',
                    'tb_caller.call_status',
                    'tb_caller.q_ids',
                    'tb_quequ.q_statusid',
                    'tb_counterservice.counterservice_name'
                ])
                ->from('tb_caller')
                ->innerJoin('tb_quequ', 'tb_caller.q_ids = tb_quequ.q_ids')
                ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                ->innerJoin('tb_counterservice', 'tb_counterservice.counterserviceid = tb_caller.counterserviceid')
                ->where(['tb_caller.q_ids' => $q_ids])
                ->orderBy('tb_caller.caller_ids DESC')
                ->one();
        return $rows;
    }

}
