const body = document.querySelector('body'),
  sidebar = body.querySelector('nav'),
  toggle = body.querySelector(".toggle"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");


toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
})

modeSwitch.addEventListener("click", () => {
  body.classList.toggle("dark");

  if (body.classList.contains("dark")) {
    modeText.innerText = "Light mode";
  } else {
    modeText.innerText = "Dark mode";

  }
});

function updateUserStatus(){
  jQuery.ajax({
    url:'../includes/update_user_status.php',
    success:function(){
        console.log("ok");
    }
  });

}

function getUserData(){
  jQuery.ajax({
    url:'../includes/getUserData.php',
    success:function(result){
        jQuery("#userData").html(result)
    }
  });

}

setInterval(function(){
  getUserData();
 
},5000);

 setInterval(function(){
   updateUserStatus();
  
 },5000);
