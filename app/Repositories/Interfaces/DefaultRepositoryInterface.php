<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Resources\Json\JsonResource;

interface DefaultRepositoryInterface
{
    public function one(int $id);

    public function all();

    public function update(array $data);

    public function delete(int $id);
}
