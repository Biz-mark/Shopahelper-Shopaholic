<?php namespace BizMark\Shopahelper\Console\Prices;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpscalePriceByPercentageByCategory extends Command
{
    use PriceHelper;
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:price.upscale-by-percentage-by-category';

    /**
     * @var string The console command description.
     */
    protected $description = 'Upscale price of products by percentage by brand';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('Starting of price upscaling');
        if ($this->argument('category_tree') == true) {
            $arProducts = ProductCollection::make()->category($this->argument('category'), true)->getIDList();
            $obProducts = Product::whereIn('id', $arProducts)->get();
        } else {
            $obProducts = Product::where('category_id', $this->argument('category'))->get();
        }

        foreach ($obProducts as $obProduct){
            foreach ($obProduct->offer as $obOffer){
                $this->upscalePricePercentage($obOffer);
            }
        }

        $this->output->writeln('Price upscaling by percentage ended successfully');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['percentage', InputArgument::REQUIRED, 'Percentage of scale'],
            ['category', InputArgument::REQUIRED, 'Category ID'],
            ['category_tree', InputArgument::REQUIRED, 'Process products from subcategories'],
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
