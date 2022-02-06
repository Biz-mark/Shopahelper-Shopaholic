<?php namespace BizMark\ShopaHelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\PropertiesShopaholic\Classes\Item\PropertyValueItem;
use Lovata\PropertiesShopaholic\Models\PropertyValue;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GeneratePropertyValueCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.propertyvalues';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for property values';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('PropertyValue', PropertyValue::class, PropertyValueItem::class);
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
