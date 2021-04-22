<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:38
 */
namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface
{
    public function getOneById(int $id);

    public function getOneBySlug(string $slug);

    public function getAll();

    public function createCompany(array $data);

    public function updateCompany(array $data);

    public function deleteCompanyById(int $id);

    public function deleteCompanyBySlug(string $slug);

    public function generateAccessCode();
}
