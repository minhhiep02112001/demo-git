<?php


namespace App\controllers\admin;


use App\core\Pagination;
use App\validate\UniqueEditValidate;
use App\validate\UniqueValidate;
use App\models\Article;
use App\models\Customer;
use Illuminate\Support\Str;
use Jenssegers\Blade\Blade;
use Rakit\Validation\Validator;

class ArticleController
{
    function index()
    {
        $page = ($_REQUEST['page']) ?? 1;
        $limit = 10;
        $start = ( $page - 1 ) * $limit;
        $article = Article::offset($start)->limit($limit)->get();
        $total = Article::count();
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
            'url' => rtrim(url('article.index')->getPath(), '/'),
            'full' => false, //bỏ qua nếu không muốn hiển thị full page
            'param' => $param ?? ""
        ];

        $page = new Pagination($config);

        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.article.index', [
            'article' => $article,
            'page' => $page,
            'start' => $start
        ]);

    }

    public function create()
    {
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.article.create');
    }

    public function store()
    {

        $validator = new Validator;
        $validator->addValidator('unique', new UniqueValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'title' => 'required|unique:article,title',
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
            $image =  uploadImage(input()->file('image')->toArray() , './public/upload/article/');
        }
        $data['slug'] = Str::slug(input('title'));
        $data['image'] = $image??'';
        $data['active'] = input('active') ?? 0;
        $data['is_hot'] = input('is_hot') ?? 0;

        $article = Article::create($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('article.index'));
    }

    public function edit($id)
    {
        $article = Article::find($id);
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.article.edit', [
            'article' => $article
        ]);
    }

    public function update($id)
    {

        $article = Article::find($id);

        $validator = new Validator;
        $validator->addValidator('unique', new UniqueEditValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'title' => 'required|unique:article,title,'.$id,
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

        if( input()->exists('image')){
            $image =  uploadImage(input()->file('image')->toArray() ,'./public/upload/article/');
            $data['image'] = $image;
            @unlink($article->image);
        }
        $data['slug'] = Str::slug(input('title'));
        $data['active'] = input('active') ?? 0;
        $data['is_hot'] = input('is_hot') ?? 0;
        $article->update($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('article.index'));
    }

    function destroy($id){
        $customer = Article::find($id);
        $image = $customer->image;
        if($customer->delete()){
            @unlink($image);
            return response()->json(['status'=>'true']);
        }
        return response()->json(['status'=>'false']);
    }
}