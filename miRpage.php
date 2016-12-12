<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ceRNet Database</title>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2/datatables.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
    $(document).ready( function () {
        $('#datatables').DataTable(
        { dom:  '<"top"Blf>rt<"bottom"ip><"clear">',
        buttons: [
      {
         extend: 'collection',
         text: 'Export',
         buttons: [ 'csvHtml5', 'excelHtml5' ]
      }
    ]
  
        });
    } );            
</script>

</head>
<body>
    <div id="wrapper" style="width:800px;">
    	<div id="header" style="margin-right: 15px">
        	<img src="img/db_logo.JPG"  width="180" height="50" alt="weblogo">
                <img src="img/nit_logo.jpg" width="70" height="50" alt="clglogo" align="right">
        </div>        
        <div id="border"></div>
        <div id="workarea" style="height: auto;text-align: center;padding-left: 0px; padding-bottom: 20px;">
            <p style="color:white;margin-top: 0px;padding-top: 10px"><strong style="color:#ffd455"><?php echo $_GET["comm"]?></strong > common miRNAs between <strong style="color:#ffd455"><?php echo $_GET["query"]?></strong> and <strong style="color:#ffd455"><?php echo $_GET["cer"]?></strong></p> 
            <p style="color:white;padding-bottom:10px; font"><b>Cancer type:</b> <strong style="color:#ffd455">
                            <?php  $cancer = explode("\n", file_get_contents('/var/www/html/docer/temp/cancer_type.txt'));
                            foreach ($cancer as $c) {
                                if (explode("]",explode("[",(trim($c)))[1])[0] == $_GET["cancer"])
                                {
                                    echo trim($c);
                                }
                            } ?></strong></p>
            <div id ="tablebox" style="color: black; border:1px solid black;margin-top:40px; background-color: white; width: 650px; margin-top: 0px; margin-left: 75px; border-radius: 3px; ">
        	<table  id="datatables" class="compact hover cell-border">
            	<thead>                	   
                    <tr>                    
                    <th>Common miRNA</th>                                       
                    <th>SoCer</th>
                    </tr>
                </thead>                
                <tbody>
                    <?php                        
                        $link = mysqli_connect("localhost", "root", "rnai", "docer");
                            if($link === false)
                            {
                                die("ERROR: Could not connect. " . mysqli_connect_error());
                            }                            
                            $sql= "select b.mir from " .$_GET["cancer"]. " b join gene_classify g on g.gene=b.cer and g.gene_type=\"".$_GET["cer_type"]."\" join gene_classify f on f.gene=b.query where b.query = \"".$_GET["query"]."\" and b.cer = \"".$_GET["cer"]."\";";
                            if($result = mysqli_query($link, $sql))
                            { 
                                if(mysqli_num_rows($result) > 0)
                                {   
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        $value = explode(";",$row["mir"]);
                                        foreach ($value as $v) 
                               		{                                                                          
                                            echo "<tr>";                                            
                                            echo "<td>hsa-". explode(":",$v)[0] . "</td>";
                                            echo "<td>" . explode(":",$v)[1] . "</td>";
                                            echo "</tr>";
                                        }                                        
                                    }                                     
                                    mysqli_free_result($result);
                                }
                                else
                                {
                                    echo "No records matching your query were found.";
                                }
                            }
                            else
                            {
                                    echo "No query";
                            }
                        ?>								                            
                 </tbody>
        	</table>
                </div>      	      
        </div>
        <div id="border"></div>
        <div id="footer">Developed at <strong> RNAi & Functional Genomics Laboratory</strong>
            <br>Department of Life Sciences, NIT Rourkela, Odisha
      
    </div> 
        </div>
</body>
</html>