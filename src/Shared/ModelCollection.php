<?php

namespace Shared;

abstract class ModelCollection {

    /**
     * @var Model[]
     */
    private $models;

    /**
     * @var Model[] $models
     */
    public function __construct(array $models = [])
    {
        $this->models = $models;
    }

    /**
     * @param bool $withRelation
     * @return array
     */
    public function toArray(bool $withRelation = true){

    return array_map(function (Model $model) use($withRelation) {
            return $model->toArray($withRelation);
        }, $this->models ?? []);
    }
}