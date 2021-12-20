<html>
<head>
<title>How to Create Barcode Generator using PHP</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

</style>
</head>
<body>
<br><br>
    <form method="post" name="BarcodeGenerator" id="BarcodeGenerator"
        onSubmit="return validate();">
        <div class="form-row">
            DHL-Post number:
            <div><input type="txt" name="mrp" placeholder="Your Post Number here"
                id="mrp" class="input-field" /></div>
        </div>

        <div>
            <input type="submit" name="generate" class="submit-button"
                value="Generate Barcode" />
        </div>
    </form>
<br><br>
    <div id="validation-info"></div>
    <script>
    function validate() {
         var valid = true;
         var message;

         $("#validation-info").hide();
         $("#validation-info").html();
        if($("#mrp").val() == "") {
            message = "Please enter your Post-number";
                valid = false;
        } else if(!$.isNumeric($("#mrp").val())) {
                message = "Post Number should be in numbers";
                valid = false;
        }
        if(valid == false) {
          $("#validation-info").show();
          $("#validation-info").html(message);
        }
        return valid;
    }
    </script>

</body>
</html>
<?php

function luhna($number) {

    $LUN1 = 0;
    $flag = 0;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $add = $flag++ & 1 ? $number[$i] : $number[$i] * 2;
//        echo $add.'<br>';
        $LUN1 += $add > 9 ? $add - 9 : $add;
//        echo $LUN1.'<br>';
    }
    return $LUN = ($LUN1 * 9) % 10;
}

function luhnb($number) {

    $parity = strlen($number) % 2;
    $sum = 0;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
         $char = $number[$i];
         //echo $char.'<br>';
      if ($i % 2 != $parity) {
          $char *= 2;
      }
//        $char = ($i % 2) != $parity ? $char*2 : $char*1;
          $sum += $char > 9 ? $char - 9 : $char;
//          echo $sum.'<br>';
    }
    return $LUN = ($sum * 9) % 10;
}

function luhnc($number) {

    $sum = 0;
    $parity = 1;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
         $factor = $parity ? 2 : 1;
         $parity = $parity ? 0 : 1;
         $sum += array_sum(str_split($number[$i] * $factor));
//         echo $sum.'<br>';
    }
    return $LUN = ($sum * 9) % 10;
}

if (!empty($_POST["generate"])) {

    $MRP = 631 * $_POST["mrp"];
    $len = strlen($MRP);
    settype($MRP, 'string');
//    echo $len.'<br>';
    echo $MRP.'<br>';


//16 Zeichen 3000 + $MRP + 1
//choose function a, b, or c
//    $LUN = luhna($MRP);
//    $LUN = luhnb($MRP);
    $LUN = luhnc($MRP);

    $MRP = $MRP.$LUN;
//    echo strlen($MRP);
    $MRP = strlen($MRP) < 12 || strlen($MRP) > 15 ? '0000000000' : $MRP;
    $MRP = strlen($MRP) == 12 ? '3000'.$MRP : $MRP;
    $MRP = strlen($MRP) == 13 ? '300'.$MRP : $MRP;
    $MRP = strlen($MRP) == 14 ? '30'.$MRP : $MRP;
    $MRP = strlen($MRP) == 15 ? '3'.$MRP : $MRP;

//$file = file_get_contents("https://kabelwecker.de/web/pdf/qrcode/fin.php?code=$MRP");
$file = file_get_contents("https://kabelecke.de/barcode.php?code=$MRP");
?>
<div class="result-heading">Output Self:</div>
<?php
echo $file;
echo $MRP;
}
?>
