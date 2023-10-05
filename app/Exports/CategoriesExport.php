<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class CategoriesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all();
    }
}
