<?php


namespace App\validate;


use Rakit\Validation\Rule;
use Illuminate\Database\Capsule\Manager as DB;
class UniqueValidate extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

//    protected $pdo;

    public function __construct( )
    {

    }
    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except AND $except == $value) {
            return true;
        }

        $count = DB::table($table)->where($column , $value)->count();

        return $count === 0 ;
    }
}