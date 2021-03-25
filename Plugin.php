<?php namespace BizMark\ShopaHelper;

use Backend;
use System\Classes\PluginBase;

/**
 * ShopaHelper Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ShopaHelper',
            'description' => 'The almighty helper in bulk actions for Shopaholic',
            'author'      => 'BizMark',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        // Caching
        $this->registerConsoleCommand('shopahelper:cache.all', 'BizMark\ShopaHelper\Console\Cache\GenerateCache');
        $this->registerConsoleCommand('shopahelper:cache.categories', 'BizMark\ShopaHelper\Console\Cache\GenerateCategoriesCache');
        $this->registerConsoleCommand('shopahelper:cache.products', 'BizMark\ShopaHelper\Console\Cache\GenerateProductsCache');
        $this->registerConsoleCommand('shopahelper:cache.offers', 'BizMark\ShopaHelper\Console\Cache\GenerateOffersCache');
        $this->registerConsoleCommand('shopahelper:cache.brands', 'BizMark\ShopaHelper\Console\Cache\GenerateBrandsCache');

        // Linkers
        //// Brands
        $this->registerConsoleCommand('shopahelper:link.brand-to-products', 'BizMark\ShopaHelper\Console\Linkers\BrandToProducts');
        $this->registerConsoleCommand('shopahelper:link.brand-to-products-by-category', 'BizMark\ShopaHelper\Console\Linkers\BrandToProductsByCategory');
        //// Categories
        $this->registerConsoleCommand('shopahelper:link.category-to-products', 'BizMark\ShopaHelper\Console\Linkers\CategoryToProducts');
        $this->registerConsoleCommand('shopahelper:link.category-to-products-by-category', 'BizMark\ShopaHelper\Console\Linkers\CategoryToProductsByCategory');
        //// Additional categories
        $this->registerConsoleCommand('shopahelper:link.add-categories-to-products', 'BizMark\ShopaHelper\Console\Linkers\AddCategoriesToProducts');
        $this->registerConsoleCommand('shopahelper:link.add-category-to-products-by-add-category', 'BizMark\ShopaHelper\Console\Linkers\AddCategoryToProductsByAddCategory');
        $this->registerConsoleCommand('shopahelper:link.add-category-to-products-by-category', 'BizMark\ShopaHelper\Console\Linkers\AddCategoryToProductsByCategory');

        // Prices
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage', 'BizMark\ShopaHelper\Console\Prices\UpscalePriceByPercentage');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage', 'BizMark\ShopaHelper\Console\Prices\DownscalePriceByPercentage');
        //// By Brand
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-by-brand', 'BizMark\ShopaHelper\Console\Prices\UpscalePriceByPercentageByBrand');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage-by-brand', 'BizMark\ShopaHelper\Console\Prices\DownscalePriceByPercentageByBrand');
        //// By Category
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-by-category', 'BizMark\ShopaHelper\Console\Prices\UpscalePriceByPercentageByCategory');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage-by-category', 'BizMark\ShopaHelper\Console\Prices\DownscalePriceByPercentageByCategory');
        //// Custom
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-custom', 'BizMark\ShopaHelper\Console\Prices\UpscalePriceByPercentageCustom');

        // Setters
        $this->registerConsoleCommand('shopahelper:set.attribute', 'BizMark\ShopaHelper\Console\Setters\SetAttribute');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'BizMark\ShopaHelper\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'bizmark.shopahelper.some_permission' => [
                'tab' => 'ShopaHelper',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'shopahelper' => [
                'label'       => 'ShopaHelper',
                'url'         => Backend::url('bizmark/shopahelper/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bizmark.shopahelper.*'],
                'order'       => 500,
            ],
        ];
    }
}
