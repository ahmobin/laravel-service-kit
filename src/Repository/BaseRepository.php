<?php

namespace Mobin\LaravelServiceKit\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function firstOrNew(array $conditionalData, array $data): bool
    {
        $model = $this->model->firstOrNew($conditionalData);
        foreach ($data as $key => $val) {
            $model->{$key} = $val;
        }
        return $model->save();
    }

    public function update(array $data, $id): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    public function show($id): ?Model
    {
        return $this->model->find($id);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): BaseRepository
    {
        $this->model = $model;
        return $this;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function fetch(array $where, string $sortKey = 'id', string $order = 'ASC'): ?Model
    {
        return $this->model->where($where)
            ->orderBy($sortKey, $order)
            ->first();
    }

    public function find($booking_id): ?Model
    {
        return $this->model->find($booking_id);
    }

    public function findByKeyValue(string $key, $value): ?Model
    {
        return $this->model->where($key, $value)->first();
    }
}
