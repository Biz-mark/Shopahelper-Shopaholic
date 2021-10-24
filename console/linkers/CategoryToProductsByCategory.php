<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;
use Lovata\Shopaholic\Models\Category;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CategoryToProductsByCategory extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.category-to-products-by-category';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $obOldCategory = Category::active()->find($this->argument('old_category'));
        if (empty($obOldCategory)){
            $this->output->writeln(sprintf("Category with id %s not found", $this->argument('old_category')));
            return;
        }

        $obNewCategory = Category::active()->find($this->argument('new_category'));
        if (empty($obNewCategory)){
            $this->output->writeln(sprintf("Category with id %s not found", $this->argument('new_category')));
            return;
        }

        foreach ($obOldCategory->getAllChildrenAndSelf() as $obOldCategoryTree){
            if ($obOldCategoryTree->product->isNotEmpty()){
                foreach ($obOldCategoryTree->product as $obProduct){
                    $obProduct->category_id = $obNewCategory->id;
                    $obProduct->save();
                    $this->output->writeln(sprintf("Category #%s attached to product #%s", $obNewCategory->id, $obProduct->id));
                }
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
            ['old_category', InputArgument::REQUIRED, 'Old Category ID'],
            ['new_category', InputArgument::REQUIRED, 'New Category ID']
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
