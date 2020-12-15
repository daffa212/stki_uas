<table border=1 cellpadding=5 cellspacing=0>
<tr>
<td>Kata</td>
<td>Jumlah Dokumen</td>
<td>Kata Dalam Jumlah Dokumen</td>
<td>Invers Document Frequency</td>
</tr>
<?php
include "index.php";
include "koneksi.php";

//$query2 = "delete from tokens";
//$result2 = mysqli_query($koneksi,$query2);

$query = "SELECT kata,f.jmldok,e.katajmldok,LOG10(f.jmldok/e.katajmldok) idf FROM (SELECT kata,COUNT(kata) katajmldok FROM (SELECT id,no,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS d GROUP BY kata ORDER BY id+0,NO+0) AS e JOIN (SELECT COUNT(id) jmldok FROM (SELECT id FROM token GROUP BY id+0) AS c) AS f";
$result = mysqli_query($koneksi,$query);
$numrows = mysqli_num_rows($result);
$no=1;
while($row = mysqli_fetch_array($result)){  
echo "<tr>";
$kata1 = $row['kata'];
$jmldok1 = $row['jmldok'];
$katajmldok1 = $row['katajmldok'];
$idf1 = $row['idf'];

echo "<td><font color=blue></font>" .  strtolower($kata1) . "<br></td>"; 
echo "<td><font color=blue></font>" .  $jmldok1 . "<br></td>"; 
echo "<td><font color=blue></font>" .  $katajmldok1 . "<br></td>"; 
echo "<td><font color=blue></font>" .  $idf1 . "<br></td>"; 
echo "</tr>";
$no++;

//$query1 = "insert into tokens values ('$id1','$kode1','$kata1','$freq1')";
//$result1 = mysqli_query($koneksi,$query1);
}

?>