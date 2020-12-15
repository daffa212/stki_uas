<table border=1 cellpadding=5 cellspacing=0>
<tr>
<td>Id</td>
<td>Kata</td>
<td>Term Frequency</td>
<td>Invers Document Frequency</td>
<td>TF.IDF</td>

</tr>
<?php
include "index.php";
include "koneksi.php";

//$query2 = "delete from tokens";
//$result2 = mysqli_query($koneksi,$query2);

//$query = "SELECT g.id,g.kata,g.freq,g.jmlkata,g.tf,h.jmldok,h.katajmldok,h.idf,(g.tf*h.idf) tf_idf from (SELECT a.id,a.kata,a.freq,b.jmlkata,(a.freq/b.jmlkata) tf FROM (SELECT id,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS a JOIN (SELECT id,SUM(freq) jmlkata FROM token GROUP BY id+0) AS b ON a.id=b.id) AS g JOIN (SELECT kata,f.jmldok,e.katajmldok,LOG10(f.jmldok/e.katajmldok) idf FROM (SELECT kata,COUNT(kata) katajmldok FROM (SELECT id,no,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS d GROUP BY kata ORDER BY id+0,NO+0) AS e JOIN (SELECT COUNT(id) jmldok FROM (SELECT id FROM token GROUP BY id+0) AS c) AS f) AS h ON g.kata=h.kata";
$query="SELECT f.id,f.kata,f.freq,f.jmlkata,f.tf,f.jmldok,g.jmlkatadok, LOG10(f.jmldok/g.jmlkatadok) idf, f.tf*(LOG10(f.jmldok/g.jmlkatadok)) tf_idf from (SELECT * from (SELECT a.id,a.kata,a.freq,b.jmlkata, (a.freq/b.jmlkata) tf from (SELECT * FROM token) AS a JOIN (SELECT id,SUM(freq) jmlkata FROM token GROUP BY id) AS b ON a.id=b.id) AS d JOIN (SELECT COUNT(id) jmldok from (SELECT id FROM token GROUP BY id) AS c) AS e) AS f JOIN (SELECT kata,COUNT(kata) jmlkatadok FROM token GROUP BY kata) AS g ON f.kata=g.kata";
$result = mysqli_query($koneksi,$query);
$numrows = mysqli_num_rows($result);
$no=1;
while($row = mysqli_fetch_array($result)){  
echo "<tr>";
//echo "<td>$no</td>";
$id1 = $row['id'];
//$no1 = $row['no'];
//$kode1 = $row['kode'];
$kata1 = $row['kata'];
$tf1 = $row['tf'];
$idf1 = $row['idf'];
$tfidf1 = $row['tf_idf'];

echo "<td><font color=blue></font>" .  $id1 . "<br></td>"; 
echo "<td><font color=blue></font>" .  strtolower($kata1) . "<br></td>"; 
echo "<td><font color=blue></font>" .  $tf1 . "<br></td>"; 
echo "<td><font color=blue></font>" .  $idf1 . "<br></td>"; 
echo "<td><font color=blue></font>" .  $tfidf1 . "<br></td>"; 
echo "</tr>";
$no++;

//$query1 = "insert into tokens values ('$id1','$kode1','$kata1','$freq1')";
//$result1 = mysqli_query($koneksi,$query1);
}

?>