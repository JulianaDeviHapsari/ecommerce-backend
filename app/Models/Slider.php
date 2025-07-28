public function getApiResponseAttribute()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'link' => $this->link,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return null;
        }
        return asset('storage/' . $this->image);
    }
}