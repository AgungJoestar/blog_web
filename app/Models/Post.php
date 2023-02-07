<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'title', 'content', 'slug', 'category', 'status'
    ];

    public $sortable = [
    	'id', 'title', 'status', 'category', 'created_at', 'updated_at'
    ];


    public function category(){
    	return $this->belongsTo(Category::class, 'category');
	}
}