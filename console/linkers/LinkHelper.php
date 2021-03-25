<?php namespace BizMark\ShopaHelper\Console\Linkers;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;

trait LinkHelper
{

    /**
     * Linking master model to slave by given string with comma
     *
     * @param Offer|Brand|Product|Category $obMaster
     * @param string $arSlave
     * @param Offer|Brand|Product|Category|string $slaveModel
     * @param string $masterField
     * @param bool $manyRelation
     */
    function linkArrayOrSingle($obMaster, $arSlave, $slaveModel, $masterField, $manyRelation = false)
    {
        if (strpos($arSlave, ',') !== false){
            $arSlavesID = explode(',', $arSlave);
            $obSlaves = $slaveModel::active()->whereIn('id', $arSlavesID)->get();
            if ($obSlaves->isNotEmpty()) {
                foreach ($obSlaves as $obSlave) {
                    if ($manyRelation){
                        $this->linkSlaveToManyMaster($obSlave, $obMaster, $masterField);
                    } else {
                        $this->linkSlaveToMaster($obSlave, $obMaster, $masterField);
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
                $this->linkSlaveToManyMaster($obSlave, $obMaster, $masterField);
            } else {
                $this->linkSlaveToMaster($obSlave, $obMaster, $masterField);
            }
        }
    }

    /**
     * @param Offer|Brand|Product|Category $obSlave
     * @param Offer|Brand|Product|Category $obMaster
     * @param string $masterField
     */
    function linkSlaveToMaster($obSlave, $obMaster, $masterField)
    {
        $this->output->writeln(sprintf("Linking #%s to #%s", $obSlave->id, $obMaster->id));
        try {
            $obSlave->{$masterField} = $obMaster->id;
            $obSlave->save();
        } catch (\Exception $ex){
            $this->output->writeln(sprintf("Linking #%s to #%s caused some troubles, look at console", $obSlave->id, $obMaster->id));
            trace_log($ex);
        }
    }

    /**
     * @param Offer|Brand|Product|Category $obSlave
     * @param Offer|Brand|Product|Category $obMaster
     * @param string $masterField
     */
    function linkSlaveToManyMaster($obSlave, $obMaster, $masterField)
    {
        $this->output->writeln(sprintf("Linking #%s to #%s", $obSlave->id, $obMaster->id));
        try {
            $obSlave->{$masterField}()->attach($obMaster);
            $obSlave->save();
        } catch (\Exception $ex){
            $this->output->writeln(sprintf("Linking #%s to #%s caused some troubles, look at console", $obSlave->id, $obMaster->id));
            trace_log($ex);
        }
    }
}