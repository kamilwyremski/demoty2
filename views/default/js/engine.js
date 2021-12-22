
function adsSide() {
  var scrolledInput = (document.body.scrollTop || document.documentElement.scrollTop) - 60;
  var picturesDom = document.getElementById("pictures_box");
  if(typeof picturesDom !== "undefined" && picturesDom !== null){
    var picturesHeight = picturesDom.offsetHeight - 60;
    var adsSides = ["ads_side_left", "ads_side_right"];
    for(ad of adsSides){
      var scrolled = scrolledInput;
      var adDom = document.getElementById(ad);
      if(typeof adDom !== "undefined" && adDom !== null){
        var adHeight = adDom.offsetHeight;
        if(adHeight < picturesHeight){
          if(scrolled < 0){
            scrolled = 0
          }else if(scrolled + adHeight + 50 > picturesHeight){
            scrolled = picturesHeight - adHeight;
          }
          adDom.style.marginTop = scrolled +"px";
        }
      }
    }
  }
}
window.onscroll = function() {adsSide();}

document.querySelectorAll(".return_false").forEach(link => {
  link.addEventListener("click", function(event) {
    event.preventDefault();
  })
})

document.querySelectorAll(".file-input").forEach(link => {
  link.onchange = function(){
    if(link.files.length > 0){
      link.parentNode.querySelector(".file-label").innerHTML = link.files[0].name;
    }
    if(link.id=="picture"){
      generatePicture(true);
    }
  }
})

document.querySelectorAll(".set_voice").forEach(link => {
  link.addEventListener("click", function(event) {
    event.preventDefault();
    var parent = this.parentNode.parentNode;
    var fd = new FormData();
    fd.append("action", "set_voice");
    fd.append("picture_id", this.dataset.picture_id);
    fd.append("voice", this.dataset.voice);
    fd.append("token", this.dataset.token);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "php/ajax.php", true);
    xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        var response = JSON.parse(this.responseText);
        if(response.plus !== "undefined" && response.minus !== "undefined"){
          parent.querySelector(".voice_plus").innerHTML = response.plus;
          parent.querySelector(".voice_minus").innerHTML = response.minus;
        }
      }
    };
    xhttp.send(fd);
  });
});

document.querySelectorAll(".modal_trigger").forEach(link => {
  link.addEventListener("click", function(event) {
    event.preventDefault();
    var modal = document.querySelector("#"+link.href.split("#")[1]);
    var html = document.querySelector("html");
    modal.classList.add("is-active");
    html.classList.add("is-clipped");
    modal.querySelector(".modal-background").addEventListener("click", function(e) {
      e.preventDefault();
      modal.classList.remove("is-active");
      html.classList.remove("is-clipped");
    });
  });
})

document.querySelectorAll(".notification_delete").forEach(link => {
  link.addEventListener("click", function(event) {
    link.parentNode.outerHTML = "";
  });
})

function generatePicture(new_image = false){
  var title = document.getElementById("title").value;
  var type = document.getElementById("type").value;
  if(is_edit_picture){
    var picture = "";
  }else if(type=='mem_pattern'){
    var radios_mem_patterns = document.getElementsByName('mem_pattern');
    for (var i = 0, length = radios_mem_patterns.length; i < length; i++){
      if (radios_mem_patterns[i].checked){
        var picture = radios_mem_patterns[i].value;
        break;
      }
    }
  }else{
    var picture = document.getElementById("picture").files[0];
  }
  var fd = new FormData();
  fd.append("action", "generate_picture");
  fd.append("filename", document.getElementById("filename").value);
  fd.append("title", title);
  fd.append("title_size", document.getElementById("title_size").value);
  fd.append("title_color", document.getElementById("title_color").value);
  fd.append("title_border_size", document.getElementById("title_border_size").value);
  fd.append("title_border_color", document.getElementById("title_border_color").value);
  fd.append("description", document.getElementById("description").value);
  fd.append("description_size", document.getElementById("description_size").value);
  fd.append("description_color", document.getElementById("description_color").value);
  fd.append("description_border_size", document.getElementById("description_border_size").value);
  fd.append("description_border_color", document.getElementById("description_border_color").value);
  fd.append("background_color", document.getElementById("background_color").value);
  fd.append("border_color", document.getElementById("border_color").value);
  fd.append("type", type);
  if(!is_added_image && picture && title){
    new_image = is_added_image = true;
  }
  if(new_image){
    fd.append("picture", picture);
  }

  if(title && (type=="demot" || picture || is_edit_picture)){
	document.getElementById("preview_picture_load").style.display = "block";
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "php/ajax.php", true);
    xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        var response = JSON.parse(this.responseText);
        if(response.status && response.picture){
          document.getElementById("preview_picture_box").style.display = "block";
          document.getElementById("preview_picture").src = response.picture+"?"+Date.now();
        }else{
          document.getElementById("preview_picture_box").style.display = "none";
        }
		document.getElementById("preview_picture_load").style.display = "none";
      }
    };
    xhttp.send(fd);
  }else{
    document.getElementById("preview_picture_box").style.display = "none";
  }
}

function addChangeType(){
  if(document.getElementById("type").value=="demot"){
    document.getElementById("demot_select_color").style.display = "block";
    var mem_patterns = document.getElementById("mem_patterns");
    if(mem_patterns){mem_patterns.style.display = "none";}
    var picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "block";
      document.getElementById("picture").disabled = false;
    }
  }else if(document.getElementById("type").value=="mem"){
    document.getElementById("demot_select_color").style.display = "none";
    var mem_patterns = document.getElementById("mem_patterns");
    if(mem_patterns){mem_patterns.style.display = "none";}
    var picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "block";
      document.getElementById("picture").disabled = false;
    }
  }else{
    document.getElementById("demot_select_color").style.display = "none";
    var mem_patterns = document.getElementById("mem_patterns");
    if(mem_patterns){mem_patterns.style.display = "block";}
    var picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "none";
      document.getElementById("picture").disabled = true;
    }
  }
}

function openTab(evt, tabTitle) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" is-active", "");
    }
    document.getElementById(tabTitle).style.display = "block";
    evt.currentTarget.parentNode.className += " is-active";
}

document.querySelectorAll(".navbar-burger").forEach(function ($el) {
  $el.addEventListener("click", function () {
    var target = $el.dataset.target;
    var $target = document.getElementById(target);
    $el.classList.toggle("is-active");
    $target.classList.toggle("is-active");
  });
});

function checkCookies(){
  if(!localStorage.cookies_accepted) {
    document.getElementById("cookies-message").style.display="block";
  }
  if(!localStorage.rodo_accepted) {
    var rodo_message_trigger = document.getElementById("rodo-message-trigger");
    if(rodo_message_trigger){
      rodo_message_trigger.click();
    }
  }
}

function closeCookiesWindow(){
  localStorage.cookies_accepted = true;
  var cookie_window = document.getElementById("cookies-message");
  cookie_window.parentNode.removeChild(cookie_window);
}

function closeRodoWindow(){
  localStorage.rodo_accepted = true;
  document.getElementById("rodo-message").classList.remove("is-active");
  document.querySelector("html").classList.remove("is-clipped");
}

window.onload = checkCookies;
