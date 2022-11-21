<?php

namespace App\Services;
use App\Models\User;
use App\Services\Exceptions\TokenException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TokenService
{

    /**
     * if user has related apikey within valid period generate User model.
     *
     * @param string $apikey
     * @return User
     * @throws TokenException
     */
    public function getUserFromToken(string $apikey): User
    {
        $result = DB::table('users')
            ->join('api_apikey', 'users.id', '=', 'api_apikey.bearbeiter_id')
            ->join('vorgaben_zeitraum', 'api_apikey.zeitraum_id', '=', 'vorgaben_zeitraum.zeitraum_id')
            ->where('api_apikey.apikey', '=', $apikey)
            ->where('vorgaben_zeitraum.von', '<=', Carbon::now()->toDateTimeString())
            ->where('vorgaben_zeitraum.bis', '>=', Carbon::now()->toDateTimeString())
            ->select('api_apikey.ist_masterkey as isMaster', 'users.id as uid')
            ->get();

            if ($result->count() < 1) {
                throw new TokenException('token is invalid.');
            }

            $userResult = $result->first();

            $user = new User;

            $user->id = $userResult->uid;
            $user->master = $userResult->isMaster ?? false;

        return $user;
    }
}
