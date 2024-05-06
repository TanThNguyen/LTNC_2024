<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Thông tin nhân viên'
];
layouts('header_page', $data);

include_Object('donthuoc');
include_Object('benhan');
include_Object('benhnhan');

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)) {
    redirect('?module=auth&action=login');
}

$donthuoc = new donthuoc($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $donthuoc->setba_id($filterAll['id']);
    $query = $donthuoc->search($filterAll['id']);

?>
    <div class="container">
        <?php
        $msg = getFlashData('msg');
        $type = getFlashData('type');
        if (!empty($msg)) {
            getMsg($msg, $type);
        }
        ?>

        <?php
        if (!empty($query)) :
            $count = $from_record_num;
            foreach ($query as $item) :
                $count++;
        ?>
                <table class="table table-bordered">
                    <thead>
                        <th>STT</th>
                        <th>Mã đơn thuốc</th>
                        <th>Chi phí điều trị</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['chiphidieutri']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <th>Tên thuốc</th>
                        <th>Số lượng</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM donthuoc_thuoc WHERE donthuoc_id =" . $item['id'];
                        $listThuoc = $database->getRow($sql);
                        if (!empty($listThuoc)) :
                            foreach ($listThuoc as $item) :
                        ?>
                                <tr>
                                    <td><?php echo $item['tenthuoc']; ?></td>
                                    <td><?php echo $item['soluong']; ?></td>
                                </tr>

                            <?php
                            endforeach;
                            ?>
                    </tbody>
                </table>
    <?php
                        endif;
                    endforeach;
                endif;
    ?>

    </div>

<?php
} else {
    setFlashData('msg', 'Bệnh nhân không tồn tại');
    setFlashData('type', 'danger');
    redirect('?module=benhnhan&action=index');
}
