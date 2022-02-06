<?php namespace BizMark\ShopaHelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\PropertiesShopaholic\Classes\Item\PropertyItem;
use Lovata\PropertiesShopaholic\Models\Property;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GeneratePropertyCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.properties';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for properties';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('Property', Property::class, PropertyItem::class);
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
