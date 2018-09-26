<?php
/**
 * User: IGrock
 * Date: 21.04.2018
 * Time: 17:18
 */

namespace engine\Models;



class ImageUploadModel extends AbstractModel
{
    const WRONG_FILE_SIZE = 5;
    const WRONG_FILE_TYPE = 6;
    private $allowedImageTypes = ['image/png'];
    private $allowedSize = 3145728; // 3mb

    public function uploadFile($idProduct, $file, $fileDIR, $fileDBDir)
    {
        $checkFile = $this->checkFile($file);
        if (!$checkFile) return $checkFile;
        $filePaths = $this->prepareFilePaths($file, $fileDIR, $fileDBDir);
        return $this->uploadToDirAndInsertDB($filePaths, $idProduct, $file);
    }

    private function prepareFilePaths($file, $fileDIR, $fileDBDir)
    {
        $newName = uniqid('img_') . "." . pathinfo($file['name'])['extension'];
        $imgFullPath = $fileDIR . $newName;
        $imgDBPath = $fileDBDir . $newName;
        return [
            'imgFullPath' => $imgFullPath,
            'imgDBPath'   => $imgDBPath
        ];
    }

    private function checkFile($file)
    {
        if ($file['size'] > $this->allowedSize) {
            return self::WRONG_FILE_SIZE;
        }
        if (!in_array($file['type'], $this->allowedImageTypes)) {
            return self::WRONG_FILE_TYPE;
        }
        return true;
    }

    private function uploadToDirAndInsertDB(array $filePaths, $idProduct, $file)
    {
        $link = $this->db->connect();
        mysqli_begin_transaction($link);
        $result = $this->db->update('goods', ["img" => $filePaths['imgDBPath']], "id_product = $idProduct");
        if ($result) {
            if (move_uploaded_file($file['tmp_name'], $filePaths['imgFullPath'])) {
                mysqli_commit($link);
                $this->db->close();
                return true;
            }
        }
        return false;
    }


}