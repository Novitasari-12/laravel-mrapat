<?php 
namespace App\MyLibraries\RequestValidation;

use Illuminate\Support\Facades\Validator;

class RequestValidation extends Validator {
    /**
     * $data = [
     *  'request' => Request
     *  'rule' => [Valiadete Request Query]
     * ]
     * 
     * $callback = function($request){
     *  return ... ;
     * }
     * 
     * $err = function($err){
     *  return ... ;
     * }
     */
    public static function valid($data, $callback, $err){
        $valid = self::make($data['request']->all(), $data['rule']);
        if($valid->passes()){
            return $callback($data['request']) ;
        } else {
            return $err($valid->errors());
        }
    }

    /**
     * $data = [
     *  'request' => Request
     *  'rule' => [Valiadete Request Query]
     * ]
     * 
     * $callback = function($valid){
     *  return ... ;
     * }
     */
    public static function validRaw($data, $callback){
        $valid = self::make($data['request']->all(), $data['rule']);
        return $callback($valid);
    }

    /**
     * $request = Request 
     * 
     * $rule = [Validate Request Query]
     */
    public static function isValidate($request, $rule){
        $valid = self::make($request->all(), $rule);
        return $valid->passes();
    }

    /**
     * Note : using static 
     * public static $my_static = 'foo';
     * public function staticValue() {
     *      return self::$my_static;
     * }
     */


    public static function errMsg($err)
    {
        $err = json_encode($err);
        $errors = [];
        foreach (json_decode($err) as $key => $value) {
            $errors[] = $value[0];
        }
        return $errors;
    }
}