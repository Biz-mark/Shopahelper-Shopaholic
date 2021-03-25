<?php namespace BizMark\ShopaHelper\Console\Linkers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Category;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddCategoriesToProducts extends Command
{
    use LinkHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.add-categories-to-products';

    /**
     * @var string The console command description.
     */
    protected $description = 'Linking additional categories to products by id\'s or array of id\'s ';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $obCategory = Category::active()->find($this->argument('category'));
        if (empty($obCategory)) {
            $this->output->writeln(sprintf("Category with id %s not found", $this->argument('category')));
            return;
        }

        $this->linkArrayOrSingle($obCategory, $this->argument('products'), Product::class, 'additional_category', true);
        $this->output->writeln('Additional category linking successfully ended');
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
