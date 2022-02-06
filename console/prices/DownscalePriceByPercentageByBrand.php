<?php namespace BizMark\Shopahelper\Console\Prices;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DownscalePriceByPercentageByBrand extends Command
{
    use PriceHelper;
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:price.downscale-by-percentage-by-brand';

    /**
     * @var string The console command description.
     */
    protected $description = 'Downscale price of products by percentage by brand';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('Starting of price downscaling');
        $obProducts = Product::where('brand_id', $this->argument('brand'))->get();

        foreach ($obProducts as $obProduct){
            foreach ($obProduct->offer as $obOffer){
                $this->downscalePricePercentage($obOffer);
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
            ['brand', InputArgument::REQUIRED, 'Brand ID'],
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
