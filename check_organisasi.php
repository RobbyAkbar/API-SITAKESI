<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 16/06/19
 * Time: 19:50
 */
if($_SERVER['REQUEST_METHOD']=='POST'){
    require_once('con.php');
    $idAnggota = $_POST['idAnggota'];
    $query = "SELECT lingkup.idOrganisasi, lingkup.statusAnggota, organisasi.namaOrganisasi, organisasi.namaInstansi,
    organisasi.statusOrganisasi, organisasi.referral, organisasi.dtBuat, organisasi.dtAktif FROM lingkup
        INNER JOIN organisasi ON lingkup.idOrganisasi = organisasi.idOrganisasi WHERE lingkup.idAnggota = $idAnggota
        ORDER BY organisasi.namaOrganisasi";

    $result = mysqli_query($connect,$query);

    if(mysqli_num_rows($result)>0){
        $arr = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $temp = array("idOrganisasi" => $row["idOrganisasi"], "statusAnggota" => $row["statusAnggota"], "namaOrganisasi" => $row["namaOrganisasi"],
            "namaInstansi" => $row["namaInstansi"], "statusOrganisasi" => $row["statusOrganisasi"], "referral" => $row["referral"], "dtBuat" => $row["dtBuat"], "dtAktif" => $row["dtAktif"]);
            $arr[] = $temp;
        }

        $data = json_encode($arr);
        echo "$data";
    } else {
        echo "failure";
    }

    mysqli_close($connect);
}
