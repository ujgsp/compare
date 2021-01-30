<?php
require "include/header.php";
require "koneksi.php";

?>
<div class="content-wrapper">

    <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="#">Rekening Koran</a>
        </li>
        <li class="breadcrumb-item active"> Rekening Koran Bulanan</li>
    </ol>
    <div class="row">
        <div class="col-12">
        <!-- <h1>Blank</h1>
        <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        <div class="card mb-3">

            <!-- form filter berdasarkan bulan -->
            <div class="card-body">
            
                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validasi_input(this)"> 
                    <div class="input-group date" id="">
                        <input type="month" name="tanggal" autocomplete="off" value="<?php if (isset($_GET['tanggal'])) echo $_GET['tanggal'];?>">
                        <button class="btn btn-primary" type="submit">Ubah Tanggal</button>
                    </div>
                </form>
            
            </div>
            
            <!-- totalan rekening koran per bank per bulan -->
            <div class="card-footer small text-muted">
                <h6 class="card-title mb-1">
                DATA REKENING KORAN
                </h6>

                <!-- awal bank bca -->
                <?php
				if(isset($_GET['tanggal'])) {
					$bulan = $_GET['tanggal'];
					$dt=date('Ym',strtotime($bulan));
					
					$sql = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bca WHERE keterangan LIKE '%$dt%'");
                    
                    if(mysqli_num_rows($sql) > 0) {
                        $result = mysqli_fetch_assoc($sql);
                        $cr_bca = $result['credit'];
                        if(count($result) > 0) {
                            echo "
                            <h6 class='card-title mb-1'>
                            BANK BCA : ".number_format($cr_bca,0,',','.')."
                            </h6>
                            ";
                        }
                    }
                    else {
                        echo "
                        <h6 class='card-title mb-1'>
                        BANK BCA : 0
                        </h6>
                        ";
                    }

                    /* $cr_bca = $result['credit'];
                    // echo number_format($cr,0,',','.');
                    echo "
                    <h6 class='card-title mb-1'>
                    BANK BCA : ".number_format($cr_bca,0,',','.')."
                    </h6>
                    "; */
					
                }
                else {
                ?>
                <h6 class="card-title mb-1">
                BANK BCA : 
                <?php 
                }
                ?>
                </h6>
                <!-- akhir bank bca -->

                <!-- awal bank mandiri -->
                <?php
				if(isset($_GET['tanggal'])) {
					$bulan = $_GET['tanggal'];
					$dt=date('mY',strtotime($bulan));
					
					$sql = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM mandiri WHERE description2 LIKE '%$dt%'");
                    $result = mysqli_fetch_assoc($sql);
                    $cr_mandiri = $result['credit'];
                    // echo number_format($cr,0,',','.');
                    echo "
                    <h6 class='card-title mb-1'>
                    BANK MANDIRI : ".number_format($cr_mandiri,0,',','.')."
                    </h6>
                    ";
					
                }
                else {
                ?>
                <h6 class="card-title mb-1">
                BANK MANDIRI : 
                <?php 
                }
                ?>
                </h6>
                <!-- akhir bank mandiri -->
                
                <!-- awal bank bri -->
                <?php
				if(isset($_GET['tanggal'])) {
					$bulan = $_GET['tanggal'];
                    // $dt=date('my',strtotime($bulan));
                    $pecah_bulan=explode("-", $bulan);
                    $thn=$pecah_bulan[0];
                    $bln=$pecah_bulan[1];
					
					$sql = mysqli_query($koneksi, " SELECT sum(credit) as credit FROM bri WHERE MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn'
                    ORDER BY tanggal_hpt asc ");
					// $sql = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bri WHERE description1 LIKE '%$dt%' ");
					// $sql = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bri WHERE description1 LIKE '%$dt%' AND description1 NOT LIKE '%$dt' AND description1 NOT LIKE '%TGL06$dt%'");
                    
                    if(mysqli_num_rows($sql) > 0) {
                        $result = mysqli_fetch_assoc($sql);
                        $cr_bri = $result['credit'];
                        if(count($result) > 0) {
                            echo "
                            <h6 class='card-title mb-1'>
                            BANK BRI : ".number_format($cr_bri,0,',','.')."
                            </h6>
                            ";
                        }
                    }
                    else {
                        echo "
                        <h6 class='card-title mb-1'>
                        BANK BRI : 0
                        </h6>
                        ";
                    }
                    
                }
                else {
                ?>
                <h6 class="card-title mb-1">
                BANK BRI : 
                <?php 
                }
                ?>
                </h6>
                <!-- akhir bank bri -->
                
                <!-- awal bank bni -->
                <?php
				if(isset($_GET['tanggal'])) {
					$bulan = $_GET['tanggal'];
					$dt=date('mY',strtotime($bulan));
					
					$sql = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE description1 LIKE '%$dt%' ");
                    $result = mysqli_fetch_assoc($sql);
                    $cr_bni = $result['credit'];
                    // echo number_format($cr,0,',','.');
                    echo "
                    <h6 class='card-title mb-1'>
                    BANK BNI : ".number_format($cr_bni,0,',','.')."
                    </h6>
                    ";
					
                }
                elseif(!empty($_GET['tanggal'])) {
                ?>
                <h6 class="card-title mb-1">
                BANK BNI : <?php echo "nilai 0";?>
                <?php 
                }
                ?>
                </h6>
                <!-- akhir bank bni -->


                <!-- awal total -->
                <?php
				if(isset($_GET['tanggal'])) {
					$total = $cr_bca + $cr_mandiri + $cr_bri + $cr_bni;
                    echo "
                    <h6 class='card-title mb-1'>
                    TOTAL : <strong>".number_format($total,0,',','.')."
                    </strong></h6>
                    ";
					
                }
                else {
                ?>
                <h6 class="card-title mb-1">
                TOTAL : 
                <?php 
                }
                ?>
                </h6>
                <!-- akhir total -->
            </div>
            <!-- 
                javascript validasi
                jika user tidak memilih bulan (langsung klik tombol Ubah Tangga),maka keluarkan peringatan
                referensi: https://dokumenary.wordpress.com/2011/11/01/java-script-untuk-validasi-form-input/
            -->
            <script type="text/javascript">
                function validasi_input(form){
                if (form.tanggal.value == ""){
                    alert("Bulan belum dipilih!");
                    form.tanggal.focus();
                    return (false);
                }
                return (true);
                }
            </script>
        </div>

        <!-- ROW 3 -->
        <!-- DETAIL HARIAN BANK BCA -->
        <p>
            <a style="width: 100%" class="btn btn-primary collapsed" data-toggle="collapse" href="#bca" role="button" aria-expanded="false" aria-controls="collapseExample">
            DETAIL BULANAN PER BANK
            </a>
            <!-- <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Button with data-target
            </button> -->
        </p>
        <div class="collapse show" id="bca">
            <!-- <div class="card card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
            </div> -->
            <!-- tab content induk -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#MANDIRI" role="tab" aria-controls="nav-home" aria-selected="true">Bank MANDIRI</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#BRI" role="tab" aria-controls="nav-profile" aria-selected="false">Bank BRI</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#BNI" role="tab" aria-controls="nav-contact" aria-selected="false">BANK BNI</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#BCA" role="tab" aria-controls="nav-contact" aria-selected="false">BANK BCA</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#TOTAL" role="tab" aria-controls="nav-contact" aria-selected="false">TOTAL</a>
                    
                </div>
            </nav>
            <!-- tab content anak -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="MANDIRI" role="tabpanel" aria-labelledby="nav-home-tab">
                <!-- tab content bank mandiri disini -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableMandiriBulanan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Gerbang</th>
                                <th>Rekening Koran (RC)</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>
                                <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr = $result['credit'];
                                        echo number_format($cr,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <!-- get data per gerbang dari database -->
                            <tr>
                                <td>Palimanan</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4904' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_palimanan_mandiri = $result['credit'];
                                        echo number_format($cr_palimanan_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Sumberjaya</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4905' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_sumberjaya_mandiri = $result['credit'];
                                        echo number_format($cr_sumberjaya_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Cikedung</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4907' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_cikedung_mandiri = $result['credit'];
                                        echo number_format($cr_cikedung_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Subang</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4908' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_subang_mandiri = $result['credit'];
                                        echo number_format($cr_subang_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Kalijati</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        // $dt=date('m',strtotime($bulan));
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4909' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        // $cr = $result['credit'];
                                        $cr_kalijati_mandiri = $result['credit'];
                                        echo number_format($cr_kalijati_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Cikampek Utama</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='1437' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_cikampek_utama_mandiri = $result['credit'];
                                        echo number_format($cr_cikampek_utama_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Cikampek</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='1420' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_cikampek_mandiri = $result['credit'];
                                        echo number_format($cr_cikampek_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Kertajati</td>
                                <td>
                                    <?php
                                    /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                    // jika filter pencarian dipilih
                                    if(isset($_GET['tanggal'])) {
                                        $bulan = $_GET['tanggal'];
                                        $pecah_bulan=explode("-", $bulan);
                                        $thn=$pecah_bulan[0];
                                        $bln=$pecah_bulan[1];
                                        $query = mysqli_query($koneksi, "SELECT tanggal_hpt,SUM(credit) as credit FROM mandiri WHERE kode_gerbang='4906' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                        $result = mysqli_fetch_assoc($query);
                                        $cr_kertajati_mandiri = $result['credit'];
                                        echo number_format($cr_kertajati_mandiri,0,',','.');
                                        
                                    }
                                    // selain itu tampilkan nilai 0
                                    else {
                                        echo "0";
                                    }
                                    ?>
                                </td>
                            </tr>

                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- tab content bank mandiri disini -->
                </div>
                <div class="tab-pane fade" id="BRI" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <!-- ini bank bri -->
                    <!-- show datatablenya disini -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableBRI" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Gerbang</th>
                                    <th>Rekening Koran (RC)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr = $result['credit'];
                                            echo number_format($cr,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- get data per gerbang dari database -->
                                <tr>
                                    <td>Palimanan</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600005' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_palimanan_bri = $result['credit'];
                                            echo number_format($cr_palimanan_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Sumberjaya</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600004' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_sumberjaya_bri = $result['credit'];
                                            echo number_format($cr_sumberjaya_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikedung</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600002' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikedung_bri = $result['credit'];
                                            echo number_format($cr_cikedung_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Subang</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600001' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_subang_bri = $result['credit'];
                                            echo number_format($cr_subang_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kalijati</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600000' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_kalijati_bri = $result['credit'];
                                            echo number_format($cr_kalijati_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikampek Utama</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1929570262' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikampek_utama_bri = $result['credit'];
                                            echo number_format($cr_cikampek_utama_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikampek</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1929570116' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikampek_bri = $result['credit'];
                                            echo number_format($cr_cikampek_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kertajati</td>
                                    <td>
                                        <?php
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bri WHERE kode_gerbang = '1984600003' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_kertajati_bri = $result['credit'];
                                            echo number_format($cr_kertajati_bri,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- show datatablenya disini -->
                </div>
                <div class="tab-pane fade" id="BNI" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <!-- ini bank bni -->
                    <!-- show datatablenya disini -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-hover" id="dataTableBNI" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Gerbang</th>
                                    <th>Rekening Koran (RC)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr = $result['credit'];
                                            echo number_format($cr,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- get data per gerbang dari database -->
                                <tr>
                                    <td>Palimanan</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang IN ('500130','500100') AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_palimanan_bni = $result['credit'];
                                            echo number_format($cr_palimanan_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Sumberjaya</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='500125' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_sumberjaya_bni = $result['credit'];
                                            echo number_format($cr_sumberjaya_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikedung</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='500115' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikedung_bni = $result['credit'];
                                            echo number_format($cr_cikedung_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Subang</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='500110' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_subang_bni = $result['credit'];
                                            echo number_format($cr_subang_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kalijati</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='500105' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_kalijati_bni = $result['credit'];
                                            echo number_format($cr_kalijati_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikampek Utama</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang = '301426' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikampek_utama_bni = $result['credit'];
                                            echo number_format($cr_cikampek_utama_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Cikampek</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='301420' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_cikampek_bni = $result['credit'];
                                            echo number_format($cr_cikampek_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Kertajati</td>
                                    <td>
                                        <?php
                                        /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                        // jika filter pencarian dipilih
                                        if(isset($_GET['tanggal'])) {
                                            $bulan = $_GET['tanggal'];
                                            $pecah_bulan=explode("-", $bulan);
                                            $thn=$pecah_bulan[0];
                                            $bln=$pecah_bulan[1];
                                            $query = mysqli_query($koneksi, " SELECT SUM(credit) as credit FROM bni WHERE kode_gerbang='500120' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                            $result = mysqli_fetch_assoc($query);
                                            $cr_kertajati_bni = $result['credit'];
                                            echo number_format($cr_kertajati_bni,0,',','.');
                                            
                                        }
                                        // selain itu tampilkan nilai 0
                                        else {
                                            echo "0";
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- show datatablenya disini -->
                </div>

                <!-- show datatable bank bca -->
                <div class="tab-pane fade" id="BCA" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <!-- show datatablenya disini -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-hover" id="dataTableBca" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Gerbang</th>
                                        <th>Rekening Koran (RC)</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <!-- get data per gerbang dari database -->
                                    <tr>
                                        <td>Palimanan</td>
                                        <td tabindex="0">
                                            <?php
                                                /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bca WHERE kode_gerbang = ' 885023100201' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn'");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_palimanan_bca = $result['credit'];
                                                    echo number_format($cr_palimanan_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Sumberjaya</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885023100200' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_sumberjaya_bca = $result['credit'];
                                                    echo number_format($cr_sumberjaya_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikedung</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885023100198' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_cikedung_bca = $result['credit'];
                                                    echo number_format($cr_cikedung_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Subang</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885023100197' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_subang_bca = $result['credit'];
                                                    echo number_format($cr_subang_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Kalijati</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    // konversi inputan ke format tanggal
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885023100196' AND month(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_kalijati_bca = $result['credit'];
                                                    echo number_format($cr_kalijati_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikampek Utama</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885000803566' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_cikampek_utama_bca = $result['credit'];
                                                    echo number_format($cr_cikampek_utama_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikampek</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885000500134' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_cikampek_bca = $result['credit'];
                                                    echo number_format($cr_cikampek_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                            </td>
                                    </tr>

                                    <tr>
                                        <td>Kertajati</td>
                                        <td tabindex="0">
                                            <?php
                                                // jika filter pencarian dipilih
                                                if(isset($_GET['tanggal'])) {
                                                    // ambil inputan user 
                                                    $bulan = $_GET['tanggal'];
                                                    $pecah_bulan=explode("-", $bulan);
                                                    $thn=$pecah_bulan[0];
                                                    $bln=$pecah_bulan[1];
                                                    $sql = mysqli_query($koneksi, "SELECT SUM(credit) AS credit FROM bca WHERE kode_gerbang=' 885023100199' AND MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");
                                                    // bungkus query mysql untuk ditampilkan
                                                    $result = mysqli_fetch_assoc($sql);
                                                    // tampilkan data ke browser
                                                    $cr_kertajati_bca = $result['credit'];
                                                    echo number_format($cr_kertajati_bca,0,',','.');
                                                    
                                                }
                                                // selain itu tampilkan nilai 0
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th  tabindex="0">
                                            <?php
                                            /* note: untuk bca palimanan kode gerbang nyebrang palimanan dan sumberjaya dan palimanan c2 */
                                            // jika filter pencarian dipilih
                                            if(isset($_GET['tanggal'])) {
                                                /* $bulan = $_GET['tanggal'];
                                                $pecah_bulan=explode("-", $bulan);
                                                $thn=$pecah_bulan[0];
                                                $bln=$pecah_bulan[1];
                                                $query = mysqli_query($koneksi, "SELECT SUM(credit) as credit FROM bca WHERE MONTH(tanggal_hpt)='$bln' AND YEAR(tanggal_hpt)='$thn' ");

                                                $result = mysqli_fetch_assoc($query);
                                                $cr = $result['credit']; */
                                                $totalbca = $cr_kalijati_bca+$cr_subang_bca+$cr_cikedung_bca+$cr_kertajati_bca+$cr_sumberjaya_bca+$cr_palimanan_bca+$cr_cikampek_bca+$cr_cikampek_utama_bca;
                                                echo number_format($totalbca,0,',','.');
                                                
                                            }
                                            // selain itu tampilkan nilai 0
                                            else {
                                                echo "0";
                                            }
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                        </div>
                    <!-- show datatablenya disini -->
                </div>

                <!-- show datatable total -->
                <div class="tab-pane fade" id="TOTAL" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <!-- ini total -->
                    <!-- show datatablenya disini -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableGrandTotal" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Gerbang</th>
                                        <th>Rekening Koran (RC)</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <!-- get data per gerbang dari database -->
                                    <tr>
                                        <td>Palimanan</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca palimanan
                                            mandiri palimanan
                                            bri palimanan
                                            bni palimanan 
                                            */
                                             $grand_total_palimanan = $cr_palimanan_mandiri + $cr_palimanan_bri + $cr_palimanan_bni + $cr_palimanan_bca;
                                             echo number_format($grand_total_palimanan,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Sumberjaya</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca sumberjaya
                                            mandiri sumberjaya
                                            bri sumberjaya
                                            bni sumberjaya 
                                            */
                                             $grand_total_sumberjaya = $cr_sumberjaya_mandiri + $cr_sumberjaya_bri + $cr_sumberjaya_bni + $cr_sumberjaya_bca;
                                             echo number_format($grand_total_sumberjaya,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikedung</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca subang
                                            mandiri subang
                                            bri subang
                                            bni subang 
                                            */
                                             $grand_total_cikedung = $cr_cikedung_mandiri + $cr_cikedung_bri + $cr_cikedung_bni + $cr_cikedung_bca;
                                             echo number_format($grand_total_cikedung,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Subang</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca subang
                                            mandiri subang
                                            bri subang
                                            bni subang 
                                            */
                                             $grand_total_subang = $cr_subang_mandiri + $cr_subang_bri + $cr_subang_bni + $cr_subang_bca; 
                                             echo number_format($grand_total_subang,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Kalijati</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca kalijati
                                            mandiri kalijati
                                            bri kalijati
                                            bni kalijati 
                                            */
                                             $grand_total_kalijati = $cr_kalijati_mandiri + $cr_kalijati_bri + $cr_kalijati_bni + $cr_kalijati_bca;
                                             echo number_format($grand_total_kalijati,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikampek Utama</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total cikampek utama = hasil penambahan
                                            bca cikampek utama
                                            mandiri cikampek utama
                                            bri cikampek utama
                                            bni cikampek utama 
                                            */
                                             $grand_total_cikampek_utama = $cr_cikampek_utama_mandiri + $cr_cikampek_utama_bri + $cr_cikampek_utama_bni + $cr_cikampek_utama_bca;
                                             echo number_format($grand_total_cikampek_utama,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Cikampek</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca cikampek
                                            mandiri cikampek
                                            bri cikampek
                                            bni cikampek 
                                            */
                                             $grand_total_cikampek = $cr_cikampek_mandiri + $cr_cikampek_bri + $cr_cikampek_bni + $cr_cikampek_bca;
                                             echo number_format($grand_total_cikampek,0,',','.');
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Kertajati</td>
                                        <td>
                                            <?php
                                            /*
                                            grand total kalijati = hasil penambahan
                                            bca kertajati
                                            mandiri kertajati
                                            bri kertajati
                                            bni kertajati 
                                            */
                                             $grand_total_kertajati = $cr_kertajati_mandiri + $cr_kertajati_bri + $cr_kertajati_bni + $cr_kertajati_bca;
                                             echo number_format($grand_total_kertajati,0,',','.');
                                            ?>
                                        </td>
                                    </tr>
                                    <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>
                                           
                                            <?php
                                            
                                             $grand_totalx = $grand_total_kalijati + $grand_total_subang + $grand_total_cikedung + $grand_total_kertajati + $grand_total_sumberjaya + $grand_total_palimanan + $grand_total_cikampek + $grand_total_cikampek_utama;
                                             echo number_format($grand_totalx,0,',','.');
                                            ?>
                                            
                                        </th>
                                    </tr>
                                </tfoot>

                                </tbody>
                                </table>
                            </div>
                        </div>
                    <!-- show datatablenya disini -->
                </div>
                
                <!-- <div class="tab-pane fade" id="bca-total" role="tabpanel" aria-labelledby="nav-contact-tab">ini total</div> -->
            </div>
            
        </div>

        <br>

        








        </div>
    </div>
    </div>
</div>
  <!-- wrapper sampai sini -->

<!-- footer -->
<?php
require "include/footer.php";
?>