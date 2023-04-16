<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if($method == 'PUT'){
            return [
                'name' => 'sometimes|required|max:255',
                'type' => 'sometimes|required|in:I,B,i,b', //only I or i is allowed for individual and B or b is allowed for business
                'email' => 'sometimes|required|email|max:255|unique:customers,email,'.$this->customer->id, // to ignore the current customer, .$this->customer->id 
                'address' => 'sometimes|required|max:255',
                'city' => 'sometimes|required|max:255',
                'state' => 'sometimes|required|max:255',
                'postal_code' => 'sometimes|required|max:10',
            ];
        }
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'postal_code'=>$this->postal_code
        ]);
    }
}
