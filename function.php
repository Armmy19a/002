<?php
error_reporting(0);

//เชื่อต่อ Database
$con = mysqli_connect("localhost","root","rootroot","durable");
$con->set_charset("utf8");

function checkLogin($username,$password){
	$data = array();
	global $con;
	$sql = "select * from users where username = '".$username."' AND password='".$password."' AND actives = '0'";
	$res = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_array($res)) {
		$data['users_id'] = $row['users_id'];
		$data['role'] = $row['role'];
		$data['actives'] = $row['actives'];

	}
	if (!empty($data)) {
		if($data['actives'] == 0){
			session_start();
			$id = $data['users_id'];
			$_SESSION['id'] = $data['users_id'];
			$_SESSION['role'] = $data['role'];
			$_SESSION['actives'] = $data['actives'];
			echo ("<script language='JavaScript'>
				window.location.href='dashboard.php';
				</script>");
		}else{
			echo "<script type='text/javascript'>alert('ไม่สามารถเข้าสู่ระบบได้ เนื่องจากคุณถูกระงับการเข้าใช้งาน');</script>";
		}
		
	}else{
		echo "<script type='text/javascript'>alert('ไม่สามารถเข้าสู่ระบบได้ ');</script>";
	}
	
	mysqli_close($con);

}


function logout(){
	session_start();
	session_unset();
	session_destroy();
	echo ("<script language='JavaScript'>
		window.location.href='index.php';
		</script>");
	exit();
}

function getUser($users_id){

	global $con;

	$res = mysqli_query($con,"SELECT * FROM users WHERE users_id = '".$users_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function getCheckActiveUser($users_id){

	global $con;

	$res = mysqli_query($con,"SELECT actives FROM users WHERE users_id = '".$users_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function saveRegister($user_number,$firstname,$lastname,$telephone,$email,$program,$username,$password){
	
	
	global $con;

	$sql = "INSERT INTO users (user_number, username, password, firstname, lastname, telephone, email, program, role) VALUES('".$user_number."','".$username."','".$password."','".$firstname."','".$lastname."','".$telephone."','".$email."','".$program."','2')";
	mysqli_query($con,$sql);
	
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลงทะเบียนเรียบร้อย');
		window.location.href='index.php';
		</script>"); 
	
}

function saveUsers($user_number,$firstname,$lastname,$telephone,$email,$program,$username,$password,$role){
	
	
	global $con;

	$sql = "INSERT INTO users (user_number, username, password, firstname, lastname, telephone, email, program, role) VALUES('".$user_number."','".$username."','".$password."','".$firstname."','".$lastname."','".$telephone."','".$email."','".$program."','".$role."')";
	mysqli_query($con,$sql);
	
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('เพิ่มข้อมูลเรียบร้อย');
		window.location.href='manage_user.php?role=$role';
		</script>"); 
	
}

function editUsers($users_id,$user_number,$firstname,$lastname,$telephone,$email,$program,$username,$password,$role){

	global $con;

	$sql="UPDATE users SET user_number='".$user_number."',username='".$username."',password='".$password."',firstname='".$firstname."',lastname='".$lastname."',telephone='".$telephone."',email='".$email."',program='".$program."',role='".$role."' WHERE users_id = '".$users_id."'";
	mysqli_query($con,$sql);

	
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='manage_user.php?role=$role';
		</script>"); 
	
}

function editProfile($users_id,$user_number,$firstname,$lastname,$telephone,$email,$program,$username,$password){

	global $con;

	$sql="UPDATE users SET user_number='".$user_number."',username='".$username."',password='".$password."',firstname='".$firstname."',lastname='".$lastname."',telephone='".$telephone."',email='".$email."',program='".$program."' WHERE users_id = '".$users_id."'";
	mysqli_query($con,$sql);
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='profile.php';
		</script>"); 
	
}

function deleteUsers($users_id,$role){
	global $con;

	mysqli_query($con,"DELETE FROM users WHERE users_id='".$users_id."'");
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลบข้อมูลเรียบร้อยแล้ว');
		window.location.href='manage_user.php?role=$role';
		</script>"); 

}

function blockUsers($users_id,$role){
	global $con;

	$sql="UPDATE users SET actives='1' WHERE users_id = '".$users_id."'";

	mysqli_query($con,$sql);
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ระงับผู้ใช้งานเรียบร้อย');
		window.location.href='manage_user.php?role=$role';
		</script>"); 

}

function unBlockUsers($users_id,$role){
	global $con;

	$sql="UPDATE users SET actives='0' WHERE users_id = '".$users_id."'";

	mysqli_query($con,$sql);
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ผู้ใช้งานสามารถใช้งานระบบได้ปกติแล้ว');
		window.location.href='manage_user.php?role=$role';
		</script>"); 

}

function getAllUsers(){
	global $con;

	$res = mysqli_query($con,"SELECT * FROM users ORDER BY users_id DESC");

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'users_id' => $row['users_id'],
			'user_number' => $row['user_number'],
			'username' => $row['username'],
			'password' => $row['password'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'telephone' => $row['telephone'],
			'email' => $row['email'],
			'program' => $row['program'],
			'role' => $row['role']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllUsersByStatus($role){
	global $con;

	$res = mysqli_query($con,"SELECT * FROM users WHERE role = '".$role."' ORDER BY users_id DESC");

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'users_id' => $row['users_id'],
			'user_number' => $row['user_number'],
			'username' => $row['username'],
			'password' => $row['password'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'telephone' => $row['telephone'],
			'email' => $row['email'],
			'program' => $row['program'],
			'actives' => $row['actives'],
			'role' => $row['role']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}


function getCurrentUsers($users_id){

	global $con;

	$res = mysqli_query($con,"SELECT * FROM users WHERE users_id = '".$users_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function saveCategory($cate_name){
	
	
	global $con;

	$sql = "INSERT INTO categories (cate_name) VALUES('".$cate_name."')";
	mysqli_query($con,$sql);
	
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('เพิ่มข้อมูลเรียบร้อย');
		window.location.href='manage_category.php';
		</script>"); 
	
}

function editCategory($categories_id,$cate_name){

	global $con;

	$sql="UPDATE categories SET cate_name='".$cate_name."' WHERE categories_id = '".$categories_id."'";
	mysqli_query($con,$sql);

	
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='manage_category.php';
		</script>"); 
	
}

function deleteCategory($categories_id){
	global $con;

	mysqli_query($con,"DELETE FROM categories WHERE categories_id='".$categories_id."'");
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลบข้อมูลเรียบร้อยแล้ว');
		window.location.href='manage_category.php';
		</script>"); 

}

function getAllCategory(){
	global $con;

	$res = mysqli_query($con,"SELECT * FROM categories ORDER BY categories_id DESC");

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'categories_id' => $row['categories_id'],
			'cate_name' => $row['cate_name']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}


function getCurrentCategory($categories_id){

	global $con;

	$res = mysqli_query($con,"SELECT * FROM categories WHERE categories_id = '".$categories_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function getAllMeasure(){
	global $con;

	$res = mysqli_query($con,"SELECT * FROM measures ORDER BY id DESC");

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'id' => $row['id'],
			'meas_name' => $row['meas_name']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function runNumberEquipments(){
	global $con;

	$res = mysqli_query($con,"SELECT MAX(id) as mid FROM equipments");
	$data = array();
	while($row = mysqli_fetch_array($res)) {
		$data['mid'] = $row['mid'];
	}
	$run = intval($data['mid']);
	$run = $run+1;

	if($run=="")
		$run=1;
	$number_order = sprintf('%05d', $run);

	return $number_order;
	mysqli_close($con);
}

function saveEquipments($categories_id,$equ_number,$equ_name,$equ_detail,$equ_quantity,$units,$fisd_years,$equ_img,$equ_status){
	
	global $con;

	if($equ_img != null){
		if(move_uploaded_file($_FILES["equ_img"]["tmp_name"],"images/equipment/".$_FILES["equ_img"]["name"]))
		{

			$sql = "INSERT INTO equipments (categories_id, equ_number, equ_name, equ_detail, equ_quantity, units, fisd_years, equ_img, equ_status) VALUES('".$categories_id."','".$equ_number."','".$equ_name."','".$equ_detail."','".$equ_quantity."','".$units."','".$fisd_years."','".$_FILES["equ_img"]["name"]."','".$equ_status."')";
			mysqli_query($con,$sql);
		}
	}else{

		$sql = "INSERT INTO equipments (categories_id, equ_number, equ_name, equ_detail, equ_quantity, units, fisd_years, equ_status) VALUES('".$categories_id."','".$equ_number."','".$equ_name."','".$equ_detail."','".$equ_quantity."','".$units."','".$fisd_years."','".$equ_status."')";
		mysqli_query($con,$sql);
	}
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('เพิ่มข้อมูลเรียบร้อย');
		window.location.href='manage_equipment.php';
		</script>"); 
	
}

function editEquipments($equipments_id,$categories_id,$equ_number,$equ_name,$equ_detail,$equ_quantity,$units,$fisd_years,$equ_img,$equ_status){

	global $con;

	if($equ_img != null){
		if(move_uploaded_file($_FILES["equ_img"]["tmp_name"],"images/equipment/".$_FILES["equ_img"]["name"]))
		{
			$sql="UPDATE equipments SET categories_id='".$categories_id."',equ_number='".$equ_number."',equ_name='".$equ_name."',equ_detail='".$equ_detail."',equ_quantity='".$equ_quantity."',units='".$units."',fisd_years='".$fisd_years."',equ_img='".$_FILES["equ_img"]["name"]."',equ_status='".$equ_status."' WHERE id = '".$id."'";
			mysqli_query($con,$sql);
		}
	}else{
		$sql="UPDATE equipments SET categories_id='".$categories_id."',equ_number='".$equ_number."',equ_name='".$equ_name."',equ_detail='".$equ_detail."',equ_quantity='".$equ_quantity."',units='".$units."',fisd_years='".$fisd_years."',equ_status='".$equ_status."' WHERE equipments_id = '".$equipments_id."'";
		mysqli_query($con,$sql);
		

	}
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='manage_equipment.php';
		</script>"); 
	
}

function normalEquipments($equipments_id){

	global $con;
	$sql="UPDATE equipments SET equ_status='1' WHERE equipments_id = '".$equipments_id."'";
	mysqli_query($con,$sql);

	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='manage_equipment.php';
		</script>"); 
	
}

function cancelEquipments($equipments_id){

	global $con;
	$sql="UPDATE equipments SET equ_status='2' WHERE equipments_id = '".$equipments_id."'";
	mysqli_query($con,$sql);

	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('แก้ไขข้อมูลเรียบร้อย');
		window.location.href='manage_equipment.php';
		</script>"); 
	
}

function deleteEquipments($equipments_id){
	global $con;

	mysqli_query($con,"DELETE FROM equipments WHERE equipments_id='".$equipments_id."'");
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลบข้อมูลเรียบร้อยแล้ว');
		window.location.href='manage_equipment.php';
		</script>"); 

}

function getAllEquipments(){
	global $con;

	$sql = "SELECT *  
	FROM equipments e 
	LEFT JOIN categories c ON e.categories_id = c.categories_id
	ORDER BY e.equipments_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'equipments_id' => $row['equipments_id'],
			'categories_id' => $row['categories_id'],
			'equ_number' => $row['equ_number'],
			'equ_name' => $row['equ_name'],
			'equ_detail' => $row['equ_detail'],
			'equ_quantity' => $row['equ_quantity'],
			'units' => $row['units'],
			'fisd_years' => $row['fisd_years'],
			'equ_img' => $row['equ_img'],
			'equ_status' => $row['equ_status'],
			'cate_name' => $row['cate_name']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllEquipmentsForBooking(){
	global $con;

	$sql = "SELECT *  
	FROM equipments e 
	LEFT JOIN categories c ON e.categories_id = c.categories_id
	WHERE e.equ_status = '1' AND e.equ_quantity <> '0'
	ORDER BY e.equipments_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'equipments_id' => $row['equipments_id'],
			'categories_id' => $row['categories_id'],
			'equ_number' => $row['equ_number'],
			'equ_name' => $row['equ_name'],
			'equ_detail' => $row['equ_detail'],
			'equ_quantity' => $row['equ_quantity'],
			'units' => $row['units'],
			'fisd_years' => $row['fisd_years'],
			'equ_img' => $row['equ_img'],
			'equ_status' => $row['equ_status'],
			'cate_name' => $row['cate_name']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllEquipmentsNormal(){
	global $con;

	$sql = "SELECT *  
	FROM equipments e 
	LEFT JOIN categories c ON e.categories_id = c.categories_id
	WHERE e.equ_status = '1' 
	ORDER BY e.equipments_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'equipments_id' => $row['equipments_id'],
			'categories_id' => $row['categories_id'],
			'equ_number' => $row['equ_number'],
			'equ_name' => $row['equ_name'],
			'equ_detail' => $row['equ_detail'],
			'equ_quantity' => $row['equ_quantity'],
			'units' => $row['units'],
			'fisd_years' => $row['fisd_years'],
			'equ_img' => $row['equ_img'],
			'equ_status' => $row['equ_status'],
			'cate_name' => $row['cate_name']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getCurrentEquipments($equipments_id){

	global $con;
	$sql = "SELECT *  
	FROM equipments e 
	LEFT JOIN categories c ON e.categories_id = c.categories_id
	WHERE e.equipments_id = '".$equipments_id."'";
	$res = mysqli_query($con,$sql);
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}
function saveBorrows($users_id,$borrow_date,$due_date,$start_time,$end_time,$details,$equipments_id,$amount,$amount_old){
	global $con;
	$arrDate2 = explode("/", $borrow_date);
	$convert_borrow_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];
	$arrDate1 = explode("/", $due_date);
	$convert_due_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	

	$sql = "INSERT INTO borrows (users_id, borrow_date, due_date, start_time, end_time, details, status) VALUES('".$users_id."','".$convert_borrow_date."','".$convert_due_date."','".$start_time."','".$end_time."','".$details."','1')";

	mysqli_query($con,$sql);

	$last_id = $con->insert_id;
	
	foreach( $equipments_id as $key => $ei ) {
		if ($ei != "") {
			$sql_equipments = "select * from equipments where equipments_id = '".$ei."'";
			$res = mysqli_query($con,$sql_equipments);
			
			while($row = mysqli_fetch_array($res)) {
				$data['equ_quantity'] = $row['equ_quantity'];

			}

			$am = $amount[$key];
			$balance = $data['equ_quantity'] - $am;
			$sql_detail = "INSERT INTO borrows_detail (borrows_id, equipments_id, amount) VALUES ('".$last_id."','".$ei."','".$am."')";
			mysqli_query($con,$sql_detail);
			$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE equipments_id = '".$ei."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='user_borrow.php';
		</script>"); 
	
}

function editBorrows($borrows_id,$users_id,$borrow_date,$due_date,$start_time,$end_time,$details,$equipments_id,$amount,$amount_old){
	global $con;

	$arrDate2 = explode("/", $borrow_date);
	$convert_borrow_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];
	$arrDate1 = explode("/", $due_date);
	$convert_due_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];

	$sql="UPDATE borrows SET users_id='".$users_id."',borrow_date='".$convert_borrow_date."',due_date='".$convert_due_date."',start_time='".$start_time."',end_time='".$end_time."',details='".$details."' WHERE borrows_id = '".$borrows_id."'";
	mysqli_query($con,$sql);

	mysqli_query($con,"DELETE FROM borrows_detail WHERE borrows_id = '".$borrows_id."'");
	
	foreach( $equipments_id as $key => $ei ) {
		if ($ei != "") {
			$sql_equipments = "select * from equipments where equipments_id = '".$ei."'";
			$res = mysqli_query($con,$sql_equipments);
			
			while($row = mysqli_fetch_array($res)) {
				$data['equ_quantity'] = $row['equ_quantity'];

			}

			$am = $amount[$key];
			$ao = $amount_old[$key];
			$balance = $data['equ_quantity'] - $am;
			$sql_detail = "INSERT INTO borrows_detail (borrows_id, equipments_id, amount) VALUES ('".$borrows_id."','".$ei."','".$am."')";
			mysqli_query($con,$sql_detail);
			$totalbalance = $balance + $ao;
			$sql_update_equ = "UPDATE equipments SET equ_quantity='".$totalbalance."' WHERE equipments_id = '".$ei."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='user_borrow.php';
		</script>"); 
	
}
/*
function saveBorrows($users_id,$date_use,$date_return,$start_time,$end_time,$detail,$equipments_id,$amount,$borrow_gallery,$total){
	global $con;
	$arrDate2 = explode("/", $date_use);
	$convert_date_use = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];
	$arrDate1 = explode("/", $date_return);
	$convert_date_return = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	

	$sql = "INSERT INTO borrows (users_id, date_use, date_return, start_time, end_time, detail, status) VALUES('".$users_id."','".$convert_date_use."','".$convert_date_return."','".$start_time."','".$end_time."','".$detail."','1')";

	mysqli_query($con,$sql);

	$last_id = $con->insert_id;
	
	foreach( $equipments_id as $key => $ei ) {
		if ($ei != "") {
			$sql_equipments = "select * from equipments where id = '".$ei."'";
			$res = mysqli_query($con,$sql_equipments);
			
			while($row = mysqli_fetch_array($res)) {
				$data['equ_quantity'] = $row['equ_quantity'];

			}

			$am = $amount[$key];
			$balance = $data['equ_quantity'] - $am;
			$sql_detail = "INSERT INTO borrows_detail (borrows_id, equipments_id, amount) VALUES ('".$last_id."','".$ei."','".$am."')";
			mysqli_query($con,$sql_detail);
			$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE id = '".$ei."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}

	for( $i=0 ; $i < $total ; $i++ ) {
		$tmpFilePath = $_FILES['borrow_gallery']['tmp_name'][$i];
		if ($tmpFilePath != ""){
			$newFilePath = "images/borrow_gallery/" . $_FILES['borrow_gallery']['name'][$i];
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				$sql_detail = "INSERT INTO borrows_gallery (borrows_id, borrow_images) VALUES ('".$last_id."','".$_FILES['borrow_gallery']['name'][$i]."')";
				mysqli_query($con,$sql_detail);
			}
		}
	}


	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='user_borrow.php';
		</script>"); 
	
}

function editBorrows($id,$users_id,$date_use,$date_return,$start_time,$end_time,$detail,$equipments_id,$amount,$borrow_gallery,$total){
	global $con;

	$arrDate2 = explode("/", $date_use);
	$convert_date_use = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];
	$arrDate1 = explode("/", $date_return);
	$convert_date_return = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];

	$sql="UPDATE borrows SET users_id='".$users_id."',date_use='".$convert_date_use."',date_return='".$convert_date_return."',start_time='".$start_time."',end_time='".$end_time."',detail='".$detail."' WHERE id = '".$id."'";
	mysqli_query($con,$sql);

	mysqli_query($con,"DELETE FROM borrows_detail WHERE borrows_id = '".$id."'");
	
	foreach( $equipments_id as $key => $ei ) {
		if ($ei != "") {
			$sql_equipments = "select * from equipments where id = '".$ei."'";
			$res = mysqli_query($con,$sql_equipments);
			
			while($row = mysqli_fetch_array($res)) {
				$data['equ_quantity'] = $row['equ_quantity'];

			}

			$am = $amount[$key];
			$balance = $data['equ_quantity'] - $am;
			$sql_detail = "INSERT INTO borrows_detail (borrows_id, equipments_id, amount) VALUES ('".$id."','".$ei."','".$am."')";
			mysqli_query($con,$sql_detail);
			$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE id = '".$ei."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}

	if($total > 1){
			mysqli_query($con,"DELETE FROM borrows_gallery WHERE borrows_id = '".$id."'");
			for( $i=0 ; $i < $total ; $i++ ) {
				$tmpFilePath = $_FILES['borrow_gallery']['tmp_name'][$i];
				if ($tmpFilePath != ""){
					$newFilePath = "images/borrow_gallery/" . $_FILES['borrow_gallery']['name'][$i];
					if(move_uploaded_file($tmpFilePath, $newFilePath)) {
						$sql_detail = "INSERT INTO borrows_gallery (borrows_id, borrow_images) VALUES ('".$id."','".$_FILES['borrow_gallery']['name'][$i]."')";
						mysqli_query($con,$sql_detail);

					}
				}
			}
		}


	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='user_borrow.php';
		</script>"); 
	
}
*/
function deleteBorrows($borrows_id){
	global $con;

	mysqli_query($con,"DELETE FROM borrows WHERE borrows_id='".$borrows_id."'");
	mysqli_query($con,"DELETE FROM borrows_detail WHERE borrows_id='".$borrows_id."'");
	mysqli_query($con,"DELETE FROM borrows_gallery WHERE borrows_id='".$borrows_id."'");
	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลบข้อมูลเรียบร้อยแล้ว');
		window.location.href='user_borrow.php';
		</script>"); 

}

function cancelBorrows($borrows_id){
	global $con;

	$sqlBo="UPDATE borrows SET status='0' WHERE borrows_id = '".$borrows_id."'";
	mysqli_query($con,$sqlBo);

	$data = array();
	$data2 = array();
	$sql = "select * from borrows_detail where borrows_id = '".$borrows_id."' ";
	$res = mysqli_query($con,$sql);
		
	while($row = mysqli_fetch_array($res)) {
		$data['equipments_id'] = $row['equipments_id'];
		$data['amount'] = $row['amount'];

		$sql_equipments = "select * from equipments where equipments_id = '".$data['equipments_id']."'";
		$res2 = mysqli_query($con,$sql_equipments);
			
		while($row2 = mysqli_fetch_array($res2)) {
			$data2['equ_quantity'] = $row2['equ_quantity'];
		}

		$balance = $data2['equ_quantity'] + $data['amount'];
		$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE equipments_id = '".$data['equipments_id']."' ";
		mysqli_query($con,$sql_update_equ);
	}

	mysqli_close($con);
	echo ("<script language='JavaScript'>
		alert('ลบข้อมูลเรียบร้อยแล้ว');
		window.location.href='user_borrow.php';
		</script>"); 

}

function getAllBorrows(){
	global $con;
	$sql = "SELECT * 
	FROM borrows b 
	LEFT JOIN users u ON b.users_id = u.users_id 
	ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllBorrowsByUserId($users_id){
	global $con;
	$sql = "SELECT *  
	FROM borrows b 
	LEFT JOIN users u ON b.users_id = u.users_id 
	WHERE b.users_id = '".$users_id."' AND b.status <> '4' 
	ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllBorrowsDashboard(){
	global $con;
	$sql = "SELECT * FROM borrows b LEFT JOIN users u ON b.users_id = u.users_id WHERE b.status <> '4' ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllHistoryBorrowsByUserId($users_id){
	global $con;
	$sql = "SELECT * FROM borrows b LEFT JOIN users u ON b.users_id = u.users_id WHERE b.users_id = '".$users_id."' ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllHistoryBorrows(){
	global $con;
	$sql = "SELECT * FROM borrows b LEFT JOIN users u ON b.users_id = u.users_id ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllBorrowsWait(){
	global $con;
	$sql = "SELECT *  
	FROM borrows b 
	LEFT JOIN users u ON b.users_id = u.users_id 
	WHERE b.status <> '4' 
	ORDER BY b.borrows_id DESC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function formatDateFull($date){
	if($date=="0000-00-00"){
		return "";
	}
	if($date=="")
		return $date;
	$raw_date = explode("-", $date);
	return  $raw_date[2] . "/" . $raw_date[1] . "/" . $raw_date[0];
}

function getCurrentBorrows($id){

	global $con;

	$res = mysqli_query($con,"SELECT * FROM borrows b LEFT JOIN users u ON b.users_id = u.users_id WHERE b.borrows_id = '".$id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function getAllBorrowsEquipments($borrows_id){
	global $con;

	$sql = "SELECT *  
	FROM borrows_detail bd 
	LEFT JOIN equipments e ON bd.equipments_id = e.equipments_id 
	LEFT JOIN categories c ON e.categories_id = c.categories_id 
	WHERE bd.borrows_id = '".$borrows_id."' 
	ORDER BY bd.borrows_detail_id  ASC";
	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_detail_id' => $row['borrows_detail_id'],
			'bdid' => $row['bdid'],
			'equipments_id' => $row['equipments_id'],
			'amount_return' => $row['amount_return'],
			'equ_name' => $row['equ_name'],
			'cate_name' => $row['cate_name'],
			'units' => $row['units'],
			'amount' => $row['amount']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function approveBorrows($borrows_id,$status){
	global $con;

	if($status == 3){
		$data = array();
		$data2 = array();
		$sql = "select * from borrows_detail where borrows_id = '".$borrows_id."' ";
		$res = mysqli_query($con,$sql);
		
		while($row = mysqli_fetch_array($res)) {
			$data['equipments_id'] = $row['equipments_id'];
			$data['amount'] = $row['amount'];

			$sql_equipments = "select * from equipments where equipments_id = '".$data['equipments_id']."'";
			$res2 = mysqli_query($con,$sql_equipments);
			
			while($row2 = mysqli_fetch_array($res2)) {
				$data2['equ_quantity'] = $row2['equ_quantity'];
			}

			$balance = $data2['equ_quantity'] + $data['amount'];
			$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE equipments_id = '".$data['equipments_id']."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}

	$sql="UPDATE borrows SET status='".$status."' WHERE borrows_id = '".$borrows_id."'";
	mysqli_query($con,$sql);
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='check_borrow.php';
		</script>"); 
	
}

function uploadBorrowImage($borrows_id,$borrow_gallery,$total){
	global $con;

	for( $i=0 ; $i < $total ; $i++ ) {
		$tmpFilePath = $_FILES['borrow_gallery']['tmp_name'][$i];
		if ($tmpFilePath != ""){
			$newFilePath = "images/borrow_gallery/" . $_FILES['borrow_gallery']['name'][$i];
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				$sql_detail = "INSERT INTO borrows_gallery (borrows_id, borrow_images) VALUES ('".$borrows_id."','".$_FILES['borrow_gallery']['name'][$i]."')";
				mysqli_query($con,$sql_detail);
			}
		}
	}
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='check_borrow.php';
		</script>"); 
	
}

function returnBorrows($borrows_id,$return_gallery,$total){
	global $con;

	$sqlBo="UPDATE borrows SET status='4' WHERE borrows_id = '".$borrows_id."'";
	mysqli_query($con,$sqlBo);

	$data = array();
	$data2 = array();
	$sql = "select * from borrows_detail where borrows_id = '".$borrows_id."' ";
	$res = mysqli_query($con,$sql);
		
	while($row = mysqli_fetch_array($res)) {
		$data['equipments_id'] = $row['equipments_id'];
		$data['amount'] = $row['amount'];

		$sql_equipments = "select * from equipments where equipments_id = '".$data['equipments_id']."'";
		$res2 = mysqli_query($con,$sql_equipments);
			
		while($row2 = mysqli_fetch_array($res2)) {
			$data2['equ_quantity'] = $row2['equ_quantity'];
		}

		$balance = $data2['equ_quantity'] + $data['amount'];
		$sql_update_equ = "UPDATE equipments SET equ_quantity='".$balance."' WHERE equipments_id = '".$data['equipments_id']."' ";
		mysqli_query($con,$sql_update_equ);
	}

	for( $i=0 ; $i < $total ; $i++ ) {
		$tmpFilePath = $_FILES['return_gallery']['tmp_name'][$i];
		if ($tmpFilePath != ""){
			$newFilePath = "images/return_gallery/" . $_FILES['return_gallery']['name'][$i];
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				$sql_detail = "INSERT INTO returns_gallery (borrows_id, return_images) VALUES ('".$borrows_id."','".$_FILES['return_gallery']['name'][$i]."')";
				mysqli_query($con,$sql_detail);
			}
		}
	}
	
	mysqli_close($con);

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='check_borrow.php';
		</script>"); 
	
}

function dateThaiFull($strDate){
	$strYear = date("Y",strtotime($strDate))+543;
	$strMonth= date("n",strtotime($strDate));
	$strDay= date("j",strtotime($strDate));
	$strHour= date("H",strtotime($strDate));
	$strMinute= date("i",strtotime($strDate));
	$strSeconds= date("s",strtotime($strDate));
	$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear";
}

function getReportBorrowDate($start_date,$end_date){
	$arrDate1 = explode("/", $start_date);
	$convert_start_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	$arrDate2 = explode("/", $end_date);
	$convert_end_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];
	global $con;
	$sql = "SELECT *,b.id as bid,b.status as bstatus 
	FROM borrows b 
	LEFT JOIN users u ON b.user_id = u.id
	WHERE (b.date_use BETWEEN '".$convert_start_date."' AND '".$convert_end_date."')
	ORDER BY b.id DESC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'id' => $row['bid'],
			'firstname' => $row['firstname'],
			'date_return' => $row['date_return'],
			'lastname' => $row['lastname'],
			'detail' => $row['detail'],
			'date_use' => $row['date_use'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'status' => $row['bstatus']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function editReturns($id,$bdid,$amount_return,$equ_id){
	global $con;

	foreach( $bdid as $key => $bd_id ) {
		if ($bd_id != "") {
			$eqid = $equ_id[$key];
			$amr = $amount_return[$key];

			$sql_equipments = "select * from equipments where id = '".$eqid."'";
			$res = mysqli_query($con,$sql_equipments);
			
			while($row = mysqli_fetch_array($res)) {
				$data['amount'] = $row['amount'];

			}
			
			$balance = $data['amount'] + $amr;
			mysqli_query($con,"UPDATE borrows SET status='1' WHERE id = '".$id."' ");
			$sql_update_bal = "UPDATE equipments SET amount='".$balance."' WHERE id = '".$eqid."' ";
			mysqli_query($con,$sql_update_bal);
			$sql_update_equ = "UPDATE borrows_detail SET amount_return='".$amr."' WHERE id = '".$bd_id."' ";
			mysqli_query($con,$sql_update_equ);
		}
	}


	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='manage_borrow.php';
		</script>"); 
	
}

function updateReturnBorrow($id){
	global $con;

	mysqli_query($con,"UPDATE borrows SET status='2' WHERE id = '".$id."' ");

	echo ("<script language='JavaScript'>
		alert('บันทึกข้อมูลเรียบร้อย');
		window.location.href='manage_all_borrow.php';
		</script>"); 
	
}

function getAllStatisticChart($start_date,$end_date){
	global $con;

	$arrDate1 = explode("/", $start_date);
	$convert_start_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	$arrDate2 = explode("/", $end_date);
	$convert_end_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];

	$sql = "SELECT e.equ_name,SUM(bd.amount) as sumAmount   
	FROM borrows b 
	LEFT JOIN borrows_detail bd ON b.borrows_id = bd.borrows_id 
	LEFT JOIN equipments e ON bd.equipments_id = e.equipments_id
	WHERE (b.borrow_date BETWEEN '".$convert_start_date."' AND '".$convert_end_date."')
	GROUP BY bd.equipments_id
	ORDER BY b.borrows_id DESC";

	$res = mysqli_query($con,$sql);

	$jsonArray = array();

	//$arrData["data"] = array();

	while($row = mysqli_fetch_array($res)) {
		array_push($jsonArray, array('y' => $row['sumAmount'], 'label' => $row['equ_name']));
	}


	return $jsonArray;

	mysqli_close($con);
}

function getAllDataStatisticChart($start_date,$end_date){
	$arrDate1 = explode("/", $start_date);
	$convert_start_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	$arrDate2 = explode("/", $end_date);
	$convert_end_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];

	global $con;

	$sql = "SELECT e.equ_name,SUM(bd.amount) as sumAmount,e.units  
	FROM borrows b 
	LEFT JOIN borrows_detail bd ON b.borrows_id = bd.borrows_id 
	LEFT JOIN equipments e ON bd.equipments_id = e.equipments_id 
	WHERE (b.borrow_date BETWEEN '".$convert_start_date."' AND '".$convert_end_date."')
	GROUP BY bd.equipments_id
	ORDER BY b.borrows_id DESC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'equ_name' => $row['equ_name'],
			'units' => $row['units'],
			'sumAmount' => $row['sumAmount']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllDashboardChart($months){
	global $con;
	$sql = "SELECT equ_name,SUM(bd.amount) as sumAmount,m.meas_name  
	FROM borrows b 
	LEFT JOIN borrows_detail bd ON b.id = bd.borrows_id 
	LEFT JOIN equipments e ON bd.equipments_id = e.id
	LEFT JOIN measures m ON e.measure_id = m.id
	WHERE MONTH(b.date_use) = '".$months."'
	GROUP BY bd.equipments_id
	ORDER BY b.id DESC";

	$res = mysqli_query($con,$sql);

	$jsonArray = array();

	//$arrData["data"] = array();

	while($row = mysqli_fetch_array($res)) {
		array_push($jsonArray, array('y' => $row['sumAmount'], 'label' => $row['equ_name']));
	}


	return $jsonArray;

	mysqli_close($con);
}

function getAllDataDashboardChart($months){
	global $con;

	$sql = "SELECT equ_name,SUM(bd.amount) as sumAmount,m.meas_name  
	FROM borrows b 
	LEFT JOIN borrows_detail bd ON b.id = bd.borrows_id 
	LEFT JOIN equipments e ON bd.equipments_id = e.id 
	LEFT JOIN measures m ON e.measure_id = m.id
	WHERE MONTH(b.date_use) = '".$months."'
	GROUP BY bd.equipments_id
	ORDER BY b.id DESC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'equ_name' => $row['equ_name'],
			'meas_name' => $row['meas_name'],
			'sumAmount' => $row['sumAmount']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getCheckBorrow($borrows_id){

	global $con;

	$res = mysqli_query($con,"SELECT COUNT(*) as numCount FROM borrows_gallery WHERE borrows_id = '".$borrows_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function getCheckReturn($borrows_id){

	global $con;

	$res = mysqli_query($con,"SELECT COUNT(*) as numCount FROM returns_gallery WHERE borrows_id = '".$borrows_id."'");
	$result=mysqli_fetch_array($res,MYSQLI_ASSOC);
	return $result;

	mysqli_close($con);

}

function getAllImageBorrow($borrows_id){
	global $con;

	$sql = "SELECT *   
	FROM borrows_gallery  
	WHERE borrows_id = '".$borrows_id."'
	ORDER BY borrows_gallery_id ASC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_gallery_id' => $row['borrows_gallery_id'],
			'borrows_id' => $row['borrows_id'],
			'borrow_images' => $row['borrow_images']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getAllImageReturn($borrows_id){
	global $con;

	$sql = "SELECT *   
	FROM returns_gallery  
	WHERE borrows_id = '".$borrows_id."'
	ORDER BY returns_gallery_id ASC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'returns_gallery_id' => $row['returns_gallery_id'],
			'borrows_id' => $row['borrows_id'],
			'return_images' => $row['return_images']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

function getReportBorrowPdf($start_date,$end_date){
	global $con;
	
	$arrDate1 = explode("/", $start_date);
	$convert_start_date = $arrDate1[2].'-'.$arrDate1[1].'-'.$arrDate1[0];
	$arrDate2 = explode("/", $end_date);
	$convert_end_date = $arrDate2[2].'-'.$arrDate2[1].'-'.$arrDate2[0];

	$sql = "SELECT * 
	FROM borrows b 
	LEFT JOIN users u ON b.users_id = u.users_id 
	WHERE (b.borrow_date BETWEEN '".$convert_start_date."' AND '".$convert_end_date."')
	ORDER BY b.borrows_id DESC";

	$res = mysqli_query($con,$sql);

	$data = array();
	while($row = mysqli_fetch_assoc($res)) {
		$namesArray[] = array(
			'borrows_id' => $row['borrows_id'],
			'users_id' => $row['users_id'],
			'firstname' => $row['firstname'],
			'lastname' => $row['lastname'],
			'borrow_date' => $row['borrow_date'],
			'due_date' => $row['due_date'],
			'start_time' => $row['start_time'],
			'end_time' => $row['end_time'],
			'details' => $row['details'],
			'last_update' => $row['last_update'],
			'status' => $row['status']);
	}

	$data = $namesArray;

	return $data;
	mysqli_close($con);

}

?>