<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 14/03/2021
 * Time: 20:37
 */

namespace App\Repositories;

use App\Models\University;
use App\Repositories\Interfaces\UniversityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniversityRepository implements UniversityRepositoryInterface
{

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function one(string $slug)
    {
        $university = University::where('slug', $slug)->first();

        if(!empty($university)) {
            return $university;
        }

        return null;
    }

    public function all()
    {
        return University::all();
    }

    public function create(array $data)
    {
        DB::transaction(
            function () use ($data) {
                $university = new University();
                $university->name = $data['name'];
                $university->university_type_id = $data['university_type_id'];
                $university->city_id = $data['city_id'];
                $university->street = $data['street'];
                $university->street_number = $data['street_number'];
                $university->email = $data['email'];
                $university->phone = $data['phone'];
                $university->website = $data['website'];
                $university->access_code = $data['access_code'];
                $university->slug = Str::slug($data['name']);
                $university->created_at = Carbon::today();
                $university->updated_at = Carbon::today();
                $university->save();

                return $university;
            }
        );

        return null;
    }

    public function update(array $data)
    {
        DB::transaction(
            function () use ($data) {
                $university = new University();
                $university->name = $data['name'];
                $university->university_type_id = $data['university_type_id'];
                $university->city_id = $data['city_id'];
                $university->street = $data['street'];
                $university->street_number = $data['street_number'];
                $university->email = $data['email'];
                $university->phone = $data['phone'];
                $university->website = $data['website'];
                $university->access_code = $data['access_code'];
                $university->slug = Str::slug($data['name']);
                $university->created_at = Carbon::today();
                $university->updated_at = Carbon::today();
                $university->save();

                return $university;
            }
        );

        return null;
    }

    public function delete(int $id): bool
    {
        $university = University::find($id);

        if ($university->delete()) {
            return true;
        }

        return false;
    }
}
