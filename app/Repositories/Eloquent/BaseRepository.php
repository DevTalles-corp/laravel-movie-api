<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Model $model)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model {
        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(Model $model): void {
        $model->delete();
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(int $id): Model {
        return $this->model->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function update(Model $model, array $data): Model {
        $model->update($data);
        return $model->refresh();
    }
}
