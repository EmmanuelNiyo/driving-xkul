<?php
header('Content-Type: application/json');
require('connection.inc.php');
require('functions.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $result = ['error' => FALSE, 'message' => 'Question Exam Created Successfully', 'error_msg' => ''];
    // echo json_encode($result);
    if (isset($_FILES['period_document'])) {

        $filename = $_FILES['period_document']['name'];

        // destination of the file on the server
        $destination = 'uploads/';

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $_FILES['period_document']['tmp_name'];
        $size = $_FILES['period_document']['size'];

        if (!in_array($extension, ['pdf'])) {
            $fdbk_msg = "You file extension must be .pdf only";
        } elseif ($_FILES['period_document']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
            $fdbk_msg = "File too large!";
        } else {
            $temp = explode(".", $_FILES["period_document"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            // move_uploaded_file($_FILES["period_document"]["tmp_name"], "../img/imageDirectory/" . $newfilename);
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination . $newfilename)) {
                $sql = "INSERT INTO `exam_period` VALUES (null,'" . get_safe_value($conn, $_POST["period"]) . "','" . $newfilename . "')";
                if ($conn->query($sql) === TRUE) {
                    $fdbk_msg = "Question Exam Period Successfully";
                }else {
                    $fdbk_msg = "Error on server";
                }
            } else {
                $fdbk_msg = "Failed to upload file.";
            }
        }
        header('location: create_period.php?fdbk=' . $fdbk_msg);
    } else {
        echo "iowo";
    }
}
