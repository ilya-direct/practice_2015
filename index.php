<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
    <title>Заменить IP</title>
    <style>
        div {
            display: inline-block;
            padding: 20px;
            border: 1px solid #900;
        }
        img {
            border: 1px solid #060;
        }
        .hidden{
            display: none;
        }
    </style>
</head>
<body>
<div class="hidden" id="pageId"><?=rand(1,3)?></div>
    <h1> Заголовок</h1>
    <h2> Заголовок 2 </h2>
    <div id="img_area">
        <img id='router' src="/images/router.png" alt="">
    </div>
</body>

<script>
    document.getElementById('router').addEventListener('click',function(event){
        var pos=defPosition(event);
        //console.log(pos.x+'x'+pos.y);
        var port=[];
        port[0]=inRect(pos,289,146,332,184);
        port[1]=inRect(pos,361,146,403,184);
        port[2]=inRect(pos,433,146,476,184);
        port[3]=inRect(pos,506,146,550,184);
        port[4]=inRect(pos,579,146,622,184);
        port[5]=inRect(pos,665,146,709,184);
        var pushedPort=false;
        for(var i=0; i<port.length;i++){
            if(port[i]){
                pushedPort=i+1;
                break;
            }
        }
        if(pushedPort){
            var title=document.getElementById('pageId').innerText;

            // send info to server
            var request;
            if(window.XMLHttpRequest){
                request = new XMLHttpRequest();
            } else if(window.ActiveXObject){
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                alert('Невозможно создать асинхронный запрос в данном браузере!');
                return;
            }

            request.onreadystatechange = function(){
                switch (request.readyState) {
                    case 4:
                        if(request.status==200){
                            var obj= JSON.parse(request.responseText);
                            if(typeof(obj.error) !== 'undefined'){
                                alert(obj.error);
                            }else{
                                alert(obj.pageName + ' Порт: '+ obj.port);
                            }
                        }else if(request.status==404){
                            alert("Ошибка: запрашиваемый скрипт не найден!");
                        }
                        else alert("Ошибка: сервер вернул статус: "+ request.status);

                        break;
                }
            }
            request.open ('POST', '/request.php', true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send ('port='+pushedPort+'&'+'pageId='+title);
        }
    }, false);
    function inRect(pos,x1,y1,x2,y2){
        if(pos.x >=x1 && pos.x <=x2 && pos.y >=y1 && pos.y <=y2 ){
            return true
        }else{
            return false;
        }
    }
    function defPosition(event) {
        var x = y = 0;
        var event = event || window.event;

        // Получаем координаты клика по странице, то есть абсолютные координаты клика.

        if (document.attachEvent != null) { // Internet Explorer & Opera
            x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
            y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
        } else if (!document.attachEvent && document.addEventListener) { // Gecko
            x = event.clientX + window.scrollX;
            y = event.clientY + window.scrollY;
        }

        //Определяем границы объекта, в нашем случае картинки.

        y0=document.getElementById("router").offsetTop;
        x0=document.getElementById("router").offsetLeft;

        // Пересчитываем координаты и выводим их алертом.
        position={};
        position.x = x-x0;
        position.y = y-y0;
        return position;
    }


</script>
</html>