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
    
        
        <center>
            <h1>Въведи автомобил</h1>
        <div>
<form action=# method="POST" enctype="multipart/form-data">
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
                                 ?><br>
  <input type="file" name="snimka" ><br>
    <input type="submit" name="submit" value="Въведи">
</form>
</div>
</center>


<?php
include "config.php";
if (isset($_POST["submit"])){
 if (isset($_POST["marka"])&&isset($_POST["model"])&&isset($_POST["ekstri"])&&isset($_FILES["snimka"]["name"])){
   $marka=$_POST['marka'];
   $model=$_POST['model'];
   $ekstri=$_POST['ekstri'];
   $snimka=$_FILES["snimka"]["name"];
      echo $marka,$model,$ekstri[0],$snimka;
   $ekst=" ";
   for ($x = 0; $x < sizeof($ekstri); $x++){
     $u=$ekstri[$x];
          
         
      
       }

          
   $sql="Insert into koli(id_model,snimka)
   Values (".$model.",".'"'.$snimka.'"'.");";
    echo $sql;
   $call = $dbConn->prepare($sql);
  

   if (!$call->execute()){echo "Грешка.";}
       else {echo "Добавихте един запис.";}





       $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["snimka"]["name"]);


       if (move_uploaded_file($_FILES["snimka"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["snimka"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
 }



}







?>





<?php
 $call  = $dbConn->prepare("SELECT model,id_model,id_marka from model Order by id_marka;");
 
 
 if (! $call->execute()){echo "Грешка.";}
 else {
  
    mysqli_stmt_store_result($call);
    mysqli_stmt_bind_result($call, $model,$id_model,$id_marka);
    echo'<script> ';
    $i=0;
    while(mysqli_stmt_fetch($call)){
      
        $id=0;
        if($id_marka!=$id){
    echo 'var ar'.$id_marka.'=[];'; $id=$id_marka;}
    
     echo 'ar'.$id_marka.'.push('.$id_model.');';
     $i++;
     echo 'ar'.$id_marka.'.push('.$model.');'; }
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