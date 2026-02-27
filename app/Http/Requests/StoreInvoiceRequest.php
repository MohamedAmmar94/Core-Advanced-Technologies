<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //policies or authentication
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function all($keys = null)
    {

        $data                = parent::all($keys);
        $data['contract_id'] = $this->route('contract')?->id ?? "";
        return $data;
    }
    public function rules(): array
    {
        return [
            'contract_id' => 'required|exists:contracts,id',
            'due_date'    => 'required|date',
        ];
    }
}
