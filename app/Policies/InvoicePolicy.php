<?php
namespace App\Policies;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Contract $contract): Response
    {
        // الشرط الأول: التأكد من الـ tenant_id
        if ($user->tenant_id !== $contract->tenant_id) {
            return Response::deny('هذا العقد لا ينتمي إلى مؤسستك.');
        }

        // الشرط الثاني: التأكد من حالة العقد
        if ($contract->status !== 'active') {
            return Response::deny('لا يمكن إضافة فواتير لعقد غير نشط.');
        }

        // لو كل الشروط تمام
        return Response::allow();
        return $user->tenant_id === $contract->tenant_id
        && $contract->status === 'active';
    }
    public function recordPayment(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->contract->tenant_id
        && $invoice->status !== 'cancelled';
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        //
    }
}
