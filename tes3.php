<form action="tes3.php" method="get">
input bulan:
<input type="month" name="month" id="">
<input type="submit" value="Ubah Bulan">
</form>

<?php
if(isset($_GET['month'])) {
    $bulan=$_GET['month'];
    $pecah_bulan=explode("-", $bulan);
    echo $thn=$pecah_bulan[0];
    echo $bln=$pecah_bulan[1];
}
?>

AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn'

table  table-bordered table-hover

kalijati
subang
cikedung
kertajati
sumberjaya