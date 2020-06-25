<?php
/**
 * Created by IntelliJ IDEA.
 * User: peyagodson
 * Date: 18.05.2018
 * Time: 17:37
 */

namespace App\Scope;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ReportScope implements Scope
{
    protected $par;


    public function __construct($param)
    {
        $this->par = $param;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        $builder->where($this->par,auth()->user()->id);
    }
}