<!DOCTYPE html>
<html lang="en">
<?php
require_once("header.php");
?>
<?php
$currentUsers = getCurrentUsers($_SESSION["id"]);
$currentBorrows = getCurrentBorrows($_GET["borrows_id"]);
$allEquipments = getAllEquipmentsForBooking();
$allBorrowsEquipments = getAllBorrowsEquipments($_GET["borrows_id"]);

if(isset($_POST["submit"])){
  if($_POST["borrows_id"] == ""){
    $equipments_id = $_POST["equipments_id"];
    $amount = $_POST["amount"];
    $amount_old = $_POST["amount_old"];
    saveBorrows($_POST["users_id"],$_POST["borrow_date"],$_POST["due_date"],$_POST["start_time"],$_POST["end_time"],$_POST["details"],$equipments_id,$amount,$amount_old);
  }else{
    $equipments_id = $_POST["equipments_id"];
    $amount = $_POST["amount"];
    $amount_old = $_POST["amount_old"];
    editBorrows($_POST["borrows_id"],$_POST["users_id"],$_POST["borrow_date"],$_POST["due_date"],$_POST["start_time"],$_POST["end_time"],$_POST["details"],$equipments_id,$amount,$amount_old);
  }
}


?>

<body class="g-sidenav-show  bg-gray-100">
  <?php
  require_once("side_bar.php");
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
    require_once("nav.php");
    ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <form name="prduct_detail_form" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="borrows_id" value="<?php echo $_GET["borrows_id"];?>">
        <input type="hidden" class="form-control" name="users_id" value="<?php echo $_SESSION["id"];?>">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">จองวัสดุ</h4>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ชื่อ</label>
                      <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $currentUsers["firstname"];?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">นามสกุล</label>
                      <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $currentUsers["lastname"];?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">สังกัด</label>
                      <input type="text" class="form-control" name="program" id="program" value="<?php echo $currentUsers["program"];?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่ยืม</label>
                      <input type="text" class="form-control" name="borrow_date" id="borrow_date" value="<?php echo formatDateFull($currentBorrows["borrow_date"]);?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่คืน</label>
                      <input type="text" class="form-control" name="due_date" id="due_date" value="<?php echo formatDateFull($currentBorrows["due_date"]);?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">เวลาเริ่มต้น</label>
                      <input type="text" class="form-control" name="start_time" id="start_time" value="<?php echo substr($currentBorrows["start_time"], 0,5);?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">เวลาสิ้นสุด</label>
                      <input type="text" class="form-control" name="end_time" id="end_time" value="<?php echo substr($currentBorrows["end_time"], 0,5);?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">วัตถุประสงค์</label>
                      <input type="text" class="form-control" name="details" id="details" value="<?php echo $currentBorrows["details"];?>">
                    </div>
                  </div>
                </div>

                <fieldset>
                  <legend>วัสดุที่ใช้</legend> 
                  <input type="button" style="float:right;margin-right:50px;" value="ลบ" class="btn btn-danger" onclick="deleteRow('dataTable')" />
                  <input type="button" style="float:right;margin-right:50px;" id="add_row" value="เพิ่ม" class="btn btn-primary" onclick="addRow('dataTable')" />
                  <table class="table table-striped" id="dataTable">
                    <thead>
                      <th></th>
                      <th style="text-align:center;"><label>วัสดุ</label></th>
                      <th style="text-align:center;"><label>จำนวนคงคลัง</label></th>
                      <th style="text-align:center;"><label>จำนวนที่เบิก</label></th>
                    </thead>
                    <tbody>

                      <?php if(empty($allBorrowsEquipments)){ ?>
                        <?php for($i=0;$i<5;$i++){ ?>
                          <tr>
                            <td style="width:5%;"><input type="checkbox" name="chk2"/></td>
                            <td style="width:55%;">
                              <select name="equipments_id[]" class="form-control product" id="product<?php echo $i;?>" >
                                <option value="">-- โปรดเลือก --</option>
                                <?php foreach($allEquipments as $dataEqu1){ ?>
                                  <option value="<?php echo $dataEqu1['equipments_id'];?>" <?php echo $selected;?>><?php echo $dataEqu1['equ_name'];?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td style="width:20%;text-align: center;">
                              <label class="bmd-label-floating" id="lbamount_have<?php echo $i;?>"></label>
                              <input type="hidden" class="form-control border-input" name="amount_have[]" id="amount_have<?php echo $i;?>" placeholder="จำนวน" readonly>
                              
                            </td>
                            <td style="width:20%;">
                              <input type="text" class="form-control border-input amount" name="amount[]" id="amount<?php echo $i;?>" placeholder="จำนวน">
                              <input type="hidden" class="form-control border-input" name="amount_old[]" id="amount_old<?php echo $i;?>" placeholder="จำนวน" readonly value="0">
                            </td>

                          </tr>
                        <?php } ?>
                      <?php }else{?>
                        <?php $i = 0;?>
                        <?php foreach($allBorrowsEquipments as $dataBorrow){ ?>
                          <?php $i++;?>
                          <?php $currentEquipments = getCurrentEquipments($dataBorrow['equipments_id']);?>
                          <tr>
                            <td style="width:5%;"><input type="checkbox" name="chk2"/></td>
                            <td style="width:55%;">
                              <select name="equipments_id[]" class="form-control product" id="product<?php echo $i;?>" >
                                <option value="">-- โปรดเลือก --</option>
                                <?php foreach($allEquipments as $dataEqu1){ ?>
                                  <?php $selected = ""; 
                                  if($dataBorrow['equipments_id'] == $dataEqu1['equipments_id']){
                                    $selected = " selected"; 

                                  } 
                                  ?> 
                                  <option value="<?php echo $dataEqu1['equipments_id'];?>" <?php echo $selected;?>><?php echo $dataEqu1['equ_name'];?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td style="width:20%;text-align: center;">
                              <label class="bmd-label-floating" id="lbamount_have<?php echo $i;?>"><?php echo $currentEquipments["equ_quantity"];?></label>
                              <input type="hidden" class="form-control border-input" name="amount_have[]" id="amount_have<?php echo $i;?>" placeholder="จำนวน" readonly>
                              
                            </td>
                            <td style="width:20%;">
                              <input type="text" class="form-control border-input amount" name="amount[]" id="amount<?php echo $i;?>" placeholder="จำนวน" value="<?php echo $dataBorrow['amount'];?>">
                              <input type="hidden" class="form-control border-input" name="amount_old[]" id="amount_old<?php echo $i;?>" placeholder="จำนวน" readonly value="<?php echo $dataBorrow['amount'];?>">
                            </td>

                          </tr>
                        <?php } ?>
                      <?php } ?>



                    </tbody>
                  </table>
                </fieldset>

                <div align="center">
                  <input type="submit" name="submit" class="btn btn-success btn-round" value="บันทึก">
                  <input type="button" name="button" class="btn btn-danger btn-round" onClick="javascript:history.go(-1)" value="ย้อนกลับ">

                </div>
                <div class="clearfix"></div>

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-profile">
              <img class="img-fluid shadow border-radius-xl" src="images/user_ico.png" />
            </div>
          </div>
        </div>

      </form>
      <?php
      require_once("footer.php");
      ?>
      <script>

        var today = new Date();

        $('#borrow_date').datetimepicker({
          lang:'th',
          minDate:today,
          timepicker:false,
          format:'d/m/Y'
        });
        $('#due_date').datetimepicker({
          lang:'th',
          minDate:today,
          timepicker:false,
          format:'d/m/Y'
        });
        $('#start_time').datetimepicker({
          lang:'th',
          timepicker:true,
          datepicker:false,
          format:'H:i'
        });
        $('#end_time').datetimepicker({
          lang:'th',
          timepicker:true,
          datepicker:false,
          format:'H:i'
        });
      </script>

      <script language="javascript">

        function addRow(tableID) {

          var table = document.getElementById(tableID);

          var rowCount = table.rows.length;

          var row = table.insertRow(rowCount);

          var cell0 = row.insertCell(0);
          var element0 = document.createElement("input");
          element0.type = "checkbox";
          element0.name="chkbox";
          cell0.appendChild(element0);


          var cell1 = row.insertCell(1);
          var element1 = document.createElement("select");
          element1.id = 'product'+rowCount;
          element1.name = 'equipments_id[]';
          element1.setAttribute('class', 'form-control product');
          element1.addEventListener('change', getDataFromDropdown);
          cell1.appendChild(element1);
          var option = document.createElement("option");
          option.value = '';
          option.appendChild(document.createTextNode("-- โปรดเลือก --"));
          element1.appendChild(option);

          <?php foreach($allEquipments as $dataNew){ ?>
            var option = document.createElement("option");
            option.value = '<?php echo $dataNew["equipments_id"]?>';
            option.appendChild(document.createTextNode("<?php echo $dataNew['equ_name']?>"));
            element1.appendChild(option);
          <?php } ?>

          var cell2 = row.insertCell(2);
          var element2 = document.createElement("input");
          element2.type = "hidden";
          element2.name = "amount_have[]";
          element2.id = "amount_have"+rowCount;
          element2.setAttribute('readonly','true');
          element2.className = "form-control amount";
          cell2.appendChild(element2);

          var cell21 = row.insertCell(2);
          var element21 = document.createElement("label");
          element21.id = "lbamount_have"+rowCount;
          element21.className = "bmd-label-floating";
          cell21.style.textAlign = "center";
          cell21.appendChild(element21);

          var cell3 = row.insertCell(3);
          var element3 = document.createElement("input");
          element3.type = "text";
          element3.name = "amount[]";
          element3.id = "amount"+rowCount;
          element3.className = "form-control";
          element3.addEventListener('change', checkQuantity);
          cell3.appendChild(element3);

          var cell31 = row.insertCell(3);
          var element31 = document.createElement("input");
          element31.type = "hidden";
          element31.name = "amount_old[]";
          element31.id = "amount_old"+rowCount;
          element31.className = "form-control";
          cell31.appendChild(element31);

        }

        function deleteRow(tableID) {
          try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++) {
              var row = table.rows[i];
              var chkbox = row.cells[0].childNodes[0];
              if(null != chkbox && true == chkbox.checked) {
                table.deleteRow(i);
                rowCount--;
                i--;
              }


            }
          }catch(e) {
            alert(e);
          }
        }



      </script>

      <script>
        $(document).ready(function(){

          $('.product').on('change', function() {
            if ($(this).val() != ""){
              var id = $(this).attr('id');
              var sub_id = id.substring(9, 7);
              var pro_id = $('#product'+sub_id).val();
              $.get('api/api.php?load=product&pro_id='+pro_id,function(data){
                pro_line = jQuery.parseJSON(data);
                for (var i = 0, len = pro_line.length; i < len; i++) {
                  $('#lbamount_have'+sub_id).text(pro_line[i].equ_quantity);
                  $('#amount_have'+sub_id).val(pro_line[i].equ_quantity);
                }


              });



            }

          });


          $('.amount').on('change',function() {

            var id = $(this).attr('id');

            var sub_id = id.substring(8, 6);

            var amount_have = parseInt($('#amount_have'+sub_id).val(), 10);

            var amount = parseInt($('#amount'+sub_id).val(), 10);

            if(amount > amount_have){
              alert("จำนวนในคลังไม่เพียงพอ");
              $('#amount'+sub_id).val(0);
            }



          });

        });
      </script>

      <script>
        function getDataFromDropdown(){

          if ($(this).val() != ""){
            var id = $(this).attr('id');
            var sub_id = id.substring(9,7);
            var pro_id = $('#product'+sub_id).val();
            $.get('api/api.php?load=product&pro_id='+pro_id,function(data){
              equ_line = jQuery.parseJSON(data);
              for (var i = 0, len = equ_line.length; i < len; i++) {
                $('#lbamount_have'+sub_id).text(equ_line[i].equ_quantity);
                $('#amount_have'+sub_id).val(equ_line[i].equ_quantity);
              }


            });
          }


        }

        function checkQuantity(){

            var id = $(this).attr('id');

            var sub_id = id.substring(8, 6);
            
            var amount_have = parseInt($('#amount_have'+sub_id).val(), 10);
            var amount = parseInt($('#amount'+sub_id).val(), 10);

            if(amount > amount_have){
              alert("จำนวนในคลังไม่เพียงพอ");
              $('#amount'+sub_id).val(0);
            }
          }

      </script>

    </div>
  </main>


</body>

</html>