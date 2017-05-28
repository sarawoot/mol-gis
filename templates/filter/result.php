<?php
require_once ("../../config/static.php");
require ("../../helpers/share_func.php");
require_once ("../../config/database.php");
$conn = connectionOracleDBUTF();
$intervals = explode(',', $_GET['intervals']);
// ประจำปีงบประมาณ 2559 เป็นการทดสอบมาตรฐานฝีมือแรงงานแห่งชาติ ทุกประเภทของผู้สมัครทดสอบในสาขาภาคบริการ และทุกสาขาอาชีพ
switch($_GET['formSearch']){
  case 1 :
    $title = '';
    if (isset($_GET["DISABILTIY_TYPE"])){
      if (! empty($_GET["DISABILTIY_TYPE"])){
        $title .= "ประเภทของความพิการคือ" . $_GET['DISABILTIY_TYPE'] . '&nbsp;';
      }
    }
    if (isset($_GET["GRAD_EDU"])){
      if (! empty($_GET["GRAD_EDU"]))
        $title .= "วุฒิการศึกษาระดับ" . $_GET["GRAD_EDU"] . '&nbsp;';
    }
    $name = 'คนพิการมีงานทำ';
    break;
  case 2 :
  case 3 :
  case 4 :
  case 5 :
  case 6 :
  case 9 :
  case 10 :
  case 11 :
  case 12 :
  case 13 :
    $title = '';
    if (isset($_GET["YEARS"])){
      if (! empty($_GET["YEARS"])){
        $title .= "ประจำปีงบประมาณ " . $_GET['YEARS'] . '&nbsp;';
      }
    }
    if (isset($_GET["YEAR_TH"])){
      if (! empty($_GET["YEARS"])){
        $title .= "ประจำปีงบประมาณ " . $_GET['YEAR_TH'] . '&nbsp;';
      }
    }
    if (isset($_GET["MONTH_CODE"])){
      if (! empty($_GET["MONTH_CODE"])){
        $title .= "ประจำเดือน" . $month_conf[$_GET['MONTH_CODE']] . '&nbsp;';
      }
    }
    switch($_GET['formSearch']){
      case 2 :
        $name = 'ผู้ผ่านการฝึกอบรม';
        break;
      case 3 :
        $name = 'ผู้ผ่านการทดสอบ';
        break;
      case 4 :
        $name = 'ตำแหน่งงานว่าง';
        break;
      case 5 :
        $name = 'ผู้ประกันตน ม.33';
        break;
      case 6 :
        $name = 'ผู้ประกันตน ม.40';
        break;
      case 9 :
        $name = 'สถิติผู้สูงอายุ (รายปี)';
        break;
      case 10 :
        $name = 'สถิติการสำรวจประชากร (รายเดือน)';
        break;
      case 11 :
        $name = 'สถิติการสำรวจประชากร (รายไตรมาส)';
        if (isset($_GET["QUARTER"])){
          if (! empty($_GET["QUARTER"])){
            $title .= "ไตรมาสที่ " . $_GET['QUARTER'] . '&nbsp;';
          }
        }
        break;
      case 12 :
        $name = 'สถิตแรงงานนอกระบบ';
        break;
      case 13 :
        $name = 'สถิตแรงงานต่างด้าว';
        if (isset($_GET["FOREIGN_TYPE_CODE"])){
          if (! empty($_GET["FOREIGN_TYPE_CODE"])){
            $sql = 'SELECT FOREIGN_TYPE_CODE,FOREIGN_TYPE_NAME FROM DB_MOL.LKU_DOE_FOREIGN_TYPE  WHERE FOREIGN_TYPE_CODE =  ' . $_GET["FOREIGN_TYPE_CODE"];
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            $row = oci_fetch_array($result, OCI_BOTH);
            $FOREIGN_TYPE_NAME = $row["FOREIGN_TYPE_NAME"];
            $title .= "ประเภทการได้รับอนุญาตคือ" . $FOREIGN_TYPE_NAME . '&nbsp;';
            oci_free_statement($result);
          }
        }
        
        break;
    }
    break;
  case 7 :
    $title = '';
    $name = 'ผู้สูงอายุ';
    break;
  case 8 :
    $title = '';
    if (isset($_GET["YEARS"])){
      if (! empty($_GET["YEARS"])){
        $title .= "ประจำปีงบประมาณ " . $_GET['YEARS'] . '&nbsp;';
      }
    }
    if (isset($_GET["DISABILITY_GROUP_CODE"])){
      if (! empty($_GET["DISABILITY_GROUP_CODE"])){
        $sql = "SELECT  DISABILITY_GROUP_NAME FROM LKU_NSO_DISABILITY_TYPE WHERE DISABILITY_GROUP_CODE ='" . replace_str($_GET["DISABILITY_GROUP_CODE"]) . "' AND ROWNUM < 2";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        $row = oci_fetch_array($result, OCI_BOTH);
        $DISABILITY_GROUP_NAME = $row["DISABILITY_GROUP_NAME"];
        
        $title .= "ประเภทลักษณะความบกพร่องคือ" . $DISABILITY_GROUP_NAME . '&nbsp;';
        oci_free_statement($result);
        
        if (isset($_GET["DISABILITY_TYPE_CODE"])){
          if (! empty($_GET["DISABILITY_TYPE_CODE"])){
            $sql = "SELECT  DISABILITY_TYPE_CODE,DISABILITY_TYPE_NAME 
                    FROM LKU_NSO_DISABILITY_TYPE WHERE 
                    DISABILITY_GROUP_CODE ='" . replace_str($_GET["DISABILITY_GROUP_CODE"]) . "' 
                    AND DISABILITY_TYPE_CODE = '" . (( int ) $_GET["DISABILITY_TYPE_CODE"]) . "' AND ROWNUM < 2";
            $result = oci_parse($conn, $sql);
            // echo $sql;
            oci_execute($result);
            $row = oci_fetch_array($result, OCI_BOTH);
            $DISABILITY_TYPE_NAME = $row["DISABILITY_TYPE_NAME"];
            $title .= "ลักษณะความบกพร่องคือ" . $DISABILITY_TYPE_NAME . '&nbsp;';
            oci_free_statement($result);
          }
        }
      }
    }
    
    $name = 'สถิติผู้พิการ (รายปี)';
    break;
  
  default :
    $title = 'VIEW_GIS_STAT_NSO_DISABILITY';
    $name = 'สถิตแรงงานต่างด้าว';
    break;
}

