<?php namespace BizMark\Shopahelper\Console\Detachers;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;

trait DetachHelper
{
    protected function detachArrayOrSingle($obMaster, $arSlave, $slaveModel, $masterField, $manyRelation = false)
    {
        if (strpos($arSlave, ',') !== false){
            $arSlavesID = explode(',', $arSlave);
            $obSlaves = $slaveModel::active()->whereIn('id', $arSlavesID)->get();
            if ($obSlaves->isNotEmpty()) {
                foreach ($obSlaves as $obSlave) {
                    if ($manyRelation){
                        $this->detachSlaveFromManyMaster($obSlave, $obMaster, $masterField);
                    } else {
                        $this->detachSlaveFromMaster($obSlave, $obMaster, $masterField);
                    }
                }
            } else {
                $this->output->writeln('Slaves with given array not found');
                return;
            }
        } else {
            $obSlave = $slaveModel::active()->find($arSlave);
            if (empty($obSlave)) {
                $this->output->writeln(sprintf("Slave with id %s not found", $arSlave));
                return;
            }
            if ($manyRelation){
                $this->detachSlaveFromManyMaster($obSlave, $obMaster, $masterField);
            } else {
                $this->detachSlaveFromMaster($obSlave, $obMaster, $masterField);
            }
        }
    }

    protected function detachSlaveFromMaster($obSlave, $obMaster, $masterField)
    {
        $this->output->writeln(sprintf("Detaching #%s from #%s", $obSlave->id, $obMaster->id));
        try {
            $obSlave->{$masterField}()->remove($obMaster);
        } catch (\Exception $ex){
            $this->output->writeln(sprintf("Detaching #%s to #%s caused some troubles, look at console", $obSlave->id, $obMaster->id));
            trace_log($ex);
        }
    }

    protected function detachSlaveFromManyMaster($obSlave, $obMaster, $masterField)
    {
        $this->output->writeln(sprintf("Detaching #%s from #%s", $obSlave->id, $obMaster->id));
        try {
            $obSlave->{$masterField}()->detach($obMaster);
        } catch (\Exception $ex){
            $this->output->writeln(sprintf("Detaching #%s to #%s caused some troubles, look at console", $obSlave->id, $obMaster->id));
            trace_log($ex);
        }
    }
}