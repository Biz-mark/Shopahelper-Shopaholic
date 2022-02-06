<?php namespace BizMark\Shopahelper\Console\Setters;

use App;
use Lovata\Shopaholic\Models\Product;

trait AttributeHelper
{
    /**
     * @param $sModelName
     * @return mixed
     */
    function initModel($sModelName) {
        return App::make("\Lovata{$sModelName}");
    }

    function setAttribute($sModelName, $sAttributeName, $sAttributeValue, $sIds) {
        $obModel = $this->initModel($sModelName);

        if (strpos($sIds, ',') !== false){
            $arIds = explode(',', $sIds);
            foreach ($arIds as $sId) {
                try {
                    $obModel = $obModel->find($sId);
                    $obModel->$sAttributeName = $sAttributeValue;
                    $obModel->save();
                    $this->output->writeln("#{$sId} {$sAttributeName} = {$sAttributeValue}");
                } catch (\Exception $ex) {
                    $this->output->writeln("Произошла ошибка с #".$sId. ' - '.$ex->getMessage());
                }
            }
        } else {
            $obModel = $obModel->find($sIds);
            $obModel->$sAttributeName = $sAttributeValue;
            $obModel->save();
            $this->output->writeln("#{$sIds} {$sAttributeName} = {$sAttributeValue}");
        }
    }
}