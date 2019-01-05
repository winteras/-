<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">
  <!--datepicker-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="datepicker-master/dist/datepicker.css">
	
	
  <title>電子化流程設計與管理</title>
  
  
  
  
    <!--datepicker-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="datepicker-master/dist/datepicker.css">
    
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="datepicker-master/dist/datepicker.js"></script>
    <script>
    $(function() {
        var date=new Date();
        date.toLocaleDateString()
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'yyyy-mm-dd',
        startDate:date
      });
    });
    </script>
	<style>
	#label_center {
		display: block;
		text-align: center;
	}
	</style>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($conf['EasyFlowServer']);
if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {

        // 參數設定
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $eid = $_POST['eid'];
		$Date_1 = $_POST['Date_1'];
		$Date_2 = $_POST['Date_2'];
		$Date_3 = $_POST['Date_3'];
		$nub_1 = $_POST['nub_1'];
		$nub_2 = $_POST['nub_2'];
		$purpose = $_POST['purpose'];
		$textarea_1 = $_POST['textarea_1'];
		$exampleRadios1 = $_POST['exampleRadios1'];
		$exampleRadios2 = $_POST['exampleRadios2'];
        // 送到流程管理
        try{
            $procesesStr = $client->findFormOIDsOfProcess($oid);

            $proceses = explode(",", $procesesStr);
            $process = $proceses[0];
            $template = $client->getFormFieldTemplate($process);

            $form = simplexml_load_string($template);
			$form->Textbox5 = $Date_1;
			$form->Textbox0 = $uid;
			$form->Textbox1 = $eid;
			$form->Textbox7 = $Date_2;
			$form->Textbox11 = $Date_3;
            $form->Textbox9 = $nub_1;
			$form->Textbox12 = $nub_2;
            $form->Textbox17 = $purpose;
			$form->RadioButton22 = $exampleRadios1;
			$form->RadioButton23 = $exampleRadios2;
			$form->TextArea24 = $textarea_1;
			
            $result = $form->asXML();
            $client->invokeProcess($oid, $eid, $uid, $process, $result, "伺服器代管申請作業");
        }catch(Exception $e){
        echo $e->getMessage();
        }

    } else {
        echo "系統錯誤";
    }
    
}

?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="eid">員工編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
			<div class="col-md-6 mb-3">
			  <label for="uid">員工單位編號</label>
			  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
			  <div class="invalid-feedback">
				員工單位編號 必填
			  </div>
			</div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

		  
		  
		  
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
				   
                  <label for="Date_1">申請日期</label>
                  <input  name="Date_1" type="text" class="form-control " data-toggle="datepicker" id="Date_1" value="">
                  <div class="invalid-feedback">
                    申請日期
                  </div>
                </div>
          </div>
		  
		  <div class="row">
              <div class="col-md-4 mb-3">
			  <label for="Date_2">刊登日期</label>
			  <input  name="Date_2" type="text" class="form-control " data-toggle="datepicker" id="Date_2" value="">
			  </div>
			  <div class="col-md-1 mb-3 form-group">
				  <label for="nub_1" >&nbsp;</label>
				  <input name="nub_1" type="number" class="form-control" placeholder="時" value="" min="0" max="23" id="nub_1" value=""  required>
			  </div>
			  
			  <div class="col-md-1 mb-3 form-group">
				  <label  >&nbsp;</label>
				  <p align="center" ><strong>到</strong></p>
			  </div>
			  
			  
			  <div class="col-md-4 mb-3">
			  <label for="Date_3">刊登日期</label>
			  <input  name="Date_3" type="text" class="form-control " data-toggle="datepicker" id="Date_3" value="">
			  </div>
			  <div class="col-md-1 mb-3 form-group">
				  <label for="nub_2" text-align="right">&nbsp;</label>
				  <input name="nub_2" type="number" class="form-control" id="nub_2" placeholder="時"  min="0" max="23"  value="" required>
			  </div>
			  
			  <div class="col-md-1 mb-3 form-group">
				  <label  >&nbsp;</label>
				  <p align="center" ><strong>為止</strong></p>
			  </div>
			  
			  <div class="invalid-feedback">
				刊登日期
			  </div>
				  
                
          </div>
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="purpose">目的</label>
                  <input name="purpose" type="text" class="form-control" id="purpose" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    目的
                  </div>
                </div>
          </div>
		  
		  
		  
		  <div class="row">
              <div class="col-md-4 mb-3">
                  <label ><strong>申請事項</strong></label>
					  <div class="form-check" >
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios1" value="A">
						  <label class="form-check-label" for="exampleRadios1">
							Banner(1004x300像素)
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios2" value="B">
						  <label class="form-check-label" for="exampleRadios2">
							跑馬燈
						  </label>
						</div>
						<div class="form-check ">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios3" value="C" >
						  <label class="form-check-label" for="exampleRadios3">
							快速連結
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios4" value="D">
						  <label class="form-check-label" for="exampleRadios4">
							網頁內容
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios5" value="E">
						  <label class="form-check-label" for="exampleRadios5">
							網頁版面
						  </label>
						</div>
						<div class="form-check ">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios6" value="F" >
						  <label class="form-check-label" for="exampleRadios6">
							增建帳號
						  </label>
						</div>
						<div class="form-check ">
						  <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios7" value="G" >
						  <label class="form-check-label" for="exampleRadios7">
							其他
						  </label>
						</div>
                  <div class="invalid-feedback">
                    申請事項
                  </div>
              </div>
			  <div class="col-md-4 mb-3"  required>
                  <label><strong>協助事項</strong></label>
						<div class="form-check" >
						  <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios8" value="新增">
						  <label class="form-check-label" for="exampleRadios8">
							新增
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios9" value="修改">
						  <label class="form-check-label" for="exampleRadios9">
							修改
						  </label>
						</div>
						<div class="form-check ">
						  <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios10" value="刪除" >
						  <label class="form-check-label" for="exampleRadios10">
							刪除
						  </label>
						</div>
					   <div class="invalid-feedback">
						 協助事項
					   </div>
              </div>
			  <div class="col-md-4 mb-3">
                  <label for="textarea_1"><strong>申請事項說明</strong></label>
                  <textarea  name="textarea_1" class="form-control" id="textarea_1" placeholder="" value="" rows="9"   required ></textarea>
                  <div class="invalid-feedback">
                    申請事項說明
                  </div>
              </div>
          </div>
		  
		  
		  
		  
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
                  <label id="label_center" for="textarea_2" ><strong>注意事項</strong></label>
                  <textarea readonly  name="textarea_2" class="form-control"  placeholder="1. 申請事項說明以簡單扼要為原則。
2. 申請單位應負刊登文字責任。
3. 相關檔案請寄到公務信箱banner：bcoffice01@nkust.edu.tw (請在刊登日前3天寄出)。
				   其他： chunting@nkust.edu.tw" value="" rows="4"    ></textarea>
                  
              </div>
          </div>
		  
		  
		  
		  
		  
		  

          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
  
  <script src="datepicker-master/dist/datepicker.js"></script>
    <script>
    $(function() {
        var date=new Date();
        date.toLocaleDateString()
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'yyyy-mm-dd',
        startDate:date
      });
    });
    </script>
</body>

</html>