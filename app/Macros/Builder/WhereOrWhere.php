<?php
namespace App\Macros\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class WhereOrWhere
{
    /**
     * Response macros.
     *
     * @var array
     */
    protected $macros;

    public function __construct()
    {
        $this->bind();
    }

    protected function bind()
    {
        Builder::macro('whereOrWhere', function ($attributes) {
            $this->where(function (Builder $query) use ($attributes) {
                $attributes = Arr::wrap($attributes);
                foreach ($attributes as $key => $value) {
                    if(is_array($value)){
                        $query->whereIn($key, $value);
                    }else{
                        $query->where($key, $value);
                    }
                }
            });
        
            return $this;
        });
    }
}
