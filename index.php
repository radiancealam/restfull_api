<?php 
include("koneksi.php");
$db = new dbObj();
$connection = $db->getConString();
$requestnya = $_SERVER["REQUEST_METHOD"];
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

switch($requestnya){
    case 'GET' :
        if(!empty($uri_segments[3])){
            $nim = $uri_segments[3];
            get_mahasiswa($nim);
        } else {
            get_mahasiswa();
        }
        break;

    case 'POST' :
        insert_mahasiswa();
        break;

    case 'PUT' :
        $nim=$uri_segments[3];
        update_mahasiswa($nim);
        break;

    case 'DELETE' :
        $nim=$uri_segments[3];
        delete_mahasiswa($nim);
        break;

    default:
    header("HTTP/1.0 405 Method Tidak Terdaftar");
    break;
}

function get_mahasiswa($nim=""){
    global $connection;
    $query="SELECT * FROM mahasiswa";
    
    if(!empty($nim)){
        $query .=" WHERE nim='".$nim."' LIMIT 1";
    }

    $response=array();
    $result = mysqli_query($connection, $query);
    $i = 0;
    while($row=mysqli_fetch_array($result)){
        $response[$i]['nim'] = $row['nim'];
        $response[$i]['nama'] = $row['nama'];
        $response[$i]['angkatan'] = $row['angkatan'];
        $response[$i]['semester'] = $row['semester'];
        $response[$i]['ipk'] = $row['ipk'];
        $i++;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_mahasiswa(){
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $query ="INSERT INTO mahasiswa set nim='".$data['nim']."', nama='".$data['nama']."', angkatan='".$data['angkatan']."', semester='".$data['semester']."', ipk='".$data['ipk']."'";

    if(mysqli_query($connection, $query)){
        $response=array('kode'=>1, 'status'=>'Data Mahasiswa Berhasil Ditambah');
    } else {
        $response=array('kode'=>0, 'status'=>'Data Mahasiswa Gagal Ditambah');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_mahasiswa($nim){
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $data["nama"];
    $angkatan = $data["angkatan"];
    $semester = $data["semester"];
    $ipk = $data["ipk"];
    $query ="UPDATE `mahasiswa` SET `nama`= '" .$nama . "',`angkatan`= '" .$angkatan . "',`semester`= '" .$semester . "' ,`ipk`= '" .$ipk. "' WHERE nim= '" . $nim . "'";
    
    if(mysqli_query($connection, $query)){
        $response=array('kode'=>1, 'status'=>'Data Mahasiswa Berhasil Diubah');
    } else {
        $response=array('kode'=>0, 'status'=>'Data Mahasiswa Gagal Diubah');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function delete_mahasiswa($nim){
    global $connection;
    $query = "DELETE FROM `mahasiswa` WHERE nim='".$nim."'";

    if(mysqli_query($connection, $query)){
        $response=array('kode'=>1, 'status'=>'Data Mahasiswa Berhasil Dihapus');
    } else {
        $response=array('kode'=>0, 'status'=>'Data Mahasiswa Gagal Dihapus');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>