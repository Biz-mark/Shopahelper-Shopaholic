<?php namespace BizMark\Shopahelper\Console\Cache;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;

use Lovata\Shopaholic\Classes\Item\BrandItem;
use Lovata\Shopaholic\Classes\Item\CategoryItem;
use Lovata\Shopaholic\Classes\Item\OfferItem;
use Lovata\Shopaholic\Classes\Item\ProductItem;

trait CacheHelper
{
    /**
     * Processing cache of given model and ElementItem
     *
     * @param string $sName
     * @param string|Product|Category|Brand|Offer $obModel
     * @param string|ProductItem|CategoryItem|BrandItem|OfferItem $obModelItem
     */
    function generateCache($sName, $obModel, $obModelItem)
    {
        $this->info('Generating '.$sName.' cache.');
        $obBar = $this->output->createProgressBar($obModel::active()->count());

        foreach ($obModel::active()->orderBy('id')->cursor() as $obRecord) {
            $obModelItem::make($obRecord->id);
            $obBar->advance();
            unset($obRecord);
        }

        $obBar->finish();
        $this->getOutput()->newLine(2);

        unset($obBar);
        unset($sName);
        unset($obModel);
        unset($obModelItem);
    }
}
