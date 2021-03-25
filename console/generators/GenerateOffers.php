<?php namespace BizMark\Shopahelper\Console\Generators;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Classes\Item\BrandItem;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Models\Product;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateOffers extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:generate.offers';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate offers to products';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $products = Product::whereDoesntHave('offer')->get();
        foreach ($products as $product) {
            $offer = new Offer();
            $this->output->writeln('#'.$product->id);
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['chunks', InputArgument::REQUIRED, 'How many chunks of each collection to iterate. (2, 3, 4 and etc.)'],
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
