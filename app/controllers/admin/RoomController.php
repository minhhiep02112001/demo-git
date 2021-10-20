<?php


namespace App\controllers\admin;


use App\core\Pagination;
use App\validate\UniqueEditValidate;
use App\validate\UniqueValidate;
use App\models\Room;
use Illuminate\Support\Str;
use Jenssegers\Blade\Blade;
use Rakit\Validation\Validator;

class RoomController
{
    function index()
    {
        $page = ($_REQUEST['page']) ?? 1;
        $limit = 10;
        $start = ( $page - 1 ) * $limit;
        $room = Room::offset($start)->limit($limit)->get();
        $total = Room::count();
        unset($_REQUEST['url'], $_REQUEST['page']);

        if (count($_REQUEST) > 0) {
            $param = "";
            foreach ($_REQUEST as $key => $value) {
                $param .= "&{$key}={$value}";
            }
        }

        $config = [
            'total' => $total,
            'limit' => 10,
            'url' => rtrim(url('room.index')->getPath(), '/'),
            'full' => false, //bỏ qua nếu không muốn hiển thị full page
            'param' => $param ?? ""
        ];

        $page = new Pagination($config);

        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.room.index', [
            'room' => $room,
            'page' => $page ,
            'start' => $start
        ]);

    }

    public function create()
    {
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.room.create');
    }

    public function store()
    {
        $validator = new Validator;
        $validator->addValidator('unique', new UniqueValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'title' => 'required|unique:room,title',
            'summary' => 'required',
            'details_description' => 'required',
            'image' => 'required|uploaded_file:0,500K,png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            $errors = [];
            $errors['old'] = input()->all();
            $error = $validation->errors();
            $errors['error'] = $error->firstOfAll();
            $_SESSION['validate_data'] = $errors;
            return redirect($_SERVER["HTTP_REFERER"]);
        }

        $data = input()->all(['title' , 'summary' , 'details_description']);

        if( input()->file('image', $defaultValue = null) != null){
            $image =  uploadImage(input()->file('image')->toArray() , './public/upload/room/');
        }
        $data['slug'] = Str::slug(input('title'));
        $data['image'] = $image??'';
        $data['active'] = input('active') ?? 0;
        $data['price'] = input('price') ?? 0;
        $data['status'] = input('status') ?? 0;
        $data['count_people'] = input('count_people') ?? 0;

        $room = Room::create($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('room.index'));
    }
    public function edit($id){
        $room = Room::find($id);
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.room.edit', [
            'room' => $room
        ]);
    }

    public function update($id){

        $room = Room::find($id);

        $validator = new Validator;
        $validator->addValidator('unique', new UniqueEditValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'title' => 'required|unique:room,title,'.$id,
            'summary' => 'required',
            'details_description' => 'required',
            'image' => 'nullable|uploaded_file:0,500K,png,jpg,jpeg',

        ]);

        if ($validation->fails()) {
            $errors = [];
            $errors['old'] = input()->all();
            $error = $validation->errors();
            $errors['error'] = $error->firstOfAll();
            $_SESSION['validate_data'] = $errors;
            return redirect($_SERVER["HTTP_REFERER"]);
        }
        $data = input()->all(['title' , 'summary' , 'details_description']);

        if( input()->exists('image') && input()->file('image')!=null){
            $image =  uploadImage(input()->file('image')->toArray() ,'./public/upload/room/');
            $data['image'] = $image;
            @unlink($room->image);

        }
        $data['slug'] = Str::slug(input('title'));
        $data['active'] = input('active') ?? 0;
        $data['count_people'] = input('count_people') ?? 0;
        $data['status'] = input('status') ?? 0;
        $data['price'] = input('price') ?? 0;

        $room->update($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('room.index'));
    }

    function destroy($id){
        $room = Room::find($id);
        $image = $room->image;
        if($room->delete()){
            @unlink($image);
            return response()->json(['status'=>'true'] , 200);
        }
        return response()->json(['status'=>'false'] , 500);
    }
}