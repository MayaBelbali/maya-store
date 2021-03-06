<?php


namespace App\Http\Views\Composers;


use App\Models\Brand;
use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view): View
    {
            $main_cats = cache()->remember('categoryCache', 60 * 60 * 24 * 30, static function () {
                return Category::whereNull('category_id')->orderBy('name','asc')->get(['id','name']);
            });

        return $view->with(['main_cats'=>$main_cats]);
    }
}
