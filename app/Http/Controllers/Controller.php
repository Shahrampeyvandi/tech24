<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

    public function upload_with_ftp($fileName, $type)
    {
        try {
            $date = date('Y');

            $conn = ftp_connect(env('FTP_HOST'));
            $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
            ftp_set_option($conn, FTP_USEPASVADDRESS, false);
            ftp_pasv($conn, true);
            if (ftp_nlist($conn, $type . '/' . $date) == false) {
                ftp_mkdir($conn, $type . '/' . $date);
            }
            ftp_put($conn, $type . '/' . $date . '/' . $fileName, $_FILES['file']['tmp_name'], FTP_BINARY);
            ftp_close($conn);
            return  env('DL_HOST_URL') . '/uploads/' . $type . '/' . $date . '/' . $fileName;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
