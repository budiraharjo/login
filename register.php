<?php 

error_reporting(0);
include 'config.php';

if(!isset($_SESSION['username'] )== 0) { /* Halaman ini tidak dapat diakses jika belum ada yang login */
	header('Location: home.php'); 
}

$username 		 = $_POST['username'];
$nama 			 = $_POST['nama'];
$jenis_kelamin 	 = $_POST['jenis_kelamin'];
$password 		 = md5($_POST['password']."ALS52KAO09");
$confirmPassword = md5($_POST['confirmPassword']."ALS52KAO09");
$nip 	 = $_POST['nip'];
$nama_instansi 	 = $_POST['nama_instansi'];
$no_reg_instansi 	 = $_POST['no_reg_instansi'];
$alamat 	 = $_POST['alamat'];
$telp 	 = $_POST['telp'];

if(isset($username, $nama, $password, $confirmPassword)) { 
	
		if($password == $confirmPassword) {
			try {
				$sql = "SELECT * FROM distributor WHERE username = :username OR nama = :nama";
				$stmt = $connect->prepare($sql);
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':nama', $nama);
				$stmt->execute();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			$count = $stmt->rowCount();
			if($count == 0) {
				try {
					$sql = "INSERT INTO distributor SET username = :username, password = :password, nama = :nama, jenis_kelamin = :jenis_kelamin, nip = :nip, nama_instansi = :nama_instansi, no_reg_instansi = :no_reg_instansi, alamat = :alamat, telp = :telp";
					$stmt = $connect->prepare($sql);
					$stmt->bindParam(':username', $username);
					$stmt->bindParam(':nama', $nama);
					$stmt->bindParam(':password', $password);
					$stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
					$stmt->bindParam(':nip', $nip);
					$stmt->bindParam(':nama_instansi', $nama_instansi);
					$stmt->bindParam(':no_reg_instansi', $no_reg_instansi);
					$stmt->bindParam(':alamat', $alamat);
					$stmt->bindParam(':telp', $telp);
					$stmt->execute();
				}
				catch(PDOException $e) {
					echo $e->getMessage();
				}
				if($stmt) {
					echo "Selamat Anda berhasil Register, anda dapat Login";
				}
			}else{
				echo "Username dan nama sudah pernah digunakan";
			}
		}else{
			echo "Password tidak sama";
		}
	}

?>

<!-- FORM UNTUK REGISTRASI -->	
<form action="" method="post">
	<table>
		<tr>
			<td>Username</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td><input type="text" name="nama"></td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>
			<select name="jenis_kelamin">
			<option value="">Jenis Kelamin</option>
			<option value="Laki-laki">Laki-laki</option>
			<option value="Perempuan">Perempuan</option>
			<select>
			
		</tr>
		<tr>
			<td>NIP</td>
			<td><input type="text" name="nip"></td>
		</tr>
		<tr>
			<td>Nama instansi</td>
			<td><input type="text" name="nama_instansi"></td>
		</tr>
		<tr>
			<td>No Registrasi Instansi</td>
			<td><input type="text" name="no_reg_instansi"></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><input type="text" name="alamat"></td>
		</tr>
		<tr>
			<td>Telp</td>
			<td><input type="text" name="telp"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input type="password" name="confirmPassword"></td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="register" value="Register">
				<input type="reset" name="reset" value="Reset">
			</td>
		</tr>
	</table>
</form>