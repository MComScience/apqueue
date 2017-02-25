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
                ->select(['tb_quequ.q_num', 'tb_quequ.service_name','tb_service.serviceid', 'tb_quequ.serviceid', 'tb_quequ.q_ids', 'tb_quequ.servicegroupid'])
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

    public static function getCounterlist($servicegroupid) {
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

    public static function getOrderChecklist() {
        $rows = (new \yii\db\Query())
                ->select([
                    'tb_quequ.q_ids',
                    'tb_servicegroup.servicegroup_name',
                    'tb_quequ.q_num',
                    'tb_service.service_name',
                    'ifnull((SELECT GROUP_CONCAT(tb_orderdetail.orderdetail_dec) FROM tb_queueorderdetail INNER JOIN tb_orderdetail ON tb_orderdetail.orderdetailid = tb_queueorderdetail.orderdetailid WHERE tb_queueorderdetail.q_ids = tb_quequ.q_ids),"-") AS orderdetail'
                ])
                ->from('tb_quequ')
                ->innerJoin('tb_service', 'tb_service.serviceid = tb_quequ.serviceid')
                ->innerJoin('tb_servicegroup', 'tb_servicegroup.servicegroupid = tb_service.service_groupid')
                ->where(['tb_quequ.q_statusid' => 1, 'tb_service.service_groupid' => 2])
                ->all();
        return $rows;
    }

    public static function getOrderDetaillist($q_ids) {
        $rows = (new \yii\db\Query())
                ->select([
                    'tb_quequ.q_ids',
                    'tb_quequ.q_num',
                    'tb_queueorderdetail.orderdetailid',
                    'tb_orderdetail.orderdetail_dec',
                    'tb_queueorderdetail.q_result'
                    ])
                ->from('tb_queueorderdetail')
                ->innerJoin('tb_quequ', 'tb_queueorderdetail.q_ids = tb_quequ.q_ids')
                ->innerJoin('tb_orderdetail', 'tb_orderdetail.orderdetailid = tb_queueorderdetail.orderdetailid')
                ->where(['tb_quequ.q_ids' => $q_ids])
                ->all();
        return $rows;
    }

}
