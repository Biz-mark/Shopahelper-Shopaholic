<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Models\Category;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddCategoryToProductsByAddCategory extends Command
{
    use LinkHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.add-category-to-products-by-add-category';

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
        $obCurrentCategory = Category::find($this->argument('current_category'));
        if (empty($obCurrentCategory)) {
            $this->output->writeln(sprintf("Current category with id %s not found", $this->argument('current_category')));
            return;
        }

        $obTargetCategory = Category::find($this->argument('target_category'));
        if (empty($obTargetCategory)) {
            $this->output->writeln(sprintf("Target category with id %s not found", $this->argument('target_category')));
            return;
        }

        if (!empty($obCurrentCategory->product_link)){
            foreach ($obCurrentCategory->product_link as $obProduct) {
                $this->linkSlaveToManyMaster($obProduct, $obTargetCategory, 'additional_category');
            }
        }

        $this->output->writeln('Category linking successfully ended');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['target_category', InputArgument::REQUIRED, 'Target category ID'],
            ['current_category', InputArgument::REQUIRED, 'Current category ID']
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
