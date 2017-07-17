function clockTick(){
  currentTime = new Date();
  month = currentTime.getMonth() + 1;
  day = currentTime.getDate();
  year = currentTime.getFullYear();
  hour = currentTime.getHours();
  minute = currentTime.getMinutes();
  second = currentTime.getSeconds();
  // alert("hi");
  document.getElementById('date').value=day + "-" + month + "-" + year + " " + hour + ":" + minute + ":" + second;
    }
    
setInterval(function(){
  clockTick();
}, 1000);//setInterval(clockTick, 1000); will also work