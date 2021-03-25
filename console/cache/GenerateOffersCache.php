<?php namespace BizMark\Shopahelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Classes\Item\OfferItem;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateOffersCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.offers';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for offers';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('Offer', Offer::class, OfferItem::class);
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
