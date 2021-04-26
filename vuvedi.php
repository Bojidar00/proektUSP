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
<form>
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
    <input type="submit" name="submit" value="Въведи">
</form>
</div>
</center>

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