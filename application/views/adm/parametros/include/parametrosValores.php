
<div class="head"><h5 class="iList">Valores</h5></div>
<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
    <tbody>
        <?
        if (isset($row)) {
            $items = $row->getParametroValor();

            if (count($items['rows']) > 0) {
                foreach ($items['rows'] as $kItem => $vItem) {
                    include 'valores.php';
                }
            } else {
                include 'valores.php';
            }
        } else {
            include 'valores.php';
        }
        ?>
    </tbody>
</table>
<div class="fix"></div>


