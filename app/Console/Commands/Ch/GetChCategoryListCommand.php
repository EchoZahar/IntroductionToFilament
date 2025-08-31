<?php

namespace App\Console\Commands\Ch;

use App\Methods\Ch\GetChCategoryPortalListMethod;
use Illuminate\Console\Command;
use App\Methods\Ch\GetChCategoryListMethod;
use App\Models\ChCategory;
use App\Models\ChPortalCategory;

class GetChCategoryListCommand extends Command
{
    protected $signature = 'ch:getCategoryList';

    protected $description = 'Get content hub category list.';

    public function handle(): void
    {
        $this->handleChPortalCategories();
        $this->handleChCategories();
    }

    private function handleChCategories(): void
    {
        $chCategoryList = (new GetChCategoryListMethod())->method();
        if (isset($chCategoryList->response)) {
            foreach ($chCategoryList->response as $item) {
                $portalCategory = ChPortalCategory::query()->where('ch_category_id', '=', $item->id)->first();
                if (!ChCategory::query()->where('id', '=', $item->id)->exists()) {
                    $covertToArray = explode(',', preg_replace('/[.!?\-_{}]/', '',  $item->portal_ids));
                    ChCategory::query()->updateOrCreate([
                        'id'        => $item->id,
                        'portal_id' => $portalCategory->portal_id ?? null
                    ], [
                        'name'              => $item->name,
                        'is_active_on_ch'   => $item->is_active,
                        'level'             => $item->level,
                        'portal_ids'        => $covertToArray
                    ]);
                }
            }
        }
    }

    private function handleChPortalCategories()
    {
        $chPortalCategoryList = (new GetChCategoryPortalListMethod())->method();
        if (isset($chPortalCategoryList->response)) {
            array_map(function ($portalCategory) {
                if (!is_null($portalCategory->local_category_id)) {
                    $portalCategory = ChPortalCategory::query()->updateOrCreate([
                        'ch_category_id' => $portalCategory->local_category_id,
                        'ch_portal_id'   => $portalCategory->local_portal_id
                    ], [
                        'portal_id'         => $portalCategory->portal_id,
                        'portal_parent_id'  => $portalCategory->portal_parent_id,
                        'portal_root_id'    => $portalCategory->portal_root_id,
                        'name'              => $portalCategory->local_category_name
                    ]);
                    // dd($portalCategory);
                }
            }, $chPortalCategoryList->response);
        }

    }
}
