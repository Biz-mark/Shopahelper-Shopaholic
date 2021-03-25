<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BrandToProducts extends Command
{
    use LinkHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.brand-to-products';

    /**
     * @var string The console command description.
     */
    protected $description = 'Link brand to specific product or products by id or array of id\'s';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $obBrand = Brand::active()->find($this->argument('brand'));
        if (empty($obBrand)) {
            $this->output->writeln(sprintf("Brand with id %s not found", $this->argument('brand')));
            return;
        }

        $this->linkArrayOrSingle($obBrand, $this->argument('products'), Product::class, 'brand_id');
        $this->output->writeln('Brand linking successfully ended');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['brand', InputArgument::REQUIRED, 'Brand ID'],
            ['products', InputArgument::REQUIRED, 'Product ID or ID\'s with comma']
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
