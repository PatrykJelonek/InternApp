<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 05/04/2021
 * Time: 19:04
 */
namespace App\Repositories\Interfaces;

interface AgreementRepositoryInterface
{
    public function one(string $slug);

    public function all(bool $onlyActive);

    public function create();

    public function edit(string $slug);

    public function delete(string $slug);
}
