<?php namespace BizMark\Shopahelper;

use Backend;
use System\Classes\PluginBase;

/**
 * Shopahelper Plugin Information File
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['Lovata.Shopaholic'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Shopahelper',
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
        $this->registerConsoleCommand('shopahelper:cache.all', 'BizMark\Shopahelper\Console\Cache\GenerateCache');
        $this->registerConsoleCommand('shopahelper:cache.categories', 'BizMark\Shopahelper\Console\Cache\GenerateCategoriesCache');
        $this->registerConsoleCommand('shopahelper:cache.products', 'BizMark\Shopahelper\Console\Cache\GenerateProductsCache');
        $this->registerConsoleCommand('shopahelper:cache.offers', 'BizMark\Shopahelper\Console\Cache\GenerateOffersCache');
        $this->registerConsoleCommand('shopahelper:cache.brands', 'BizMark\Shopahelper\Console\Cache\GenerateBrandsCache');

        // Linkers
        //// Brands
        $this->registerConsoleCommand('shopahelper:link.brand-to-products', 'BizMark\Shopahelper\Console\Linkers\BrandToProducts');
        $this->registerConsoleCommand('shopahelper:link.brand-to-products-by-category', 'BizMark\Shopahelper\Console\Linkers\BrandToProductsByCategory');
        //// Categories
        $this->registerConsoleCommand('shopahelper:link.category-to-products', 'BizMark\Shopahelper\Console\Linkers\CategoryToProducts');
        $this->registerConsoleCommand('shopahelper:link.category-to-products-by-category', 'BizMark\Shopahelper\Console\Linkers\CategoryToProductsByCategory');
        //// Additional categories
        $this->registerConsoleCommand('shopahelper:link.add-categories-to-products', 'BizMark\Shopahelper\Console\Linkers\AddCategoriesToProducts');
        $this->registerConsoleCommand('shopahelper:link.add-category-to-products-by-add-category', 'BizMark\Shopahelper\Console\Linkers\AddCategoryToProductsByAddCategory');
        $this->registerConsoleCommand('shopahelper:link.add-category-to-products-by-category', 'BizMark\Shopahelper\Console\Linkers\AddCategoryToProductsByCategory');
        //// Products
        $this->registerConsoleCommand('shopahelper:link.products-to-brand-by-product-name', 'BizMark\Shopahelper\Console\Linkers\ProductsToBrandByProductName');

        // Detachers
        //// Additional categories
        $this->registerConsoleCommand('shopahelper:detach.add-category-from-products', 'BizMark\Shopahelper\Console\Detachers\AddCategoryToProducts');

        // Prices
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage', 'BizMark\Shopahelper\Console\Prices\UpscalePriceByPercentage');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage', 'BizMark\Shopahelper\Console\Prices\DownscalePriceByPercentage');
        //// By Brand
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-by-brand', 'BizMark\Shopahelper\Console\Prices\UpscalePriceByPercentageByBrand');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage-by-brand', 'BizMark\Shopahelper\Console\Prices\DownscalePriceByPercentageByBrand');
        //// By Category
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-by-category', 'BizMark\Shopahelper\Console\Prices\UpscalePriceByPercentageByCategory');
        $this->registerConsoleCommand('shopahelper:price.downscale-by-percentage-by-category', 'BizMark\Shopahelper\Console\Prices\DownscalePriceByPercentageByCategory');
        //// Custom
        $this->registerConsoleCommand('shopahelper:price.upscale-by-percentage-custom', 'BizMark\Shopahelper\Console\Prices\UpscalePriceByPercentageCustom');

        // Setters
        $this->registerConsoleCommand('shopahelper:set.attribute', 'BizMark\Shopahelper\Console\Setters\SetAttribute');
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
            'BizMark\Shopahelper\Components\MyComponent' => 'myComponent',
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
                'tab' => 'Shopahelper',
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
                'label'       => 'Shopahelper',
                'url'         => Backend::url('bizmark/shopahelper/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bizmark.shopahelper.*'],
                'order'       => 500,
            ],
        ];
    }
}
