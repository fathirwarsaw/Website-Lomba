<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Proses pengiriman email
    $to = 'alfatirruhollahramadhan@gmail.com'; // Ganti dengan alamat email Anda
    $subject = 'Pesan dari Formulir Kontak';
    $message_content = "
    Nama: $name\n
    Email: $email\n
    Pesan:\n$message
    ";

    // Headers untuk email
    $headers = "From: $name <$email>";

    // Kirim email
    if (mail($to, $subject, $message_content, $headers)) {
        // Jika pengiriman email berhasil
        $response = array(
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        );
    } else {
        // Jika pengiriman email gagal
        $response = array(
            'success' => false,
            'message' => 'Failed to send message. Please try again later.'
        );
    }

    // Kirim respons dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['description'];

    // Pengolahan file yang diunggah
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    // Lokasi penyimpanan file yang diunggah
    $upload_dir = 'uploads/';
    $target_file = $upload_dir . basename($file_name);

    // Pindahkan file yang diunggah ke lokasi yang ditentukan
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Jika pengiriman file berhasil, kirim email atau lakukan tindakan lainnya
        $to = 'alfatirruhollahramadhan@gmail.com'; // Ganti dengan alamat email tujuan
        $subject = 'New Assignment Submission';
        $message = "Name: $name\n";
        $message .= "Email: $email\n";
        $message .= "Description:\n$description\n";
        $message .= "File: $file_name";

        $headers = "From: $name <$email>";

        // Kirim email
        if (mail($to, $subject, $message, $headers)) {
            $response = array(
                'success' => true,
                'message' => 'Assignment submitted successfully!'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to send assignment. Please try again later.'
            );
        }
    } else {
        // Jika gagal memindahkan file
        $response = array(
            'success' => false,
            'message' => 'Failed to upload file. Please try again.'
        );
    }

    // Kirim respons dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
