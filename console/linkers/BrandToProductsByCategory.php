<?php namespace BizMark\Shopahelper\Console\Linkers;

use Illuminate\Console\Command;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Models\Category;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BrandToProductsByCategory extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:link.brand-to-products-by-category';

    /**
     * @var string The console command description.
     */
    protected $description = 'Link brand to all products by given category id or array of id\'s and all of their children categories';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $obBrand = Brand::active()->find($this->argument('brand'));
        if (empty($obBrand)) {
            $this->output->writeln(sprintf("Brand with id %s not found", $this->argument('brand')));
            return;
        }

        if (strpos($this->argument('category'), ',') !== false){
            $arCategoriesID = explode(',', $this->argument('category'));
            $obCategories = Category::active()->whereIn('id', $arCategoriesID)->get();
            if ($obCategories->isNotEmpty()) {
                foreach ($obCategories as $obCategory) {
                    $this->output->writeln('Iterating category '. $obCategory->name. ' #'.$obCategory->id);
                    $this->iterateCategory($obCategory, $obBrand);
                }
            } else {
                $this->output->writeln('Categories with given array not found');
            }
        } else {
            $obCategory = Category::active()->find($this->argument('category'));
            if (empty($obCategory)) {
                $this->output->writeln(sprintf("Category with id %s not found", $this->argument('category')));
                return;
            }
            $this->output->writeln('Iterating category '. $obCategory->name. ' #'.$obCategory->id);
            $this->iterateCategory($obCategory, $obBrand);
        }

        $this->output->writeln('Brand linking successfully ended');
    }

    /**
     * @param Category $obCategory
     * @param Brand $obBrand
     */
    protected function iterateCategory($obCategory, $obBrand)
    {
        foreach ($obCategory->getAllChildrenAndSelf() as $obCategoryTree){
            if ($obCategoryTree->product->isNotEmpty()){
                foreach ($obCategoryTree->product as $obProduct){
                    if (empty($obProduct->brand)){
                        $obProduct->brand_id = $obBrand->id;
                        $obProduct->save();
                        $this->output->writeln(sprintf("Brand %s attached to product #%s", $obBrand->name, $obProduct->id));
                    } else {
                        $this->output->writeln(sprintf("Product already has brand %s", $obProduct->brand->name));
                    }
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['brand', InputArgument::REQUIRED, 'Brand ID'],
            ['category', InputArgument::REQUIRED, 'Category ID or ID\'s with comma']
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
