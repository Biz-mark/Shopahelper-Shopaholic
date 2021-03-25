<?php namespace BizMark\Shopahelper\Console\Setters;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetAttribute extends Command
{
    use AttributeHelper;

    /**
     * @var string The console command name.
     */
    protected $name = 'shopahelper:set.attribute';

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
        $this->output->writeln('Setting attribute '.$this->argument('attribute_name'));
        $this->setAttribute(
            $this->argument('model'),
            $this->argument('attribute_name'),
            $this->argument('attribute_value'),
            $this->argument('ids')
        );
        $this->output->writeln('Setting completed successfully');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Model'],
            ['attribute_name', InputArgument::REQUIRED, 'Attribute'],
            ['attribute_value', InputArgument::REQUIRED, 'Attribute'],
            ['ids', InputArgument::REQUIRED, 'Values array by comma'],
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
