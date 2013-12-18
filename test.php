<?php
$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
	echo "<table border=1>\n";
    while (($data = fgetcsv($handle)) !== FALSE) {
    	
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
       
        echo "<tr>\n";
        /*for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }*/
        foreach ($data as $item) {
        	echo ($row == 1)?"<th>":"<td>";
        	echo $item."\n";
        }
        $row++;
    }
    fclose($handle);
    echo '</table>';
}
?>