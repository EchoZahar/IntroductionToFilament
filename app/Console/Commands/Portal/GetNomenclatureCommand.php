<?php

namespace App\Console\Commands\Portal;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetNomenclatureCommand extends Command
{
    protected $signature = 'portal:getNomenclature';

    protected $description = 'Get new nomenclature from abs portal.';

    public array $warehouses = [];

    public function __construct()
    {
        parent::__construct();
        $this->warehouses = [1, 1165, 8, 9]; // 1 - STV, 1165 - KRD, 8 - RND, 9 - MSK
    }

    public function handle(): void
    {
        dd(DB::connection(env('PG_PORTAL_DB_CONNECTION'))->getDatabaseName(), $this->warehouses);
    }
}
