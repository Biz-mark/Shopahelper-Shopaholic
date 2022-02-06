<?php namespace BizMark\Shopahelper\Console\Cache;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Lovata\PropertiesShopaholic\Models\Property;
use Lovata\PropertiesShopaholic\Models\PropertySet;
use Lovata\PropertiesShopaholic\Models\PropertyValue;

use Lovata\Shopaholic\Classes\Item\BrandItem;
use Lovata\Shopaholic\Classes\Item\CategoryItem;
use Lovata\Shopaholic\Classes\Item\OfferItem;
use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\PropertiesShopaholic\Classes\Item\PropertyItem;
use Lovata\PropertiesShopaholic\Classes\Item\PropertySetItem;
use Lovata\PropertiesShopaholic\Classes\Item\PropertyValueItem;

trait CacheHelper
{
    /**
     * Processing cache of given model and ElementItem
     *
     * @param string $sName
     * @param string|Product|Category|Brand|Offer|PropertySet|Property|PropertyValue $obModel
     * @param string|ProductItem|CategoryItem|BrandItem|OfferItem|PropertyItem|PropertySetItem|PropertyValueItem $obModelItem
     */
    function generateCache($sName, $obModel, $obModelItem)
    {
        $this->info('Generating '.$sName.' cache.');
        if (method_exists($obModel, 'scopeActive')) {
            $obBar = $this->output->createProgressBar($obModel::active()->count());
            foreach ($obModel::active()->orderBy('id')->cursor() as $obRecord) {
                $obModelItem::make($obRecord->id);
                $obBar->advance();
                unset($obRecord);
            }
        } else {
            $obBar = $this->output->createProgressBar($obModel::count());
            foreach ($obModel::orderBy('id')->cursor() as $obRecord) {
                $obModelItem::make($obRecord->id);
                $obBar->advance();
                unset($obRecord);
            }
        }

        $obBar->finish();
        $this->getOutput()->newLine(2);

        unset($obBar);
        unset($sName);
        unset($obModel);
        unset($obModelItem);
    }
}
