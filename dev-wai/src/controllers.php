<?php
require_once 'business.php';
require_once 'controller_utils.php';

function check_size(){
    if ($_FILES["fileToUpload"]["size"] > 1000000 || $_FILES["fileToUpload"]["size"] == 0) {
        return 1;
    }
    return 0;
}

function check_format(){
    $allowedFormats = array("jpg", "jpeg", "png");
    $allowedMimeTypes = array("image/jpeg", "image/png");

    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $fileMimeType = $_FILES['fileToUpload']['type'];

    if (!in_array($imageFileType, $allowedFormats)) {
        return 1;
    }
    else{
        if($fileMimeType){
            if(!in_array($fileMimeType, $allowedMimeTypes)) {
                return 1;
            }
        }
    }
    return 0;
}

function upload_conditions(){
    $sizeCheck = check_size();
    $formatCheck = check_format();
    $errors = [];

    if($sizeCheck !== 0) {
        $errors[] = "Plik jest zbyt duży.";
    }

    if($formatCheck !== 0) {
        $errors[] = "Nieprawidłowy format pliku.";
    }

    return $errors;
}

function get_original_image($fileMimeType, $targetFile){
    switch ($fileMimeType) {
        case 'image/jpeg':
            $originalImage = imagecreatefromjpeg($targetFile);
            break;
        case 'image/png':
            $originalImage = imagecreatefrompng($targetFile);
            break;
        default:
            http_response_code(415);
            return;
    }
    return $originalImage;
}

