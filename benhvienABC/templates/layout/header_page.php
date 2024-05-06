<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title><?php echo !empty($data['pageTitle'])? $data['pageTitle']:'Quản lý người dùng' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES;?>/css/custom.css?ver="<?php echo rand() ?>>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"> -->
</head>
<body>
    
</body>
</html>

<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="?module=home&action=dashboard" class="nav-link px-2 link-secondary">Dash board</a></li>
          <li><a href="?module=users&action=index" class="nav-link px-2 link-body-emphasis">Quản lý người dùng</a></li>
          <li><a href="?module=nhanvien&action=index" class="nav-link px-2 link-body-emphasis">Nhân viên y tế</a></li>
          <li><a href="?module=benhnhan&action=index" class="nav-link px-2 link-body-emphasis">Bệnh nhân</a></li>
          <li><a href="?module=donthuoc&action=index" class="nav-link px-2 link-body-emphasis">Đơn thuốc</a></li>
          <li><a href="?module=qlythuoc&action=index" class="nav-link px-2 link-body-emphasis">Quản lý thuốc</a></li>        
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://avatars.githubusercontent.com/u/164448690?v=4" alt="mdo" width="32" height="32" class="rounded-circle">

          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="?module=auth&action=logout">Đăng xuất</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <div class="container">

    <?php
    // show page title
    echo "<div class='page-header'>
                <h1>{$page_title}</h1>
            </div>";
    ?>