<?php header('Content-Type: text/html; charset=utf-8'); ?>
<div>
คำอธิบาย คาดการณ์จำนวนผู้สมัครฝึกอบรมในการฝึกอบรมฝีมือแรงงาน กลุ่มอาชีพ<?php echo $_REQUEST['occupation']; ?> โดยอ้างอิงปี <?php echo $_REQUEST['year']; ?> เป็นปีฐาน
ระดับเกณฑ์การวัด
  
  <table style="border-spacing: 5px !important;">
    <?php foreach ($_REQUEST['intervals'] as $key => $value) { ?>
    <tr>
      <td style="width:50px;background-color: <?php echo $_REQUEST[colors][$key]; ?>"></td>
      <td><?php echo $value[0]." - ". $value[1]; ?> คน</td>
    </tr>
    <?php } ?>
  </table>

ความหมาย การแบ่งระดับสีโดยแยกตามช่วงจำนวนประชากรของแต่ละจังหวัด
</div>