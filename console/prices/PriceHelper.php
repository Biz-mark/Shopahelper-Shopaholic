<?php namespace BizMark\ShopaHelper\Console\Prices;

use Lovata\Shopaholic\Models\Product;

trait PriceHelper
{
    function prepareProducts($string)
    {
        if (strpos($string, ',') !== false){
            $arProductsId = explode(',', $string);
            return Product::whereIn('id', $arProductsId)->get();
        } else {
            return Product::find($string);
        }
    }

    function upscalePricePercentage($obOffer)
    {
        $iPrice = $obOffer->price_value;
        $iNewPrice = $iPrice + (($iPrice / 100) * $this->argument('percentage'));
        $obOffer->price = $iNewPrice;
        $obOffer->save();
        $this->output->writeln(sprintf("#%s %s | %s -> %d", $obOffer->id, $obOffer->name, $iPrice, $iNewPrice));
    }

    function downscalePricePercentage($obOffer)
    {
        $iPrice = $obOffer->price_value;
        $iNewPrice = $iPrice - (($iPrice / 100) * $this->argument('percentage'));
        $obOffer->price = $iNewPrice;
        $obOffer->save();
        $this->output->writeln(sprintf("#%s %s | %s -> %d", $obOffer->id, $obOffer->name, $iPrice, $iNewPrice));
    }
}