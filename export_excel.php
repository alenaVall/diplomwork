<?
require_once 'Classes/PHPExcel.php';
require_once 'connect.php';

$search = $_GET['search'];
$start_year = $_GET['start_year'];
$end_year = $_GET['end_year'];

$page = $_GET['page'];

$items = ($_GET['page'] - 1) * 10;
$all_pages = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id_status`=3");
if (mysqli_num_rows($all_pages) % 10 > 0) {
    $all_pages = (int) (mysqli_num_rows($all_pages) / 10) + 1;
} else {
    $all_pages = (int) (mysqli_num_rows($all_pages) / 10);
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

$active_sheet->getColumnDimension('A')->setWidth(5);
$active_sheet->getColumnDimension('B')->setWidth(15);
$active_sheet->getColumnDimension('C')->setWidth(25);
$active_sheet->getColumnDimension('D')->setWidth(7);
$active_sheet->getColumnDimension('E')->setWidth(15);
$active_sheet->getColumnDimension('F')->setWidth(18);
$active_sheet->getColumnDimension('G')->setWidth(15);
$active_sheet->getColumnDimension('H')->setWidth(25);
$active_sheet->getColumnDimension('I')->setWidth(30);
$active_sheet->getColumnDimension('J')->setWidth(16);

$active_sheet->mergeCells('A1:J1');
$active_sheet->setCellValue('A1', 'Cписок литературы');
$active_sheet->setCellValue('A2', '№');
$active_sheet->setCellValue('B2', 'Автор');
$active_sheet->setCellValue('C2', 'Название');
$active_sheet->setCellValue('D2', 'Год');
$active_sheet->setCellValue('E2', 'Ресурс');
$active_sheet->setCellValue('F2', 'Тип');
$active_sheet->setCellValue('G2', 'Дисциплина');
$active_sheet->setCellValue('H2', 'Библиотека');
$active_sheet->setCellValue('I2', 'Ссылка');
$active_sheet->setCellValue('J2', 'Статус');


if ($search != NULL and $start_year != NULL and $end_year != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE (`year_of_pub` >= '$start_year' AND `year_of_pub` <='$end_year')  AND (`title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
}  elseif ($search != NULL and $start_year != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE `year_of_pub` >= '$start_year' AND (`title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
} elseif ($search != NULL and $end_year != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE `year_of_pub` <= '$end_year' AND `title` LIKE '%$search%' OR `author` LIKE '%$search%' AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
} elseif ($end_year != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE (`year_of_pub` <= '$end_year') AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
} elseif ($start_year != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE (`year_of_pub` >= '$start_year') AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
}elseif ($search != NULL) {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
    WHERE  ( `title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
    LIMIT $items, 10 ") or die(mysqli_error($connect));
} 
else {
    $literatures = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id_status`=3 LIMIT $items, 10  ") or die(mysqli_error($connect));
}
$literatures = mysqli_fetch_all($literatures);

$i = 3;

foreach ($literatures as $literature) {
    $bible = mysqli_query($connect, "SELECT * FROM `bible` WHERE `id`='$literature[8]'") or die(mysqli_error($connect));
    $bible = mysqli_fetch_assoc($bible);

    $discipline = mysqli_query($connect, "SELECT * FROM `discipline` WHERE `id`='$literature[7]'") or die(mysqli_error($connect));
    $discipline = mysqli_fetch_assoc($discipline);

    $resource = mysqli_query($connect, "SELECT * FROM `resource` WHERE `id`='$literature[10]'") or die(mysqli_error($connect));
    $resource = mysqli_fetch_assoc($resource);

    $status = mysqli_query($connect, "SELECT * FROM `status` WHERE `id`='$literature[11]'") or die(mysqli_error($connect));
    $status = mysqli_fetch_assoc($status);

    $type = mysqli_query($connect, "SELECT * FROM `type_of_liter` WHERE `id`='$literature[9]'") or die(mysqli_error($connect));
    $type = mysqli_fetch_assoc($type);

    $active_sheet->setCellValue('A' . $i, $literature[0]);
    $active_sheet->setCellValue('B' . $i, $literature[2]);
    $active_sheet->setCellValue('C' . $i, $literature[1]);
    $active_sheet->setCellValue('D' . $i, $literature[3]);
    $active_sheet->setCellValue('E' . $i, $resource['title'] );
    $active_sheet->setCellValue('F' . $i, $type['title']);
    $active_sheet->setCellValue('G' . $i, $discipline['title']);
    $active_sheet->setCellValue('H' . $i, $bible['title']);

    if ($literature[6] != null) {
        $active_sheet->setCellValue('I'. $i , $literature[6]);
        $active_sheet->getCell('I'. $i)->getHyperlink()->setUrl($literature[6]);
        
     } else{
        $active_sheet->setCellValue('I' . $i, "Нет ссылки");
     }

    $active_sheet->setCellValue('J' . $i, $status['title']);

    $i++;
}

header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition:attachment;filename="Cписок литературы.xlsx"');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

header("Location: http://bible.bfuunit.ru/liter/list.php?page=1");
