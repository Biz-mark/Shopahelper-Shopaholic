<?php namespace BizMark\ShopaHelper\Console\Import;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Lovata\PropertiesShopaholic\Models\Property;
use Lovata\PropertiesShopaholic\Models\PropertyValue;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use System\Models\File;

class ProductsWorker extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:work.products';

    /**
     * @var string The console command description.
     */
    protected $description = 'Working on products';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $reader = \League\Csv\Reader::createFromPath(storage_path('app/1.csv'), 'r');

        /**
         * 0 Арткул
         * 1 Код
         * 2 Название
         */

        $reader->setDelimiter(";");
        $reader->setEnclosure('"');
        $reader->setEscape('\\');
        $reader->setOffset(1);
        $contents = $reader->fetchAll();

        foreach ($contents as $key => $content){
            $this->output->writeln('========================================');
            if (!empty($content['1'])) {
                $product = Product::where('code', $content['1'])->first();
                if (empty($product)) {
                    $this->output->writeln('Product #' . $content['1'] . $content['2'] . ' not found');
                    continue;
                } else {
                    $this->output->writeln('Product #' . $content['1'] . $content['2']);
                }
            } else {
                $this->output->writeln('Row #' . $key . ' skipped');
                continue;
            }

            if (!empty($content['0'])) {
                $product->code = trim($content['0']);
            }

            $product->save();
            $this->output->writeln('Product #'. $product->id .' successfully ended work');
        }

        $this->output->writeln('Successfully ended');
    }

    public static function checkNull($var)
    {
        if ($var == 'NULL' || $var == 'null' || $var == ' ' || $var == ''){
            return NULL;
        }
        return $var;
    }
}