function make_thumb($targetFile, $targetDir, $name){
    $newWidth = 200;
    $newHeight = 125;

    $fileMimeType = $_FILES['fileToUpload']['type'];

    list($width, $height) = getimagesize($targetFile);
    $originalImage = get_original_image($fileMimeType, $targetFile);
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    

    switch ($fileMimeType) {
        case 'image/jpeg':
            imagecopyresampled($thumb, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($thumb, $targetDir . "miniature_" . $name);
            break;
        case 'image/png':
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            imagecopyresampled($thumb, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagepng($thumb, $targetDir . "miniature_" . $name);
            break;
        default:
            http_response_code(415);
            break;
    }
    imagedestroy($thumb);
    imagedestroy($originalImage);
}

function make_watermark($targetFile, $targetDir, $name) {
    $fileMimeType = $_FILES['fileToUpload']['type'];
    $originalImage = get_original_image($fileMimeType, $targetFile);

    if ($originalImage) {
        $black = imagecolorallocatealpha($originalImage, 0, 0, 0, 80);
        $text = $_POST["znak_wodny"];

        $path = '../web/static/arial.ttf';
        if (!file_exists($path)) {
            $path = "arial.ttf";
        }        

        switch ($fileMimeType) {
            case 'image/jpeg':
                imagettftext($originalImage, 35, 10, 100, 100, $black, $path, $text);
                imagejpeg($originalImage, $targetDir . "watermarked_" . $name);
                break;
            case 'image/png':
                imagealphablending($originalImage, false);
                imagesavealpha($originalImage, true);
                imagettftext($originalImage, 35, 10, 100, 100, $black, $path, $text);
                imagepng($originalImage, $targetDir . "watermarked_" . $name);
                break;
        }

        imagedestroy($originalImage);
    } else {
        http_response_code(404);
    }
}

function unique_name($name){
    if(!empty(get_image_by_name($name))){
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $filename = pathinfo($name, PATHINFO_FILENAME);

        $images = get_images();
        $count = 0;

        foreach ($images as $image) {
            if (strpos($image['name'], $filename) === 0) {
                $count++;
            }
        }
        if($count>0){
            $name = $filename . strval($count) . "." . $extension;
        }
        else{
            $name = $filename . $extension;
        }   
    }

    return $name;
}

function upload(&$model){
    $model['errors'] = [];
    $model['user'] = "";

    if (isset($_SESSION['user_id'])) {
        $model['user'] = get_user_name($_SESSION['user_id']);
    }

    $image = [
        '_id' => null,
        'name' => null,
        'title' => null,
        'author' => null,
        'visibility' => null,
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            if (!empty($_POST['title']) && !empty($_POST['author'])) {
                $uploadCondition = upload_conditions();

                if(empty($uploadCondition)) {
                    $targetDir = "static/images/";
                    $name = basename($_FILES["fileToUpload"]["name"]);
                    $name = unique_name($name);
                    $targetFile = $targetDir . $name;

                    $image = [
                        'name' => $name,
                        'title' => $_POST['title'],
                        'author' => $_POST['author'],
                        'visibility' => $_POST['visibility']
                    ];

                    upload_image($image);
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                    make_thumb($targetFile, $targetDir, $name);
                    make_watermark($targetFile, $targetDir, $name);
                    $uploadCondition[] = "Przesłano zdjęcie!";
                } 
                $model['errors'] = $uploadCondition;
            }
        }
        else{
            $uploadCondition = upload_conditions();
            $model['errors'] = $uploadCondition;
        }
    }
    return 'upload_view';
}

function add_to_saved($id, $name){

    if(!empty($id)){
        if(isID($id)){
            $saved = &get_saved();

            foreach ($saved as $id2) {
                if ($id2['id'] === $id) {
                    return 'redirect:' . $_SERVER['HTTP_REFERER'];
                }
            }
            
            $saved[] = ['id' => $id, 'name' => $name];
        }
        else{
            http_response_code(422);
        }
    }

    return 'redirect:' . $_SERVER['HTTP_REFERER'];
}

function isID($key){
    if (is_string($key) && strlen($key) === 24 && ctype_xdigit($key)) {
        return 1;
    }
    return 0;
}

function check_images($images){
    foreach ($images as $key => $image) {
        if ($image['visibility'] === 'private') {
            if (isset($_SESSION['user_id'])) {
                if($image['author'] !== get_user_name($_SESSION['user_id'])) {
                    unset($images[$key]);
                }
            }
            else{
                unset($images[$key]);
            }
        }
    }

    return $images;
}

function pagination(&$model, $images){
    $perPage = 2;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $totalImages = count($images);
    $totalPages = ceil($totalImages / $perPage);
    $start = ($page - 1) * $perPage;
    $paginatedImages = array_slice($images, $start, $perPage);

    foreach ($paginatedImages as &$image) {
        $image['path'] = 'static/images/miniature_'.$image['name'];
    }
    unset($image);

    $model['images'] = $paginatedImages;
    $model['currentPage'] = $page;
    $model['totalPages'] = $totalPages;
}

function gallery(&$model){
    $images = get_images();
    $images = check_images($images);    
    pagination($model, $images);

    $model['saved'] = &get_saved();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST as $id => $value) {
            if(isId($id)===1){
                add_to_saved($id, get_image_name($id));
            }
            else{
                http_response_code(404);
            }
        }
    }

    return 'gallery_view';
}

function image(&$model){
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        if(isID($id)){
            $image = get_image($id);
            if($image){
                if (isset($_SESSION['user_id'])){
                    $author = get_user_name($_SESSION['user_id']);
                    if ($image['author'] !== $author && $image['visibility'] === 'private') {
                        return 'redirect: gallery';
                    }
                    else{
                        if ($image = get_image($id)) {
                            $path = "static/images/watermarked_" . $image['name'];
                            $model['path'] = $path;
                            return 'image_view';
                        }
                    }
                }
                else{
                    if($image['visibility']=='private') {
                        return 'redirect: gallery';
                    }
                    else{
                        $path = "static/images/watermarked_" . $image['name'];
                        $model['path'] = $path;
                        return 'image_view';
                    }
                }
            }
        }
    }

    http_response_code(404);
    exit;
}

function login(&$model){
    if(isset($_SESSION['user_id'])) {
        return 'redirect: gallery';
    }

    $model['info'] = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];
    
        $user = get_user_by_login($login);
    
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['saved'] = [];
            $_SESSION['user_id'] = (string)$user['_id'];
            $model['info'] = "Zalogowano pomyślnie!";
        } else {
            $model['info'] = "Błędny login lub hasło!";
        }
    }
    return 'login_view';
}

