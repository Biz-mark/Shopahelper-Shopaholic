<?php namespace BizMark\Shopahelper\Console\Cache;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Classes\Item\CategoryItem;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateCategoriesCache extends Command
{
    use CacheHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:cache.categories';

    /**
     * @var string The console command description.
     */
    protected $description = 'Generate cache for categories';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->generateCache('Category', Category::class, CategoryItem::class);
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
