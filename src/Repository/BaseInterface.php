<?php

namespace Mobin\LaravelServiceKit\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function all(): Collection;

    public function create(array $data): Model;

    public function update(array $data, $id): bool;

    public function delete($id): bool;

    public function forceDelete($id): bool;

    public function show($id): ?Model;
}
