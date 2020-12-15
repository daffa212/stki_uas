<?php
include "index.php";
include "koneksi.php";

echo "<p align=center></p";
// konek ke database
//include "dibaliklayar/koneksi.php";
$keyword = $_GET["Keyword"]; // ambil keyword

   $search_exploded = explode(" ",$keyword); // hilangkan keyword dari spasi

   // 
   $x=0;
   $construct="";   
   foreach($search_exploded as $search_each)
   {
   // membuat query utk pencarian
   $x++;
    if ($x==1){
     $construct .= " kata LIKE '%$search_each%'";
	 //echo "$construct";
	 //echo '<br/>';
	 }
    else
     {
	 $construct .= " OR kata LIKE '%$search_each%'"; // query jika kata lebih dari 1
	 //echo "$construct";
	 } 
   }
   
	// tampilkan kotak pencarian dan jumlah hasil pencarian

	  echo "<br /><br><table><tr><td></td><td><form action='searchs.php' method='GET'><input type='text' onclick=value='' size='50' name='Keyword' value='$keyword' style='width: 500px; height: 30px; font-size: 16px;'> <input type='submit' value='Search'></form></td></tr></table>";
// select distinct utk mengambil berita agar tdk duplikasi
?>

<table border=1 cellpadding=5 cellspacing=0>
<tr>
<td>Id</td>
<td>Kata</td>
<td>Term Frequency</td>
<td>Invers Document Frequency</td>
<td>TF.IDF</td>
</tr><br><br>

<!--
<table border=1 cellpadding=5 cellspacing=0>
<tr>
<td>Id</td>
<td>Judul</td>
<td>Isi</td>
<td>Url</td>
</tr><br><br>-->
<?php


$query="select * from (SELECT g.id id,g.kata kata,g.freq,g.jmlkata,g.tf tf,h.jmldok,h.katajmldok,h.idf idf,(g.tf*h.idf) tf_idf from (SELECT a.id,a.kata,a.freq,b.jmlkata,(a.freq/b.jmlkata) tf FROM (SELECT id,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS a JOIN (SELECT id,SUM(freq) jmlkata FROM token GROUP BY id+0) AS b ON a.id=b.id) AS g JOIN (SELECT kata,f.jmldok,e.katajmldok,LOG10(f.jmldok/e.katajmldok) idf FROM (SELECT kata,COUNT(kata) katajmldok FROM (SELECT id,no,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS d GROUP BY kata ORDER BY id+0,NO+0) AS e JOIN (SELECT COUNT(id) jmldok FROM (SELECT id FROM token GROUP BY id+0) AS c) AS f) AS h ON g.kata=h.kata) as x where $construct order by tf_idf DESC";
//$query="SELECT y.id,z.judul,z.isi,z.url,y.tf_idf FROM (SELECT * FROM (SELECT g.id id,g.kata kata,g.freq,g.jmlkata,g.tf tf,h.jmldok,h.katajmldok,h.idf idf,(g.tf*h.idf) tf_idf from (SELECT a.id,a.kata,a.freq,b.jmlkata,(a.freq/b.jmlkata) tf FROM (SELECT id,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS a JOIN (SELECT id,SUM(freq) jmlkata FROM token GROUP BY id+0) AS b ON a.id=b.id) AS g JOIN (SELECT kata,f.jmldok,e.katajmldok,LOG10(f.jmldok/e.katajmldok) idf FROM (SELECT kata,COUNT(kata) katajmldok FROM (SELECT id,no,kata,SUM(freq) freq FROM token GROUP BY id,kata ORDER BY id+0,NO+0) AS d GROUP BY kata ORDER BY id+0,NO+0) AS e JOIN (SELECT COUNT(id) jmldok FROM (SELECT id FROM token GROUP BY id+0) AS c) AS f) AS h ON g.kata=h.kata) AS s WHERE $construct ORDER BY tf_idf DESC) AS y INNER JOIN (SELECT * FROM berita) AS z ON y.id=z.id";
$result=mysqli_query($koneksi,$query);
$numrows=mysqli_num_rows($result);
$no=1;
while($row = mysqli_fetch_array($result)){
echo "<tr>";
echo "<td><font color=blue></font>" . " $row[id] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[kata] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[tf] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[idf] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[tf_idf] " . "<br></td>";
/*echo "<td><font color=blue></font>" . " $row[id] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[judul] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[isi] " . "<br></td>"; 
echo "<td><font color=blue></font>" . " $row[url] " . "<br></td>";*/ 
echo "</tr>";
$no++;
}
?>