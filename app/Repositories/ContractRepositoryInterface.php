<?php
namespace App\Repositories;

use App\Models\Contract;

interface ContractRepositoryInterface
{
    public function findById(int $id): ?Contract;

    public function create(array $data): Contract;

    public function getByTenantId(int $tenantId): array;
}
