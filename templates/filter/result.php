<?php
require_once ("../../config/static.php");
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
    $title = 'VIEW_GIS_DSD_PASS_TRAINING';
    $name = 'ผู้ผ่านการฝึกอบรม';
    break;
  case 3 :
    $title = 'VIEW_GIS_DSD_PASS_TESTING';
    $name = 'ผู้ผ่านการทดสอบ';
    break;
  case 4 :
    $title = 'VIEW_GIS_DOE_JOB_VACANCY';
    $name = 'ตำแหน่งงานว่าง';
    break;
  case 5 :
    $title = 'VIEW_GIS_SSO_INSURED_M33';
    $name = 'ผู้ประกันตน ม.33';
    break;
  case 6 :
    $title = 'VIEW_GIS_SSO_INSURED_M40';
    $name = 'ผู้ประกันตน ม.40';
    break;
  case 7 :
    $title = 'VIEW_GIS_STAT_NSO_DISABILITY';
    $name = 'ผู้สูงอายุ';
    break;
  case 8 :
    $title = 'VIEW_GIS_STAT_NSO_DISABILITY';
    $name = 'สถิติผู้พิการ (รายปี)';
    break;
  case 9 :
    $title = 'VIEW_GIS_STAT_NSO_ELDER';
    $name = 'สถิติผู้สูงอายุ (รายปี)';
    break;
  case 10 :
    $title = 'VIEW_GIS_STAT_NSO_MONTHLY';
    $name = 'สถิติการสำรวจประชากร (รายเดือน)';
    break;
  case 11 :
    $title = 'VIEW_GIS_STAT_NSO_QUARTER';
    $name = 'สถิติการสำรวจประชากร (รายไตรมาส)';
    break;
  case 12 :
    $title = 'VIEW_GIS_STAT_NSO_INFORMAL_WK';
    $name = 'สถิตแรงงานนอกระบบ';
    break;
  case 13 :
    $title = 'VIEW_GIS_DOE_FOREIGN_WORKER';
    $name = 'สถิตแรงงานต่างด้าว';
    break;
  
  default :
    $title = 'VIEW_GIS_STAT_NSO_DISABILITY';
    $name = 'สถิตแรงงานต่างด้าว';
    break;
}
?>
<div id="iframeSD_show" style="display: block; padding: 12px;">
	<div id="DivSD_Explain">
		<font>แสดงผลการค้นหาข้อมูล<?php echo $name,' ',$title?></font>
	</div>
	<div id="DivSD_measure">
		<center>
			<font>ระดับเกณฑ์การวัด</pre></font>
		</center>
		<table>
			<tbody>
				<?php foreach($map_color as $k=>$v){?>
				<tr>
					<td style="background-color: <?php echo $v?>" border="1" width="50px">
					</td>
					<td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
					<?php
      $n1 = explode('.', $intervals[$k]);
      $n2 = explode('.', $intervals[$k + 1]);
      $num1 = number_format((( int ) $n1[0])) . '.' . (( int ) $n1[1]);
      $num2 = number_format((( int ) $n2[0])) . '.' . (( int ) $n2[1]);
      echo $num1, ' - ', $num2?>
      				</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
<?php }?>
</tbody>
		</table>
		<br>
		<center>
			<font>กราฟแสดงข้อมูล<?php echo $name?>แยกตามจังหวัด</font>
		</center>
	</div>
</div>