<?php namespace BizMark\Shopahelper\Console\Prices;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Product;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpscalePriceByPercentage extends Command
{
    use PriceHelper;
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:price.upscale-by-percentage';

    /**
     * @var string The console command description.
     */
    protected $description = 'Upscale price of products by percentage';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->output->writeln('Starting of price upscaling');
        $obProducts = $this->prepareProducts($this->argument('products'));

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
            ['products', InputArgument::REQUIRED, 'Product ID or ID\'s with comma'],
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
