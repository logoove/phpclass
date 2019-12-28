<?php
require 'Pager.class.php';

use logoove\pager\Pager;

$totalItems = 200; // 总记录数
$itemsPerPage = 10; // 每页显示数

$currentPage = 1;
if (isset($_GET['page'])) {
    $currentPage = intval($_GET['page']);
}

// $currentPage = 8;
// $urlPattern = '/foo/page/(:num)';
$urlPattern = '?page=(:num)';

$paginator = new Pager($totalItems, $itemsPerPage, $currentPage, $urlPattern);


$paginator->setMaxPagesToShow(7);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>演示：PHP分页组件-pager</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
<div class="container">

    <div class="row main">
        <div class="col-md-12">
            <h2 class="top_title">PHP分页组件-pager</h2>

            <div class="row" style="margin-top: 30px">
                <div class="col-md-offset-2 col-sm-8">
                    <p>1.默认分页</p>
                    <?php
                    echo $paginator;
                    ?>


                    <p>2.可下拉选择翻页，可用于移动端</p>
                    <?php if ($paginator->getNumPages() > 1): ?>
                        <div class="input-group" style="width: 1px;margin-top: 20px">
                            <?php if ($paginator->getPrevUrl()): ?>
                                <span class="input-group-btn">
                <a href="<?php echo $paginator->getPrevUrl(); ?>" class="btn btn-default" type="button">&laquo; 上一页</a>
            </span>
                            <?php endif; ?>

                            <select class="form-control paginator-select-page" style="width: auto; cursor: pointer; -webkit-appearance: none; -moz-appearance: none; appearance: none;">
                                <?php foreach ($paginator->getPages() as $page): ?>
                                    <?php if ($page['url']): ?>
                                        <option value="<?php echo $page['url']; ?>"<?php if ($page['isCurrent']) echo ' selected'; ?>>
                                            第 <?php echo $page['num']; ?> 页
                                        </option>
                                    <?php else: ?>
                                        <option disabled><?php echo $page['num']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                            <?php if ($paginator->getNextUrl()): ?>
                                <span class="input-group-btn">
                <a href="<?php echo $paginator->getNextUrl(); ?>" class="btn btn-default" type="button">下一页 &raquo;</a>
            </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>




                </div>
                <div style="clear: both"></div>

            </div>
        </div>

    </div>
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(function() {
            $('.paginator-select-page').on('change', function() {
                document.location = $(this).val();
            });
            $('.paginator-select-page')
                .on('focus', function() {
                    if (/(iPad|iPhone|iPod)/g.test(navigator.userAgent)) {
                        $(this).css('font-size', '16px');
                    }
                })
                .on('blur', function() {
                    if (/(iPad|iPhone|iPod)/g.test(navigator.userAgent)) {
                        $(this).css('font-size', '');
                    }
                })
            ;
        });
    </script>
</body>
</html>
