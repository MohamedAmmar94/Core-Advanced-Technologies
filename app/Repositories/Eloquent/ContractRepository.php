<?php
namespace App\Repositories\Eloquent;

use App\Models\Contract;
use App\Repositories\ContractRepositoryInterface;

class ContractRepository implements ContractRepositoryInterface
{
    public function findById(int $id): ?Contract
    {
        return Contract::find($id);
    }

    public function create(array $data): Contract
    {
        return Contract::create($data);
    }

    public function getByTenantId(int $tenantId): array
    {
        return Contract::where('tenant_id', $tenantId)->get()->all();
    }
}
