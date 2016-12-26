<?php

namespace App\Models;

use Czim\NestedModelUpdater\Data\UpdateResult;
use Czim\NestedModelUpdater\ModelUpdater;

class DeleteableUpdater extends ModelUpdater
{
    public function update(array $data, $model, $attribute = null, array $saveOptions = [])
    {
        if(isset($data['__delete__']) && $data['__delete__'])
        {
            if ( ! ($model instanceof Model)) {
                $model = $this->getModelByLookupAtribute($model, $attribute);
            }

            $model->delete();

            return with(new UpdateResult())->setModel($model);
        }

        return parent::update($data,$model,$attribute,$saveOptions);
    }
}