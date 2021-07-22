<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Lesson;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function createComment(Request $request)
    {

       

        if(! $request->post('comment')) {
            Toastr::error('لطفا دیدگاه خود را وارد کنید', ' پیغام');
            return Redirect::back();
        }

        if($id = $request->post('lesson_id')) {
            $post = Lesson::query();
        }
        elseif($id = $request->post('blog_id')){
            $post = Blog::query();
        }elseif($id = $request->post('post_id')){
            $post = Post::query();
        }else{
            Toastr::error('خطا در دریافت اطلاعات', ' پیغام');
            return Redirect::back();

        }

        $model = $post->findOrFail($id);
        // dd($model);

       $comment = $model->comments()->create([
           'user_id' => getCurrentUser()->id,
           'comment' => $request->post('comment'),
            'parent_id' => $request->post('parent_id'),
            'approved' => getCurrentUser()->hasRole('admin') ? 1 : 0
        ]);

        if ($comment->approved) {
            Toastr::success('پیام شما با موفقیت منتشر شد', ' پیغام');

        }else{
            Toastr::info('نظر شما با موفقیت ارسال شد و پس از تایید در سایت قابل مشاهده خواهد بود', ' پیغام');

        }
        return Redirect::back();

    }

    public function upload(Request $request, $type, $name, $rules)
    {
        $date = date('Y');
        $request->validate([
            "file" => $rules
        ]);

        $imageName = $name . '.' . $request->file->extension();

        $request->file->move(public_path('uploads/' . $date . '/' . $type), $imageName);
        return 'uploads/' . $date . '/' . $type . '/' . $imageName;
    }

    public function upload_with_ftp($fileName, $type):string
    {

        try {
            $date = date('Y');

            $conn = ftp_connect(env('FTP_HOST'));
            $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
            ftp_set_option($conn, FTP_USEPASVADDRESS, false);
            ftp_pasv($conn, true);

            if (ftp_nlist($conn, 'public_html/uploads/' . $type . '/' . $date) == false) {
                ftp_mkdir($conn, 'public_html/uploads/' . $type . '/' . $date);
            }

            // if (in_array($fileName, ftp_nlist($conn, 'public_html/uploads/' . $type . '/' . $date))) {
            //     $this->delete_with_ftp('public_html/uploads/' . $type . '/' . $date . '/' . $fileName);
            // }

            ftp_put($conn, 'public_html/uploads/' . $type . '/' . $date . '/' . $fileName, $_FILES['file']['tmp_name'], FTP_BINARY);
            ftp_close($conn);
            return  env('DL_HOST_URL') . '/uploads/' . $type . '/' . $date . '/' . $fileName;
        } catch (\Throwable $th) {
            return '';
        }
    }
    public function delete_with_ftp($path)
    {

        $conn = ftp_connect(env('FTP_HOST'));
        $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
        ftp_set_option($conn, FTP_USEPASVADDRESS, false);
        ftp_pasv($conn, true);
        if (in_array(explode('/', $path)[6], ftp_nlist($conn, 'public_html/' . implode('/', [explode('/', $path)[3], explode('/', $path)[4],explode('/', $path)[5]])))) {
            ftp_delete($conn, $path);
        }

        ftp_close($conn);
        return  true;
    }

    public function sendSMS($patterncode, $phone, $data)
    {
        // $patterncode = '4ex85b2su5';

        // برای پیامک هنگام ثبت نام
        //$patterncode="g0mj7wtqv3";
        // $data = array("name" => "shahramp");
        //------------------------------
        // برای ارسال پیامک ثبت خرید اشتراک
        //$patterncode="97b8c9m9a5";
        //$data = array("name" => "نام طرف", "number" => "نام اشتراک");
        //-------------------------------
        // ویرایش اطلاعات پروفایل
        //$patterncode="nj36jd5q3c";
        //$data = array("name" => "نام طرف");
        //-------------------------------


        //$username = "khosravanihadi";
        //$password = 'Hk129837';
        $datas = array(
            "pattern_code" => $patterncode,
            "originator" => "+983000505",
            "recipient" => '+98' . substr($phone, 1),
            "values" => $data
        );
        // dd($datas);
        $url = "http://rest.ippanel.com/v1/messages/patterns/send";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: AccessKey -0E7gN8QTAM9VhfM5Vin5wCjpX5AHYn2a8P-J5Y4T5k='
        ));
        $response = curl_exec($handler);
        // dd($response);
    }

    protected function add_user_to_adobegroup($user_id, $group_id)
    {

        try {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init('http://online.techone24.com/api/xml?action=group-membership-update&group-id=' . $group_id . '&principal-id=' . $user_id . '&is-member=1');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);
            return $arr = json_decode(json_encode(simplexml_load_string($data)), true);
        } catch (\Exception $th) {
            throw $th;
        }
    }
    protected function create_user_in_adobe()
    {

        try {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init('http://online.techone24.com/api/xml?action=principal-update&first-name=' . str_replace(' ', '', getCurrentUser()->fname) . '&last-name=' . str_replace(' ', '', getCurrentUser()->lname) . '&has-children=0&login=' . getCurrentUser()->email . '&type=user');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            return $arr = json_decode(json_encode(simplexml_load_string($data)), true);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
