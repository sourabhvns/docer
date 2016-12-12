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

<link href="http://cdn-na.infragistics.com/igniteui/2016.1/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
    <link href="http://cdn-na.infragistics.com/igniteui/2016.1/latest/css/structure/infragistics.css" rel="stylesheet" />

    <script src="http://ajax.aspnetcdn.com/ajax/modernizr/modernizr-2.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

    <!-- Ignite UI Required Combined JavaScript Files -->
    <script src="http://cdn-na.infragistics.com/igniteui/2016.1/latest/js/infragistics.core.js"></script>
    <script src="http://cdn-na.infragistics.com/igniteui/2016.1/latest/js/infragistics.lob.js"></script>

    <script>

        var colors = [
            { Name: "Black" },
            { Name: "Blue" },
            { Name: "Brown" },
            { Name: "Green" },
            { Name: "Orange" },
            { Name: "Purple" },
            { Name: "Red" },
            { Name: "White" },
            { Name: "Yellow" }
        ];

        $(function () {

            $("#singleSelectCombo").igCombo({
                width: "270px",
                dataSource: colors,
                textKey: "Name",
                valueKey: "Name",
                dropDownOnFocus: true
            });

            $("#multiSelectCombo").igCombo({
                width: "270px",
                dataSource: colors,
                textKey: "Name",
                valueKey: "Name",
                multiSelection: {
                    enabled: true
                }
            });

            $("#checkboxSelectCombo").igCombo({
                width: "270px",
                dataSource: colors,
                textKey: "Name",
                valueKey: "Name",
                multiSelection: {
                    enabled: true,
                    showCheckboxes: true
                }
            });

        });

    </script>


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

<style>
    
.combo-label {margin-bottom:.5em;}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

li {
    float: right;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 4px 20px;
    text-decoration: none;
    background-color: #abbaba;
    border-radius:2px;
    border:1px solid #c3d6df;
    margin: 0px 3px 0px 0px;
    width: 65px;
    font-size: 14px;
    font-family:Calibri, Cambria, Georgia, "Bookman Old Style", "Times New Roman";
    font-weight:bold;    
}

li a:hover, .dropdown1:hover .dropbtn {
    background:#ED7D31;
    color:white;
    background: -moz-linear-gradient(top, #0c5f85, #0b5273 50%, #024869 51%, #003853);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0, #0c5f85), color-stop(.5, #0b5273), color-stop(.51, #024869), to(#003853)); 
}

li.dropdown1 {
    display: inline-block;
    z-index: 10;
}

.dropdown1-content {
    display: none;
    position: absolute;
    z-index: 10;
}

.dropdown1-content a {
    color: black;
    padding: 7px 12px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown1-content a:hover {background-color: #f1f1f1}

.dropdown1:hover .dropdown1-content {
    display: block;
}
</style>


</head>
<body>
	<div id="wrapper">
    	<div id="header" style="margin-right: 15px">
        	<img src="img/db_logo.JPG" width="180" height="50" alt="weblogo">
                <img src="img/nit_logo.jpg" width="70" height="50" alt="clglogo" align="right">
        </div>
        
        <div id="border"></div>
        <div id="workarea">
            <ul>
                        
            <li><a href="#news">Contact</a></li>          
            <li><a href="#home">Help</a></li>
            <li class="dropdown1">
              <a href="#" class="dropbtn">Search</a>
              <div class="dropdown1-content">
                  <a href="search.php" style="width:auto;">Search ceRNA</a>
                    <a href="#" style="width:auto;">Analyze ceRNA pair</a>

              </div>
            </li>
            <li><a class="active" href="#home">Home</a></li>
          </ul>
            <form  name="FC" action="search_cer.php" method="post" onsubmit=" return valthisform() && valthisgene()" >
            <div id="box" style="width:100%"><div id = "text" style="width:260px;margin-top: 25px">1. Select Cancer type : </div>           	
                <div id="checkboxSelectCombo" style="margin-top: 25px"></div>


            </div>            
            
            <div id="box" style="width:100%"><div id = "text" style="width:260px">2. Minimum number of common miRNAs: </div><input  name="comm" value="10" class="search" placeholder="10" required></div>
            <div id="box"style="width:100%"><div id = "text" style="width:260px">3. Correlation coefficient (>= 0.5) : </div><input type="number" value="0.5" name="corr"  class="search" placeholder="0.5" min="0.5" max="1" step="0.1" required>
            <div id = "text" style="width:140px;margin-left:20px;">4. p-Value (<= 0.05) : </div><input type="number" name="pval" value="0.05" class="search" style="width:92px" placeholder="0.05" max="0.05" min="0" step="0.01" required>                
            </div>       
            <div id="box">
                <div id = "text" style="width:260px">5. Query gene symbol (e.g. PTEN): </div>              
                <input name="gene"  class="search" placeholder="Enter a Gene Symbol" list="gene_sym" required>
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
                <input name="mirna" class="search" list="mirna_sym" value="All" required>
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
</body>
</html>