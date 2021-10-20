<?php


namespace App\validate;


use Illuminate\Database\Capsule\Manager as DB;
use Rakit\Validation\Rule;

class UniqueEditValidate extends Rule
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


//    if ($except AND $except == $value) {
//        return true;
//    }

    // do query
    $count = DB::table($table)->where($column , $value)->where('id' , '!=' , $except)->count();
//        $stmt = $this->pdo->prepare("select count(*) as count from `{$table}` where `{$column}` = :value");
//        $stmt->bindParam(':value', $value);
//        $stmt->execute();
//        $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // true for valid, false for invalid
    // return intval($data['count']) === 0;


    return $count === 0 ;
}
}