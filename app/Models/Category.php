<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'slug',
        'name',
        'icon',
        'description',
    ];

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getApiResponseAttribute()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => asset($this->icon),
            'childs' => $this->child->pluck('api_response_child'),
            'childs' => $this->description,
            ];
}   

public function getApiResponseChildAttribute()
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description
            ];
}   

public function getApiResponseParentAttribute()
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent' => optional($this->parent)->api_response_child
            ];
}   
}



