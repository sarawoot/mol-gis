<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php 
  $str = '';
  if ($_REQUEST['category'] == 'train') {
    $str = 'ฝึกอบรมฝีมือแรงงาน';
  }
  if ($_REQUEST['category'] == 'test') {
    $str = 'ทดสอบมาตรฐานฝีมือแรงงาน';
  }

  if ($_REQUEST['category'] == 'test_economy_east') {
    $str = 'การทดสอบมาตรฐานฝีมือแรงงาน(เศรษฐกิจภาคตะวันออก)';
  }
?>

<div>
คำอธิบาย คาดการณ์จำนวนผู้สมัคร<?php echo $str; ?> กลุ่มอาชีพ<?php echo $_REQUEST['occupation']; ?> โดยอ้างอิงปี <?php echo $_REQUEST['year']; ?> เป็นปีฐาน
ระดับเกณฑ์การวัด
  
  <table>
    <?php foreach ($_REQUEST['intervals'] as $key => $value) { ?>
    <tr>
      <td style="width:50px;background-color: <?php echo $_REQUEST[colors][$key]; ?>"></td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($value[0])." - ". number_format($value[1]); ?> คน</td>
    </tr>
    <tr style="height:5px;"></tr>
    <?php } ?>
  </table>

ความหมาย การแบ่งระดับสีโดยแยกตามช่วงจำนวนประชากรของแต่ละจังหวัด
</div>