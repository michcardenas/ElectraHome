<?php
// app/Models/Section.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'page_id',
        'name',
        'title',
        'content',
        'images',
        'videos',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relación con Page
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Obtener array de imágenes
    public function getImagesArray()
    {
        if (empty($this->images)) return [];
        return explode(',', $this->images);
    }

    // Obtener array de videos
    public function getVideosArray()
    {
        if (empty($this->videos)) return [];
        return explode(',', $this->videos);
    }

    // Guardar array de imágenes como string
    public function setImagesArray($images)
    {
        $this->images = empty($images) ? null : implode(',', $images);
    }

    // Guardar array de videos como string
    public function setVideosArray($videos)
    {
        $this->videos = empty($videos) ? null : implode(',', $videos);
    }

    // Scope para obtener secciones activas ordenadas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}