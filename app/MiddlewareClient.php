<?php
/**
 * Created by IntelliJ IDEA.
 * User: Widya Rarasati
 * Date: 15/03/2017
 * Time: 8:07
 */

namespace App;

use App\Http\Controllers\Controller;

class MiddlewareClient
{
    private static $client = null;
    private static $MIDDLEWARE_URL = null;

    static function getBumn(){
        $response = self::getClient()->request('GET', self::getMiddlewareUrl().'/referensi-bumn');
         return json_decode($response->getBody(), true);
    }

    static function getUserProfile($username){
        $response = self::getClient()->request('GET', self::getMiddlewareUrl()."/user-profile/{$username}");
         return json_decode($response->getBody(), true);
    }

    static function getUser(){
        $response = self::getClient()->request('GET', self::getMiddlewareUrl()."/get-user");
         return json_decode($response->getBody(), true);
    }

    static function check($username, $kodeSso){
        $response = self::getClient()->request('POST',  env('MIDDLEWARE_CHECKER_URL', '')."/check", [
            'form_params' => [
                'username' => $username,
                'portal' => $kodeSso
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    static function getAsalInstansi($username){
        try{
            $response = MiddlewareClient::getUserProfile($username);
            if ($response['data']['kategori_user_id'] == 2){
                return $response['data']['bumn_singkat'];
            }
            return $response['data']['asal_instansi'];
        }catch(\Exception $e){
            return null;
        }
    }

    static function addUser($user){
        $response = self::getClient()->request('POST', self::getMiddlewareUrl()."/user-crud", [
            'form_params' => [
                'action' => 'insert',
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'handphone' => $user->handphone==null ? 0 : $user->handphone,
                'kategori_user_id' => env('MW_BUMN_USER_CATEGORY_ID', 2),
                'id_bumn' => $user->id_bumn
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    static function deleteUser($username){
        $response = self::getClient()->request('POST', self::getMiddlewareUrl()."/user-crud",[
            'form_params' => [
                'action' => 'delete',
                'username' => $username
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    private static function getClient()
    {
        if (is_null(self::$client))
            self::$client = new \GuzzleHttp\Client();
        return self::$client;
    }

    private static function getMiddlewareUrl(){
        if (is_null(self::$MIDDLEWARE_URL))
            self::$MIDDLEWARE_URL = env('MIDDLEWARE_CHECKER_URL', '').'/'.env('KODE_SSO', '');
        return self::$MIDDLEWARE_URL;
    }
}