function check_passwords($password, $confirmPassword){
    if ($password !== $confirmPassword) {
        return "Hasła się nie zgadzają!";
    }
    return 0;
}

function check_login_available($login){
    $existingUser = get_user_by_login($login);

    if ($existingUser) {
        return "Ten login jest zajęty!";
    }
    return 0;
}

function check_login_format($login) {
    if (preg_match('/[^a-zA-Z0-9]/', $login)) {
        return "Nieprawidłowy login!"; 
    }
    return 0;
}

function check_password_length($password) {
    if (strlen($password) < 8) {
        return "Wybierz dłuższe hasło!";
    }
    return 0;
}

function check_password_uppercase_letter($password) {
    if (!preg_match('/[A-Z]/', $password)) {
        return "Hasło musi mieć jedną dużą literę!";
    }
    return 0;
}

function check_password_char($password) {
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return "Hasło musi zawierać co najmniej jeden znak specjalny!";
    } 
    return 0;
}

function register_conditions($login, $password, $confirmPassword){
    if(check_login_available($login)!==0){
        return check_login_available($login);
    }

    if(check_login_format($login)!==0){
        return check_login_format($login);
    }
    
    if(check_passwords($password, $confirmPassword)!==0){
        return check_passwords($password, $confirmPassword);
    }

    if(check_password_length($password)!==0){
        return check_password_length($password);
    }

    if(check_password_uppercase_letter($password)!==0){
        return check_password_uppercase_letter($password);
    }

    if(check_password_char($password)!==0){
        return check_password_char($password);
    }
    
    return 0;
}

function register(&$model){
    if(isset($_SESSION['user_id'])){
        return 'redirect: gallery';
    }

    $model['info'] = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if(register_conditions($login,$password, $confirmPassword)!==0){
            $model['info'] = register_conditions($login,$password, $confirmPassword);
        }
        else{
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = [
                'email' => $email,
                'login' => $login,
                'password' => $hashedPassword
            ];

            add_user($user);
            $model['info'] = "Uzytkownik zarejestrowany pomyslnie!!";
        }
    }

    return 'register_view';
}

function logout(&$model){
    if(isset($_SESSION['user_id'])){
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']);
    }
    return 'redirect: gallery';
}

function delete_saved($id){
    $saved = &get_saved();

    foreach ($saved as $index => $imageID) {
        if ($imageID['id'] === $id) {
            unset($saved[$index]);
        }
    }
}

function saved(&$model){
    $images = &get_saved();

    pagination($model, $images);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST as $id => $value) { 
            if(isId($id)===1){
                delete_saved($id);
            }
            else{
                http_response_code(422);
            }
        }
        return 'redirect:saved';
    }

    return 'saved_view';
}

function search_image(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['query'])) {
            $search_query = $_POST['query'];
    
            if (!empty($search_query)) {
                $images = get_images();
                $images = check_images($images);
                $matchedImages = [];

                foreach ($images as $image) {
                    if (stripos($image['title'], $search_query) !== false) {
                        $matchedImages[] = $image;
                    }
                }

                if (!empty($matchedImages)) {
                    $html = '';
                    foreach ($matchedImages as $matchedImage) {
                        $html .= '<a href="show?id=' . $matchedImage['_id'] . '" target="_blank">';
                        $html .= '<img src="static/images/miniature_' . $matchedImage['name'] . '" alt="' . $matchedImage['title'] . '">';
                        $html .= '</a>';
                    }
                    $model['images'] = $html;
                } else {
                    $model['images'] = "Brak zdjęć o podanym tytule!";
                }
            } 
            else {
                $model['images'] = "";
            }
        }
    }
    else{
        return 'redirect:/';
    }
    return 'partial/search_image_view';
}

function search(&$model){
    return 'search_view';
}