<?php

namespace App\Imports;

use App\User;
use Modules\Admin\Models\PharmacyList;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportData implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
	//return $row;

//	return $row;

        return new PharmacyList([
            'name' => $row[0]
        ]);
    }
}
