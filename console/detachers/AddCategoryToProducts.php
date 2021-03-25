<?php namespace BizMark\Shopahelper\Console\Detachers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Category;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddCategoryToProducts extends Command
{
    use DetachHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:detach.add-category-from-products';

    /**
     * @var string The console command description.
     */
    protected $description = 'Detaching additional categories from products by id\'s or array of id\'s ';

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

        $this->detachArrayOrSingle($obCategory, $this->argument('products'), Product::class, 'additional_category', true);
        $this->output->writeln('Detaching additional category from products successfully ended');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['category', InputArgument::REQUIRED, 'Additional Category ID'],
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
