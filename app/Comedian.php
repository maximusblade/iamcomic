<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comedian extends Model
{

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'imported_comics_data';

    protected $primaryKey = 'id';
}
