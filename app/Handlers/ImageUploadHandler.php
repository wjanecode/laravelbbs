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
use Intervention\Image\Facades\Image;
class ImageUploadHandler{

    //允许上传的类型
    protected $allow_ext = ['gif','png','jpg','jpeg'];

    /**
     * 图片上传,返回转存后path路径
     * @param UploadedFile $file 文件
     * @param $folder 要保存的位置
     * @param $file_prefix 图片前缀
     * @param $max_width 限制最大宽度,默认不限制 int值
     *
     * @return array|bool
     * @throws Exception
     */
    public function upload(UploadedFile $file,$folder,$file_prefix,$max_width = false) {

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

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片,对保存的图片进行裁剪
            $this->reduceSize($path_name . '/' . $filename, $max_width);
        }

        //返回路径,保存到数据库给前端用的,不用绝对路径
        return [
          'path' => $folder_name.'/'.$filename,
        ];
    }

    /**
     * 对转存的图片进行裁剪
     * @param $file_path
     * @param $max_width
     */
    public function reduceSize($file_path,$max_width) {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();

    }
}
