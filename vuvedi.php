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
    <form action="index.php">
    <input type="submit" style="width:15%" value="Търси автомобил" />
    </form>
        
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
 if (isset($_POST["marka"])&&isset($_POST["model"])){
   $marka=$_POST['marka'];
   $model=$_POST['model'];
   if(isset($_POST["ekstri"])){
   $ekstri=$_POST['ekstri'];}
   if(isset($_FILES["snimka"]["name"])){
   $snimka=$_FILES["snimka"]["name"];}
     
   

          
   $sql="Insert into koli(id_model,snimka)
   Values (".$model.",".'"'.$snimka.'"'.");";
    
   $call = $dbConn->prepare($sql);
  

   if (!$call->execute()){echo "Грешка.";}
       else {echo "Добавихте един запис.";}




       if(isset($_FILES["snimka"]["name"])){
       $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["snimka"]["name"]);


       if (move_uploaded_file($_FILES["snimka"]["tmp_name"], $target_file)) {
        
      } 
    }
      if(isset($_POST["ekstri"])){
      $call2  = $dbConn->prepare("SELECT LAST_INSERT_ID();");
      $call2->execute();
      mysqli_stmt_store_result($call2);
      mysqli_stmt_bind_result($call2, $id);
      mysqli_stmt_fetch($call2);

      $call3  = $dbConn->prepare("Insert into koli_ekstri(id_kola,id_ekstra) Values (?,?);");
      foreach ($ekstri as $value) {
        $call3->bind_param("ii",$id,$value);
        $call3->execute();
      }
                  
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