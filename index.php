<!DOCTYPE html>
<html>
    <head>
    </head>
    <style>
    input[type=text] {
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }
      input[type=submit] {
  width: 50%;
  background-color: #012e5e;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
div {
    width: 50%;
  border-radius: 5px;
  background-color: #44b606;
  padding: 20px;
  border: 1px solid #ccc;
  
}
    </style>
    <body>
    
    <form action="vuvedi.php">
    <input type="submit" style="width:15%" value="Въведете автомобил" />
    </form>
        <center>
            <h1>Търси автомобил</h1>
        
        
        <div>
<form action=# method="POST">
    Марка:
    <select id="marka" name="marka" onchange="change()" style="margin:10px 0px" ><br>
                           <option >--изберете--</option><br>
                             <?php
                                include "config.php";
                                 $result =mysqli_query($dbConn, "SELECT id_marka,marka FROM marka");
                                while($row = mysqli_fetch_array($result)){
                                 echo '<option value="'.$row['id_marka'].'">'.$row['marka'].'</option>';}
                                 ?></select><br>
    Модел:
    <select name="model" id=model>
    <option >--изберете--</option>
    </select><br>
     Екстри:<br>
    <?php
                                include "config.php";
                                 $result =mysqli_query($dbConn, "SELECT id_ekstra,ekstra FROM ekstri");
                                while($row = mysqli_fetch_array($result)){
                                 echo '<input type="checkbox"  style="width:10%" name="ekstri[]"value="'.$row['id_ekstra'].'">
                                 <label for="'.$row['id_ekstra'].'">'.$row['ekstra'].'</label>';}
                                 ?>
    <input type="submit" name="submit" value="Търси">
</form>
</div>

                   <?php 
                     include "config.php";
                     if (isset($_POST["submit"])){
                      
                        $marka=$_POST['marka'];
                        $model=$_POST['model'];
                        
                        if($marka=="--изберете--"){$marka='';}
                        if($model=="--изберете--"){$model='';}
                           
                        $ekst=" ";

                        if(!empty($_POST['ekstri'])){
                          $ekstri=$_POST['ekstri'];
                          $count=0;
                        for ($x = 0; $x < sizeof($ekstri); $x++){
                          $u=$ekstri[$x];
                               if($x==0){
                              $ekst=$ekst." ".$u;}
                              else{$ekst=$ekst." ,".$u;}
                              $count=$count+1;
                            }
                          }

                            
                            if ( !empty($marka)&&!empty($model)&&!empty($ekstri)) {
                              $sql="Select koli.id_kola,snimka,marka,model from koli 
                              join model on model.id_model=koli.id_model
                              join marka on marka.id_marka=model.id_marka 
                              join koli_ekstri on koli_ekstri.id_kola=koli.id_kola
                              join ekstri on ekstri.id_ekstra=koli_ekstri.id_ekstra
                              where marka.id_marka=".$marka." AND model.id_model=".$model."AND koli_ekstri.id_ekstra in(".$ekst.") GROUP BY koli.id_kola HAVING COUNT(DISTINCT koli_ekstri.id_ekstra) =".$count.";";

                            }
                            else if ( empty($marka)&&empty($model)&&empty($ekstri)) {
                              $sql="Select id_kola,snimka,model,marka from koli join model on model.id_model=koli.id_model join marka on marka.id_marka=model.id_marka;";

                            }
                            else if ( !empty($marka)&&!empty($model)) {
                              $sql="Select id_kola,snimka,model,marka from koli join model on model.id_model=koli.id_model join marka on marka.id_marka=model.id_marka where marka.id_marka=".$marka." AND model.id_model=".$model.";";

                            }
                            else if ( !empty($marka)&&!empty($ekstri)) {
                              $sql="Select koli.id_kola,snimka,model,marka from koli join model on model.id_model=koli.id_model join marka on marka.id_marka=model.id_marka join koli_ekstri on koli_ekstri.id_kola=koli.id_kola where marka.id_marka=".$marka." AND koli_ekstri.id_ekstra in(".$ekst.")  GROUP BY koli.id_kola HAVING COUNT(DISTINCT koli_ekstri.id_ekstra) =".$count.";";

                            }
                            else if ( !empty($marka)) {
                              $sql="Select koli.id_kola,snimka,model,marka from koli join model on model.id_model=koli.id_model join marka on marka.id_marka=model.id_marka where marka.id_marka=".$marka.";";

                            }
                            else if ( !empty($ekstri)) {
                              $sql="Select koli.id_kola,snimka,model,marka from koli join model on model.id_model=koli.id_model join marka on marka.id_marka=model.id_marka join koli_ekstri on koli_ekstri.id_kola=koli.id_kola where koli_ekstri.id_ekstra in(".$ekst.")  GROUP BY koli.id_kola HAVING COUNT(DISTINCT koli_ekstri.id_ekstra) =".$count.";";

                            }
                        

                        
                         
                       
                        $call2 = $dbConn->prepare($sql);
                        

                        if (!$call2->execute()){echo "Грешка.";}
                            else {
                              
                              mysqli_stmt_store_result($call2);
                              mysqli_stmt_bind_result($call2,$id,$snimka,$model,$marka);
                              
                              echo '<table border="5">
                              <thead>
                                <tr>
                                <th>Снимка</th>
                                    <th>Марка</th>
                                       <th>Модел</th>
                                       <th>Екстри</th>
                                              </tr>
                                                    </thead>
                                          <tbody>';
                                          while(mysqli_stmt_fetch($call2)){
                                            echo '<tr>
                                            <td id="'.$id.'snimka"><img src="uploads/'.$snimka.'"width="300" 
                                            height="200" ></td>
                                            <td id="'.$id.'marka">'.$marka.'</td>
                                            <td id="'.$id.'model">'.$model.'</td>';
                                          $dbConn->next_result();
                                                $call4  = $dbConn->prepare("SELECT ekstra from ekstri join koli_ekstri on koli_ekstri.id_ekstra=ekstri.id_ekstra where koli_ekstri.id_kola=?");
                                                $call4->bind_param("i", $id);
                                                
                                                if (! $call4->execute()){echo "Грешка.";}
                                                else {
                                                 
                                                   mysqli_stmt_store_result($call4);
                                                   mysqli_stmt_bind_result($call4, $ekstra);
                                                   echo '<td id="'.$id.'ekstra">';
                                                   while(mysqli_stmt_fetch($call4)){
                                                    echo $ekstra.', '; }
                                                  
                                                }
                                                    echo'</td></tr>';
                                        }
                                        echo ' </tbody>
                                        </table>';
                            }
                    


                      
                     



                     }
                     ?>
                     </center>

<?php
 $call  = $dbConn->prepare("SELECT model,id_model,id_marka from model Order by id_marka;");
 
 
 if (! $call->execute()){echo "Грешка.";}
 else {
  
    mysqli_stmt_store_result($call);
    mysqli_stmt_bind_result($call, $model,$id_model,$id_marka);
    echo'<script> ';
    $i=0;
    $id=0;
    while(mysqli_stmt_fetch($call)){
      
        
        if($id_marka!=$id){
    echo 'var ar'.$id_marka.'=[];'; $id=$id_marka;}
    
     echo 'ar'.$id_marka.'.push('.$id_model.');';
     $i++;
     echo 'ar'.$id_marka.'.push("'.$model.'");'; }
     $i++;
   }
    
     echo'</script>';

?>
      <script>
    
    
    function change() {
      var x =document.getElementById("marka").value;
     var str=" <option >--изберете--</option>";
     
      if(x!="--изберете--"){
      for (i = 0; i < eval('ar'+x).length; i++) {
        
             str+=" <option value='"+eval('ar'+x)[i]+"' >";
             i++;
             str+=eval('ar'+x)[i]+"</option>";
           }
           
      }
      document.getElementById("model").innerHTML = str;
    }
    
    
        </script>


    
</body>
 </html>   