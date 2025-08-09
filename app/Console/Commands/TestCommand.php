<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOption\None;

class TestCommand extends Command
{
    protected $signature = 'app:test';

    protected $description = 'Command description';

    public function handle()
    {
        $studName = 'Petrov,Ivanov,Sidorov';
        $studScores = '50,60,80';
        $this->processingInputLines($studScores, $studName);

    }

    public function processingInputLines(string $inputScores, string $inputNames)
    {
        $keys = explode(',', $inputScores);
        $values = explode(',', $inputNames);
        $toArray = array_combine($keys, $values);
        $lowScope = [];
        foreach ($toArray as $key => $name) {
            if ($key >= 39 and $key < 70) {
                $lowScope[] = $name;
            }
        }
        echo trim(implode(PHP_EOL, $lowScope), " \%");
    }
}
