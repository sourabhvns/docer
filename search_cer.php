<!doctype html>


<html>

<head>
    <meta charset="utf-8">
    <title>ceRNet Database</title>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/t/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2/datatables.min.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script>
        $(document).ready(function () {
            $('#datatables').DataTable({
                dom: '<"top"Blf>rt<"bottom"ip><"clear">'
                , buttons: [{
                    extend: 'collection'
                    , text: 'Export'
                    , buttons: ['csvHtml5', 'excelHtml5']
                }]
            });
        });
    </script>
    <script>
        function valthisform() {
            var chkd = document.FC.cer_type_1.checked || document.FC.cer_type_2.checked
            if (chkd == true) {} else {
                alert("Select ceRNA gene type")
                return false;
            }
        }
    </script>

    <script>
        function valthisgene() {
            //var array = load("temp/gene_sym.txt");  
            var fs = require('fs');
            fs.readFile('/var/www/html/docer/temp/gene_sym.txt', function (err, data) {
                if (err) throw err;
                var array = data.toString().split("\n");
                for (i in array) {
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
            <a href="index.php">
                <div class="nav">Home</div>
            </a>
            <a href="search.php">
                <div class="nav" style="background:#FFCFAF; color:black;">Search</div>
            </a>
            <div class="nav">Downloads</div>
            <a href="help.php">
                <div class="nav">Help</div>
            </a>
            <a href="contact.php">
                <div class="nav">Contact Us</div>
            </a>
        </nav>
        <div id="border"></div>
        <div id="workarea">
            <form name="FC" action="search_cer.php" method="post" onsubmit=" return valthisform() && valthisgene()">
                <div id="box" style="width:100%">
                    <div id="text" style="width:260px">1. Select Cancer type : </div>
                    <div class="dropdown" style="width:412px; border-radius:4px">
                        <select name="cancer" class="dropdown-select" style="width:412px">
                            <?php
                            $cancer = explode("\n", file_get_contents('/var/www/html/docer/temp/cancer_type.txt'));
                            foreach ($cancer as $c) {
                                if($c!=''){
                                if (trim($c) == $_POST["cancer"])
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

                <div id="box" style="width:100%">
                    <div id="text" style="width:260px">2. Minimum number of common miRNAs : </div>
                    <input style="font-size:0.8em;" name="comm" <?php echo "value = ". $_POST[ "comm"]?> class="search" required></div>
                <div id="box" style="width:100%">
                    <div id="text" style="width:260px">3. Correlation coefficient (>= 0.5) : </div>
                    <input style="font-size:0.8em;" name="corr" <?php echo "value = ". $_POST[ "corr"]?> class="search" type="number" max="1" min="0.5" step="0.1" required>
                    <div id="text" style="width:140px;margin-left:20px;">4. p-Value (
                        <=0 .05) : </div>
                            <input style="width:92px;font-size:0.8em;" name="pval" <?php echo "value = ". $_POST[ "pval"]?> class="search" type="number" style="width:92px" max="0.05" min="0" step="0.01" required>
                    </div>
                    <div id="box">
                        <div id="text" style="width:260px">5. Query gene symbol (e.g. PTEN): </div>
                        <input name="gene" class="search" style="font-size:0.8em;" placeholder="Enter a Gene Symbol" list="gene_sym" <?php echo "value = ". $_POST[ "gene"]?> required>
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
                        <div id="text" style="width:260px">6. Select miRNA of interest : </div>
                        <input name="mirna" class="search" style="font-size:0.8em;" placeholder="All" list="mirna_sym" <?php echo "value = ". $_POST[ "mirna"]?> required>
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
                        <div id="text" style="width: 750px">7. ceRNA gene type :
                            <?php 
                        if ($_POST["cer_type_1"] == "PCG")
                        {
                            echo "<input type=\"checkbox\" name=\"cer_type_1\" value=\"PCG\" checked style=\"margin-left: 136px;\" echo \"value =". $_POST["cer_type_1"]."> Protein coding genes (PCG)";
                        }
                        else
                        {
                            echo "<input type=\"checkbox\" name=\"cer_type_1\" value=\"PCG\" style=\"margin-left: 136px;\" echo \"value =". $_POST["cer_type_1"]."> Protein coding genes (PCG)";
                        }
                        if ($_POST["cer_type_2"] == "NCG")
                        {
                            echo "<input type=\"checkbox\" name=\"cer_type_2\" value=\"NCG\" checked style=\"margin-left: 15px;\" echo \"value =". $_POST["cer_type_2"]."> Non-coding genes (NCG)";
                        }
                        else
                        {
                            echo "<input type=\"checkbox\" name=\"cer_type_2\" value=\"NCG\" style=\"margin-left: 15px;\" echo \"value =". $_POST["cer_type_2"]."> Non-coding genes (NCG)";
                        }
                    ?>
                        </div>
                    </div>
                    <div id="box">
                        <div id="box" style="margin-left: 100px;">
                            <input class="button" type="submit" value="Submit" />
                        </div>
                    </div>
            </form>
            </div>

            <div id="border"></div>
            <div id="tablebox">
                <table id="datatables" class="compact hover cell-border">
                    <thead>
                        <tr>
                            <th>Query gene</th>
                            <th>Query gene type</th>
                            <th>ceRNA</th>
                            <th>ceRNA type</th>
                            <th>Correlation coefficient</th>
                            <th>p-Value</th>
                            <th>No. of Common miRNA</th>
                            <th>SoCeR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $can = explode("]",explode("[",$_POST["cancer"])[1])[0];
                            $link = mysqli_connect("localhost", "root", "rnai", "docer");
                            if($link === false)
                            {
                                die("ERROR: Could not connect. " . mysqli_connect_error());
                            }                            
                            if($_POST["cer_type_1"] == "PCG" and $_POST["cer_type_2"] == "NCG" and $_POST["mirna"]=="All")
                            {
                                $sql = "select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"]). ";"  ;
                            }                            
                            if($_POST["cer_type_1"] == "PCG" and $_POST["cer_type_2"] == "NCG" and $_POST["mirna"]!="All")
                            {
                                $sql = "select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"])." and b.mir like \"%". trim(substr($_POST["mirna"],4)). "%\";";
                            }
                            elseif($_POST["cer_type_1"] == "PCG" and $_POST["cer_type_2"] != "NCG" and $_POST["mirna"]=="All")
                            {
                                $sql = "select * from (select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"]).") as t where cer_type=\"PCG\" or cer_type=\"NCG,PCG\" or cer_type=\"PCG,NCG\";";                                 
                            }                            
                            elseif($_POST["cer_type_1"] == "PCG" and $_POST["cer_type_2"] != "NCG" and $_POST["mirna"]!="All")
                            {
                                $sql = "select * from (select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"])." and b.mir like \"%". trim(substr($_POST["mirna"],4))."%\") as t where cer_type=\"PCG\" or cer_type=\"NCG,PCG\" or cer_type=\"PCG,NCG\";";                                 
                            }
                            elseif($_POST["cer_type_1"] != "PCG" and $_POST["cer_type_2"] == "NCG" and $_POST["mirna"]=="All")
                            {
                                $sql = "select * from (select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"]).") as t where cer_type=\"NCG\" or cer_type=\"NCG,PCG\" or cer_type=\"PCG,NCG\";";                               
                            }
                            elseif($_POST["cer_type_1"] != "PCG" and $_POST["cer_type_2"] == "NCG" and $_POST["mirna"]!="All")
                            {
                                $sql = "select * from (select b.query,f.gene_type as query_type,b.cer,g.gene_type as cer_type,b.corr,b.pvalue,b.comm,b.socer from " .$can. " b join gene_classify g on g.gene=b.cer join gene_classify f on f.gene=b.query where b.query = \"". trim($_POST["gene"]).
                                        "\" and b.corr >= ". trim($_POST["corr"])." and b.pvalue <= ". trim($_POST["pval"])." and b.comm >= ". trim($_POST["comm"])." and b.mir like \"%". trim(substr($_POST["mirna"],4))."%\") as t where cer_type=\"NCG\" or cer_type=\"NCG,PCG\" or cer_type=\"PCG,NCG\";";                               
                            }
                            if($result = mysqli_query($link, $sql))
                            {   
                                
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {   echo "<tr>";                                         
                                        echo "<td>" . $row["query"] . "</td>"; 
                                        echo "<td>" . $row["query_type"] . "</td>"; 
                                        echo "<td>" . $row["cer"] . "</td>"; 
                                        echo "<td>" . $row["cer_type"] . "</td>"; 
                                        echo "<td>" . $row["corr"] . "</td>"; 
                                        echo "<td>" . $row["pvalue"] . "</td>";
                                        echo "<td><a target=_blank href=miRpage.php?cancer=".$can."&query=". $row["query"] ."&query_type=".$row["query_type"] ."&cer=".$row["cer"]."&cer_type=".$row["cer_type"]."&comm=".$row["comm"]."&corr=".$_POST["corr"]."&pval=".$_POST["pval"]."&comm=".$row["comm"].">" . $row["comm"] . "</a></td>";
                                        echo "<td>" . $row["socer"] . "</td>";
                                        echo "</tr>";
                                    }                                     
                                    mysqli_free_result($result);
                                }                                
                            } 
                            else
                            {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                            }
                           // mysqli_close($link);
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
            </div>
            <div id="border"></div>
            <div id="footer">Developed at <strong> RNAi & Functional Genomics Laboratory</strong>
                <br>Department of Life Sciences, NIT Rourkela, Odisha

            </div>
        </div>
</body>

</html>