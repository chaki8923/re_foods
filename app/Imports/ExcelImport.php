<?php

namespace App\Imports;

use App\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubCategory([
            'api_id'=>$row['api_id'],
            'food_name'=>$row['food_name'],
            'parent_id'=>$row['parent_id']
        ]);
    }
}
