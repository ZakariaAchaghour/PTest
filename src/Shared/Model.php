<?php

namespace Shared;

interface Model {

    /**
     * @param bool $withRelation
     * @return array
     */
    public function toArray(bool $withRelation);
}