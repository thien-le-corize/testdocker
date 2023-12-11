<?php

namespace App\Http\Requests\ShopeeVoucher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class CreateShopeeVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable',
            'discount' => 'required|integer|max:100|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'description' => 'nullable',
            'type_reduction' => 'required|boolean',
            'max_value_reduction' => [Rule::requiredIf($this->input('type_reduction') == 1), 'numeric'],
            'usage_quantity' => 'nullable|integer',
            'min_price' => 'required|numeric',
            'rule' => 'nullable'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $startYear = $this->input('start_year');
            $endYear = $this->input('end_year');

            if ($endYear && $startYear > $endYear) {
                $validator->errors()->add('start_year', Lang::get('validation.start_year_smaller'));
            }
            
            $discount = $this->input('discount');

            $typeReduction = $this->input('type_reduction');

            $maxValueReduction = $this->input('max_value_reduction');

            $minPrice = $this->input('min_price');

            if($discount && $typeReduction && $maxValueReduction && $minPrice) {

                $valueAfterDiscount = ceil(($minPrice * $discount) / 100);
                
                if($valueAfterDiscount > $maxValueReduction) {

                    $valueDiscountSuggest = (
                        (
                            ($maxValueReduction / $minPrice*100) * $minPrice
                        ) / 100) > $maxValueReduction 
                    ? floor($maxValueReduction / $minPrice*100) 
                    : floor($maxValueReduction / $minPrice*100);

                    $maxValueReductionSuggest = $minPrice * $discount / 100;

                    $minPriceSuggest =  floor($maxValueReduction * 100/$discount);
                    
                    $validator->errors()->add('validation.all_value_suggest', Lang::get('validation.all_value_suggest', ['discount_suggest' => $valueDiscountSuggest, 'max_value_reduction_suggest' => $maxValueReductionSuggest, 'min_price_suggest' => $minPriceSuggest]));
                }
            }
        });
    }
}
