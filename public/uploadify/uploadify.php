<?php

// Define a destination

$name_d = $request->input('name');
$verifyToken = md5('unique_salt' . $request->input('name'));
$token  = $request->input('token');

if (!empty($_FILES) && $token == $verifyToken) {

    $path = $request->input('path');
    $type = $request->input('type');
    $hash = $request->input('token');
    $s_id = $request->input('s_id');

    $schooltargetFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/' . $s_id; // Relative to the root

    $rtargetFolder = $schooltargetFolder . $path; // Relative to the root
//    $rtargetFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads' . $path; // Relative to the root
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