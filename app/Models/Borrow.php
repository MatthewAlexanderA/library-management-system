<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $table = 'borrows';
    protected $guarded = [];

    public function book() {
        return $this->belongsTo(Book::class, 'isbn', 'id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
