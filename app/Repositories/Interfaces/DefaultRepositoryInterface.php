<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Resources\Json\JsonResource;

interface DefaultRepositoryInterface
{
    public function one(int $id);

    public function all();

    public function create(array $resource, array $students_ids = null);

    public function update(array $resource);

    public function delete(int $id);
}
