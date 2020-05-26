<?php
namespace App\Handlers;
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */
use Illuminate\Http\UploadedFile;
class ImageUploadHandler{

    //允许上传的类型
    protected $allow_ext = ['gif','png','jpg','jpeg'];

    /**
     * 图片上传,返回转存后path路径
     * @param UploadedFile $file 文件
     * @param $folder 要保存的位置
     * @param $file_prefix 图片前缀
     *
     * @return array|bool
     * @throws Exception
     */
    public function upload(UploadedFile $file,$folder,$file_prefix) {

        //保存的文件夹
        $folder_name = 'upload/images/'.$folder.'/'.date('Ym/d',time());

        //物理位置,php执行要知道,public文件夹的物理位置
        $path_name = public_path().'/'.$folder_name;

        //文件后缀
        $extension =strtolower($file->getClientOriginalExtension())? : 'png';//粘贴板的会没有后缀名

        //拼接文件名
        $filename = $file_prefix.'-'.date('H-i-s').random_int(1000,9999).'.'.$extension;

        if (! in_array($extension,$this->allow_ext)){
            return false;
        }

        //保存文件
        $file->move($folder_name,$path_name.'/'.$filename);

        //返回路径,保存到数据库给前端用的,不用绝对路径
        return [
          'path' => $folder_name.'/'.$filename,
        ];
    }
}
