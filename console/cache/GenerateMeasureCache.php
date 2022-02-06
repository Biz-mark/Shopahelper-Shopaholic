<?php namespace BizMark\ShopaHelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Classes\Item\MeasureItem;
use Lovata\Shopaholic\Models\Measure;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateMeasureCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.measure';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for measures';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('Measure', Measure::class, MeasureItem::class);
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
