<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Category;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CategoryToProducts extends Command
{
    use LinkHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.category-to-products';

    /**
     * @var string The console command description.
     */
    protected $description = 'Link category to products by given id or array of id\'s';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $obCategory = Category::find($this->argument('category'));
        if (empty($obCategory)) {
            $this->output->writeln(sprintf("Category with id %s not found", $this->argument('category')));
            return;
        }

        $this->linkArrayOrSingle($obCategory, $this->argument('products'), Product::class, 'category_id');
        $this->output->writeln('Category linking successfully ended');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['category', InputArgument::REQUIRED, 'Category ID'],
            ['products', InputArgument::REQUIRED, 'Product ID or ID\'s with comma']
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
