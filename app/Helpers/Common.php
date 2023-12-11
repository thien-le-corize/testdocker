<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use App\Exceptions\AuthenticateException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class Common
{
    const TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * bcSum
     *
     * @param array $arrayNumber;
     */
    public static function bcSum($arrayNumber)
    {
        $total = '0';
        foreach ($arrayNumber as $val) {
            $total = bcadd($total, $val, config('common.precision'));
        }
        return $total;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $latestRecord
     * @return array
     */
    public static function getNameDateLatestRecord($latestRecord)
    {
        $updatedAtLatest = null;
        $userUpdated = null;
        if ($latestRecord != null && $latestRecord->getAttributeValue('updated_at') != null && $latestRecord->getAttributeValue('updated_by') != null) {
            $updatedAtLatest = $latestRecord->getAttributeValue('updated_at')->format('Y/m/d H:i:s');
            $userUpdated = User::setEagerLoads([])->find($latestRecord->getAttributeValue('updated_by'))->getAttribute('name');
        }
        return [
            'user_updated' => $userUpdated,
            'updated_at_latest' => $updatedAtLatest,
        ];
    }

    /**
     * @param array $data
     * @param bool $createdBy
     * @return array|mixed
     */
    public static function getDataInsert($data, $createdBy = true)
    {
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        if ($createdBy) {
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();
        }

        return $data;
    }

        /**
     * @param array $data
     * @param bool $createdBy
     * @return array|mixed
     */
    public static function getDataUpdate($data, $createdBy = true)
    {
        $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        if ($createdBy) {
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();
        }

        return $data;
    }

    /**
     * @param string $pathImage
     * @param string $folder
     * @return string
     */
    public static function uploadImageWithCloudinary($pathImage, $folder)
    {
        try {
            return Cloudinary::upload(
                $pathImage,
                [
                    "folder" => $folder,
                    "overwrite" => TRUE,
                    "resource_type" => "auto"
                ]
            )->getSecurePath();

        } catch (\Throwable $e) {
            Log::error($e);
        }
    }

    /**
     * @param File $images
     * @param string $folder
     * @return array
     */
    public static function uploadMultiImage($images, $folder)
    {
        foreach ($images as $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = rand() . '' . time() . '.' . $extension;
            $image->move($folder, $filename);
            $image_path[] = $folder . $filename;
        }
        return $image_path;
    }


    /**
     * @param array $pathImages
     * @return array
     */
    public static function deleteImages($pathImages)
    {
        // dd(public_path());

        foreach ($pathImages as $pathImage) {
            if (File::exists(public_path($pathImage))) {
                File::delete(public_path($pathImage));
            }
        }
    }


    /**
     * Get array ids from request
     * @param \Illuminate\Support\Collection $request
     * @return array
     */
    public static function getArrIDInsert($request)
    {
        $qtyDataInsert = count($request->all()['data']);
        $arrID = [];
        $lastIDInsert = DB::getPdo()->lastInsertId();
        for ($i = 0; $i < $qtyDataInsert; $i++) {
            $arrID[] = $lastIDInsert - $i;
        }
        return $arrID;
    }

    public static function getStatusProductByRole()
    {
        $roleName = auth()->user()->getRelationValue('role')->name;
        $statusArray = config('common.product.status');
        return $roleName == Role::ROLE_ADMIN 
            ? array_intersect_key($statusArray, array_flip([Product::REVIEWING, Product::BANNED] ))
            : array_intersect_key($statusArray, array_flip([Product::ACTIVE, Product::INACTIVE, Product::SOLDOUT]));
    }

    public static function checkRoleAdmin()
    {
        $user = auth()->user(); 
        return optional($user)->getRelationValue('role')->name == Role::ROLE_ADMIN ? true : false;
    }
}
