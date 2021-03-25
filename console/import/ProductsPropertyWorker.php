<?php namespace BizMark\ShopaHelper\Console\Import;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Lovata\PropertiesShopaholic\Models\Property;
use Lovata\PropertiesShopaholic\Models\PropertyValue;
use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Models\Product;
use System\Models\File;

class ProductsPropertyWorker extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:work.products.attributes';

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
        $reader = \League\Csv\Reader::createFromPath(storage_path('app/cables-attributes.csv'), 'r');

        /**
         * 0 ID
         * 1 Атрбиуты
         */

        $reader->setDelimiter(",");
        $reader->setEnclosure('"');
        $reader->setEscape('\\');
        $reader->setOffset(0);
        $contents = $reader->fetchAll();

        foreach ($contents as $key => $content){
            $this->output->writeln('========================================');
            if (!empty($content['0'])) {
                $product = Product::where('id', $content['0'])->first();
                if (empty($product)) {
                    $this->output->writeln('Product #' . $content['0'] . ' not found');
                    continue;
                } else {
                    $this->output->writeln('Product #' . $content['0']);
                }
            } else {
                $this->output->writeln('Row #' . $key . ' skipped');
                continue;
            }

            if (empty($content['1'])) {
                $this->output->writeln('Row #' . $key . ' skipped properties empty');
                continue;
            }

            if (strpos($content['1'], ';') !== false) {
                $source_properties = explode(';', $content['1']);
                foreach ($source_properties as $source_property) {
                    $this->output->writeln($source_property);
                    if (strpos($source_property, ':') !== false) {
                        $source_property = explode(':', $source_property);
                        if (!empty($source_property[0]) && !empty($source_property[1])){
                            $property = $this->getProperty($source_property[0], str_slug($source_property[0]));
                            $property_value = $this->getPropertyValue($property, $source_property[1]);

                            $this->output->writeln(sprintf("Assigning %s to %s", $property_value->value, $property->name));

                            $new_property = [$property->id => $property_value->value];
                            $existing_property = $product->property;
                            if (!empty($existing_property)){
                                $new_property = $existing_property + $new_property;
                            }

                            $product->property = $new_property;
                            $product->save();
                        }
                    }
                }
            }

            $product->save();
            $this->output->writeln('Product #'. $product->id .' successfully ended work');
        }

        $this->output->writeln('Successfully ended');
    }

    public function getProperty($name, $code)
    {
        $this->output->writeln('Getting property '.$name);
        $property = Property::where('name', $name)->first();
        if (empty($property)){
            $this->output->writeln('Creating new one with name '.$name);
            $property = new Property();
            $property->name = $name;
            $property->active = true;
            $property->slug = str_slug($code);
            $property->code = str_slug($code);
            $this->output->writeln('Saving property');
            $property->save();
        }
        return $property;
    }

    public function getPropertyValue(Property $property, $name)
    {
        $this->output->writeln('Getting value '.trim(str_slug($name)));
        $property_value = PropertyValue::where('slug', PropertyValue::getSlugValue($name))->first();
        if (empty($property_value)){
            $this->output->writeln('Creating new value '.trim(str_slug($name)));
            $property_value = new PropertyValue;
            $property_value->value = $name;
            $property_value->save();
        }
        $property->getPropertyVariants();
        $property_exist = $property->whereHas('property_value', function ($query) use ($property_value) {
            $query->where('value', $property_value->value);
        })->first();
        if (empty($property_exist)){
            $this->output->writeln('Property value doesn\'t have any property link');
            $property->property_value()->add($property_value);
            $property->save();
        }
        return $property_value;
    }

    public static function checkNull($var)
    {
        if ($var == 'NULL' || $var == 'null' || $var == ' ' || $var == ''){
            return NULL;
        }
        return $var;
    }
}