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
    public function getAgreementBySlug(string $slug);

    public function all(bool $onlyActive);

    public function create(array $date);

    public function edit(string $slug);

    public function delete(string $slug);

    public function changeAgreementStatus(string $slug, int $statusId);
}
