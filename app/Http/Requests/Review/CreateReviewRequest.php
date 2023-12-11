<?php

namespace App\Http\Requests\Review;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class CreateReviewRequest extends FormRequest
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
        $rules = [];

        foreach ($this->get('data') as $key => $value) {
            $rules['data.' . $key . '.rating'] = 'nullable|integer|in:1,2,3,4,5';
            $rules['data.' . $key . '.comment'] = 'nullable|string';
            $rules['data.' . $key . '.product_id'] = 'required|integer|exists:products,id';
            // $rules['data.' . $key . '.user_id'] = 'required|integer|exists:users,id';
        }

        return $rules;
    }

    // public function withValidator(Validator $validator)
    // {
    //     $validator->after(function ($validator) {
    //         $startYear = $this->input('start_year');
    //         $endYear = $this->input('end_year');

    //         if ($endYear && $startYear > $endYear) {
    //             $validator->errors()->add('start_year', Lang::get('validation.start_year_smaller'));
    //         }
            
    //         $discount = $this->input('discount');

    //         $typeReduction = $this->input('type_reduction');

    //         $maxValueReduction = $this->input('max_value_reduction');

    //         $minPrice = $this->input('min_price');

    //         if($discount && $typeReduction && $maxValueReduction && $minPrice) {

    //             $valueAfterDiscount = ceil(($minPrice * $discount) / 100);
                
    //             if($valueAfterDiscount > $maxValueReduction) {

    //                 $valueDiscountSuggest = (
    //                     (
    //                         ($maxValueReduction / $minPrice*100) * $minPrice
    //                     ) / 100) > $maxValueReduction 
    //                 ? floor($maxValueReduction / $minPrice*100) 
    //                 : floor($maxValueReduction / $minPrice*100);

    //                 $maxValueReductionSuggest = $minPrice * $discount / 100;

    //                 $minPriceSuggest =  floor($maxValueReduction * 100/$discount);
                    
    //                 $validator->errors()->add('validation.all_value_suggest', Lang::get('validation.all_value_suggest', ['discount_suggest' => $valueDiscountSuggest, 'max_value_reduction_suggest' => $maxValueReductionSuggest, 'min_price_suggest' => $minPriceSuggest]));
    //             }
    //         }
    //     });
    // }
}
