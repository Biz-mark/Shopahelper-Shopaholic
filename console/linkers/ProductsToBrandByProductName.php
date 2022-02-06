<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;
use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProductsToBrandByProductName extends Command
{
    use LinkHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.products-to-brand-by-product-name';

    /**
     * @var string The console command description.
     */
    protected $description = 'Finding Brand name in the product name and linking product to it.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $sBrandName = trim($this->argument('brand'),'"');
        $obBrand = Brand::getByName($sBrandName)->first();
        if (empty($obBrand)) {
            $this->error(sprintf("Brand with name %s not found", $sBrandName));
            return;
        }
        $this->info('Brand #'.$obBrand->id);

        $this->info('Gathering products...');
        $obProductCollection = Product::select('id', 'name', 'brand_id')
            ->where('name', 'LIKE', '%'.$sBrandName.'%')
            ->get();

        $this->info('Found products: '.$obProductCollection->count());

        /** @var Product $obProduct */
        foreach ($obProductCollection as $obProduct) {
            $this->output->writeln('----------');
            $this->info('Product name:'.$obProduct->name);
            if (!empty($obProduct->brand)) {
                $this->info('Original brand: ' . $obProduct->brand->name);
            }
            $this->linkSlaveToMaster($obProduct, $obBrand, 'brand_id');
        }

        $this->output->writeln('----------');
        $this->info('Command executed successfully');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['brand', InputArgument::REQUIRED, 'Brand name needle']
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