oci_close($conn);

?>
<div id="iframeSD_show" style="display: block; padding: 12px;">
	<div id="DivSD_Explain">
		<font>แสดงผลการค้นหาข้อมูล<?php echo $name,' ',$title?></font>
	</div>
	<div id="DivSD_measure">
	<?php

if (isset($_GET['intervals'])){
  if (! empty($_GET['intervals'])){
    ?>
		<center>
			<font>ระดับเกณฑ์การวัด</pre></font>
		</center>
		<table>
			<tbody>
				<?php 
				$kk1 = [0,2,4,6,8];
				$kk2 = [1,3,5,7,9];
				foreach($map_color as $k=>$v){?>
				<tr>
					<td style="background-color: <?php echo $v?>" border="1" width="50px">
					</td>
					<td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
					<?php
      $n1 = explode('.', $intervals[$kk1[$k]]);
      $n2 = explode('.', $intervals[$kk2[$k]]);
      $num1 = number_format((( int ) $n1[0])) .   (isset($n1[1]) ? (( int ) '.'.$n1[1]) : '');
      $num2 = number_format((( int ) $n2[0])) .   (isset($n2[1]) ? (( int ) '.'.$n2[1]) : '');
      echo $num1, ' - ', $num2?>
      				</td>
					<td></td>
				</tr>
				<tr style="height: 5px;">
					<td></td>
					<td></td>
					<td></td>
				</tr>
<?php }?>
</tbody>
		</table>
		<br>
			<?php
  }else{
    ?>
  <center>
			<font>ไม่พบข้อมูล</font>
		</center>
<?
  }
}else{
  ?>
  <center>
			<font>ไม่พบข้อมูล</font>
		</center>
<?php
}
?>
		<center>
			<font>กราฟแสดงข้อมูล<?php echo $name?> แยกตามจังหวัด</font>
		</center>

	</div>
</div>