<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ceRNet Database</title>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="media/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2"/>
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2/datatables.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
    $(document).ready( function () {
        $('#datatables').DataTable(
        { "dom":'<"top"if>',
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

<script>
function valthisform()
{
    var chkd = document.FC.cer_type_1.checked || document.FC.cer_type_2.checked
    if (chkd == true){        
    }
    else{
        alert ("Select ceRNA gene type.")
        return false;
    }    
    
}
</script>
<script>
function valthisgene()
{
    //var array = load("temp/gene_sym.txt");  
    var fs = require('fs');
    fs.readFile('/var/www/html/docer/temp/gene_sym.txt', function(err, data) {
        if(err) throw err;
        var array = data.toString().split("\n");
        for(i in array) {
            console.log(array[i]);
    }
});

   
    
}
</script>
</head>
<body>
	<div id="wrapper">
    	<div id="header" style="margin-right: 15px">
        	<img src="img/db_logo.JPG" width="180" height="50" alt="weblogo">
                <img src="img/nit_logo.jpg" width="70" height="50" alt="clglogo" align="right">
        </div>
        <nav>        
            <a href="index.php"><div class="nav">Home</div></a>
            <a href="search.php"><div class="nav" style="background:#FFCFAF; color:black;">Search</div></a>
            <div class="nav">Downloads</div>
            <a href="help.php"><div class="nav">Help</div></a>
            <a href="contact.php"><div class="nav">Contact Us</div></a>            
        </nav>
        <div id="border"></div>
        <div id="workarea">
            <form  name="FC" action="search_cer.php" method="post" onsubmit=" return valthisform() && valthisgene()" >
            <div id="box" style="width:100%"><div id = "text" style="width:260px">1. Select Cancer type : </div>           	
                <div class="dropdown" style="width:412px;border-radius:4px">                	
                    <select name="cancer" class="dropdown-select" style="width:412px">
                        <?php
                            $cancer = explode("\n", file_get_contents('/var/www/html/docer/temp/cancer_type.txt'));
                            foreach ($cancer as $c) {
                                if($c!=''){
                                if (trim($c) == "Breast invasive carcinoma [BRCA]")
                                {
                                    echo "<option selected value=\"".trim($c)."\">".trim($c)."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".trim($c)."\">".trim($c)."</option>";
                                }
                                }
                            }
                            ?>
                    </select>
                </div>
            </div>            
            
            <div id="box" style="width:100%"><div id = "text" style="width:260px">2. Minimum number of common miRNAs: </div><input  name="comm" value="10" class="search" style="font-size:0.8em;" placeholder="10" required></div>
            <div id="box"style="width:100%"><div id = "text" style="width:260px">3. Correlation coefficient (>= 0.5) : </div><input type="number" value="0.5" name="corr"  style="font-size:0.8em; " class="search" placeholder="0.5" min="0.5" max="1" step="0.1" required>
            <div id = "text" style="width:140px;margin-left:20px;">4. p-Value (<= 0.05) : </div><input type="number" name="pval" value="0.05" class="search" style="width:92px;font-size:0.8em;" placeholder="0.05" max="0.05" min="0" step="0.01" required>                
            </div>       
            <div id="box">
                <div id = "text" style="width:260px">5. Query gene symbol (e.g. PTEN): </div>              
                <input name="gene"  class="search" placeholder="Enter a Gene Symbol" style="font-size:0.8em;" list="gene_sym" required>
                    <datalist id="gene_sym">
                        <?php
                            $gene_sym = explode("\n", file_get_contents('/var/www/html/docer/temp/gene_sym.txt'));
                            foreach ($gene_sym as $g) {
                                echo "<option value=\"".trim($g)."\">";                                
                            }                          
                            ?>    
                    </datalist>
                    
            </div>            
            <div id="box" style="width:100%">
                <div id = "text" style="width:260px">6. Select  miRNA of interest  : </div>           	
                <input name="mirna" class="search" style="font-size:0.8em;" list="mirna_sym" value="All" required>
                    <datalist id="mirna_sym">
                        <?php
                            $mirna_sym = explode("\n", file_get_contents('/var/www/html/docer/temp/miRNA_list.txt'));
                            foreach ($mirna_sym as $m) {
                                echo "<option value=\"".trim($m)."\">";                                
                            }
                            ?>    
                    </datalist>          
            </div>            
            <div id="box">
                <div id = "text" style="width: 750px;">7. ceRNA gene type : 
                    <input type="checkbox" name="cer_type_1" value="PCG" style="margin-left: 136px;" checked> Protein coding genes (PCG)
                    <input type="checkbox" name="cer_type_2" value="NCG" style="margin-left: 15px;" checked> Non-coding genes (NCG)
                </div>
            </div>
            <div id="box"><div id="box" style="margin-left: 100px;"><input class="button" type="submit" value="Submit" /></div></div>
            </form>
        </div>
        <div id="border"></div>
        <div id ="tablebox" style="height: 350px;">
        	<table  id="datatables" class="compact hover cell-border">
            	<thead>                	   
                    <tr>
                    <th>Query gene</th>
                    <th>Query gene type</th>                    
                    <th>ceRNA</th>
                    <th>ceRNA type</th>
                    <th>Correlation coefficient</th>
                    <th>p-Value</th>
                    <th>No. of Common miRNA</th>
                    <th>SoCer</th>
                    </tr>
                </thead>                
                <tbody style="height: 300px">                        	
                        
                </tbody>
        	</table>
      	</div>
       
        <div id="border"></div>
        <div id="footer">Developed at <strong> RNAi & Functional Genomics Laboratory</strong>
            <br>Department of Life Sciences, NIT Rourkela, Odisha
          
    </div>    
        </div>
</body>
</html>