<?php namespace BizMark\ShopaHelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\PropertiesShopaholic\Classes\Item\PropertySetItem;
use Lovata\PropertiesShopaholic\Models\PropertySet;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GeneratePropertySetCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.propertysets';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for property sets';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('PropertySet', PropertySet::class, PropertySetItem::class);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
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
