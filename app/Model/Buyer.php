<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model
{
    function transaction(){
        return $this->HasMany(Transaction::class);
    }
}
