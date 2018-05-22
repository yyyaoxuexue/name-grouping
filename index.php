<?php
header("Content-Type: text/html;charset=utf-8");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            background-color:#E0E0E0;
        }
        .filebox{
            width: 1000px;
            margin: 0 auto;
            clear: both;
        }
        .box{
            width: 1000px;
            height: 240px;
            margin: 0 auto;
            clear: both;
        }
        #btn,#group_btn{
            width: 100px;
            height: 30px;
            margin-left: 600px;
            margin-top: 50px;
        }
        .name{
            width: 100px;
            height: 30px;
            float: left;
            background-color:#CFF;
            margin-left: 10px;
            margin-top: 10px;
            text-align: center;
            line-height: 30px;
        }
      
        h3{
            text-align: center;
        }
        table{
            width: 1000px;
            margin: 0 auto;
            clear: both;
            border: 1px solid black;
        }
        td{
            width: 200px;
            height: 30px;
            border: 1px solid black;
        }
    </style>

</head>

<form action="index.php" method="post" enctype="multipart/form-data" class="filebox">
    <label for="file">文件名:</label>
    <input type="file" name="file" id="file" /> 
    <label for="file">文件分割符：</label>
    <input type="text" name="text" id="text"/>
    <input type="submit" name="submit" value="Submit" id="file_btn"/>

    
</form>
<?php
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
  //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  $file=$_FILES["file"]["name"] ;
 //echo $file;
 //echo "Type: " . $_FILES["file"]["type"] . "<br />";
 //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
 //echo "Stored in: " . $_FILES["file"]["tmp_name"];
  $content = file_get_contents($file);
  //$a = $_POST['file_sp'];
  $regular = $_POST['text'];
  $array = explode($regular, $content,30);
  //$array = trim($array," ");

  }
?>

<h3>随机点名</h3>
<input type="button" id="btn" value="点名"/>
<div class="box" id="box"></div>

<h3>随机分组</h3>
<input type="button" id="group_btn" value="分组"/>
<div class="box" id="div1">
<br>
</div>
<script type="text/javascript">
 

//创造虚拟后台数据
   



    var arrs =   <?php echo json_encode($array);?>;

    //获取父元素
    var boxNode = document.getElementById("box");
    for (var i = 0; i < arrs.length; i++) {
        //创建新元素
        var divNode = document.createElement("div");
        divNode.innerHTML=arrs[i];
        divNode.className="name";
        boxNode.appendChild(divNode);

    }
    //点名
    var btn= document.getElementById("btn");
    btn.onclick = function () {
        if(this.value==="点名"){

                //定时
            timeId=setInterval(function () {
                    //清空所有颜色
                for (var j = 0; j < arrs.length; j++) {
                    boxNode.children[j].style.background="";
                }
                //留下当前颜色
                var random = parseInt(Math.random()*arrs.length);
                boxNode.children[random].style.background="red";
            },100);
            this.value="停止";
        }else{
            //清除计时器
            clearInterval(timeId);
            this.value="点名";
        }
    }
   



var group_btn= document.getElementById("group_btn");

group_btn.onclick = function (){
    if(this.value==="分组"){
        var arr=create_group(arrs.length,5);
        function create_group(num,group_num){
            var group=new Array();
            var check_arr=new Array();
            for(var i=0;i<group_num;i++){
                var arr1=new Array(); //every group
                for(var j=0;j<num/group_num;j++){ //1:6
                    var value=arrs[Math.ceil(Math.random(0,num)*num)];
                    while(check_arr.indexOf(value)!=-1){
                        value=arrs[Math.ceil(Math.random(0,num)*num)];
                        
                    }
                    check_arr.push(value);
                    arr1.push(value);
                }
                group.push(arr1);
            }
            return group;
        }

        var table=document.createElement('table');
        for(var i=0;i<arr.length;i++){
            var tr=document.createElement('tr');
            for(var j=0;j<arr[i].length;j++){
                var td=document.createElement('td');
                td.innerText=arr[i][j];
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        document.getElementById("div1").appendChild(table);
        this.value="重新分组";
    
    }else{
        document.getElementById('div1').innerHTML = '';

        this.value="分组";
    }
   

}



</script>
</body>
</html>
