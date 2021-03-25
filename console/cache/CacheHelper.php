<?php namespace BizMark\Shopahelper\Console\Cache;

trait CacheHelper
{
    /**
     * Processing cache of given model and ElementItem
     *
     * @param string $sName
     * @param string $obModel
     * @param string $obModelItem
     */
    function generateCache($sName, $obModel, $obModelItem)
    {
        $this->output->writeln('Generating ' . $sName . ' cache.');

        $iChunkCount = $obModel::active()->count();
        $iChunkCount = $iChunkCount / $this->argument('chunks');
        $iChunkCount = round($iChunkCount);

        $obModel::active()->chunk($iChunkCount, function($records) use ($obModelItem, $sName) {
            foreach ($records as $record) {
                $obModelItem::make($record->id);
                $this->output->writeln($sName . ' #' . $record->id . ' generated cache.');
            }
        });
    }
}