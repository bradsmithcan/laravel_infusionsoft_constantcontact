<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\UserService;

class MediaUploader extends Controller
{
    /*
     * media uploading class for uploadify
     */

    public function upload(){

        // Define a destination
        $name_d = '';
        if (isset($_POST['name'])) {
            $name_d = $_POST['name'];
        }
        if (isset($_POST['timestamp'])) {
            $verifyToken = md5('unique_salt' . $_POST['timestamp']);
        } else {
            header("location: http://" . $_SERVER['HTTP_HOST']);
            exit;
        }
        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            $path = $_REQUEST['path'];
            $type = $_REQUEST['type'];
            $hash = $_REQUEST['token'];
            $s_id = $_REQUEST['s_id'];

            $schooltargetFolder = 'uploads/' . $s_id; // Relative to the root

            $rtargetFolder = $schooltargetFolder . $path; // Relative to the root
            $ctargetFolder = '/uploads/' . $s_id . $path; // Relative to the root
            if (!is_dir($schooltargetFolder)) {
                @mkdir($schooltargetFolder, 0777);
                @chmod($schooltargetFolder, 0777);
                json_encode("directory_created" . $schooltargetFolder);
            }
            if (!is_dir($rtargetFolder)) {
                @mkdir($rtargetFolder, 0777);
                @chmod($schooltargetFolder, 0777);
                json_encode("directory_created" . $rtargetFolder);
            }

            $targetFolder = $rtargetFolder . '/' . $type; // Relative to the root
            $ftargetFolder = $ctargetFolder . '/' . $type; // Relative to the root

            if (!is_dir($targetFolder)) {
                @mkdir($targetFolder, 0777);
                @chmod($schooltargetFolder, 0777);
            }

            $is_img = 2;
            $is_vid = 2;
            $is_audio = 2;
            $is_doc = 2;
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg','png', 'JPG', 'JPEG', 'PNG',); // File extensions

            if ($type == 'image') {
                $is_img = 1;
            } elseif ($type == 'doc') {
                $is_doc = 1;
            } elseif ($type == 'audio') {
                $is_audio = 1;
            } else {
                $is_vid = 1;
            }
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $targetFolder;

            $replace_arr = array(' ', '%', '_', '-', '+');
            $file_name = str_replace($replace_arr, '-', $fileParts['filename']) . '_' . time() . '_' . rand(0, 5000) . '.' . $fileParts['extension'];
            $targetFile = rtrim($targetPath, '/') . '/' . $file_name;
            $filePath = rtrim($ftargetFolder, '/') . '/' . $file_name;
            if (in_array($fileParts['extension'], $fileTypes)) {
                if (move_uploaded_file($tempFile, $targetFile)) {
                    echo ($filePath);
                } else {
                    echo json_encode('2');
                }
            } else {
                echo json_encode('Invalid file type.');
            }
        }

    }
}
