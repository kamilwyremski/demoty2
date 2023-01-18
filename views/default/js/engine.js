
function adsSide() {
  const scrolledInput = (document.body.scrollTop || document.documentElement.scrollTop) - 60;
  const picturesDom = document.getElementById("pictures_box");
  if(typeof picturesDom !== "undefined" && picturesDom !== null){
    const picturesHeight = picturesDom.offsetHeight - 60;
    const adsSides = ["ads_side_left", "ads_side_right"];
    for(let ad of adsSides){
      let scrolled = scrolledInput;
      const adDom = document.getElementById(ad);
      if(typeof adDom !== "undefined" && adDom !== null){
        const adHeight = adDom.offsetHeight;
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
window.onscroll = () => adsSide();

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
    const parent = this.parentNode.parentNode;
    const fd = new FormData();
    fd.append("action", "set_voice");
    fd.append("picture_id", this.dataset.picture_id);
    fd.append("voice", this.dataset.voice);
    fd.append("token", this.dataset.token);
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "php/ajax.php", true);
    xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        const response = JSON.parse(this.responseText);
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
    const modal = document.querySelector("#"+link.href.split("#")[1]);
    const html = document.querySelector("html");
    modal.classList.add("is-active");
    html.classList.add("is-clipped");
    modal.querySelector(".modal-background").addEventListener("click", function(event) {
      event.preventDefault();
      modal.classList.remove("is-active");
      html.classList.remove("is-clipped");
    });
  });
})

document.querySelectorAll(".notification_delete").forEach(link => {
  link.addEventListener("click", function() {
    link.parentNode.outerHTML = "";
  });
})

function generatePicture(new_image = false){
  const title = document.getElementById("title").value;
  const type = document.getElementById("type").value;
  let picture;
  if(is_edit_picture){
    picture = "";
  }else if(type=='mem_pattern'){
    const radios_mem_patterns = document.getElementsByName('mem_pattern');
    for (let i = 0, length = radios_mem_patterns.length; i < length; i++){
      if (radios_mem_patterns[i].checked){
        picture = radios_mem_patterns[i].value;
        break;
      }
    }
  }else{
    picture = document.getElementById("picture").files[0];
  }
  const fd = new FormData();
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
  let is_added_image = false;
  if(!is_added_image && picture && title){
    new_image = true;
    is_added_image = true;
  }
  if(new_image){
    fd.append("picture", picture);
  }

  if(title && (type=="demot" || picture || is_edit_picture)){
	  document.getElementById("preview_picture_load").style.display = "block";
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "php/ajax.php", true);
    xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        const response = JSON.parse(this.responseText);
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
  const mem_patterns = document.getElementById("mem_patterns");
  if(document.getElementById("type").value=="demot"){
    document.getElementById("demot_select_color").style.display = "block";
    if(mem_patterns){
      mem_patterns.style.display = "none";
    }
    const picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "block";
      document.getElementById("picture").disabled = false;
    }
  }else if(document.getElementById("type").value=="mem"){
    document.getElementById("demot_select_color").style.display = "none";
    if(mem_patterns){
      mem_patterns.style.display = "none";
    }
    const picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "block";
      document.getElementById("picture").disabled = false;
    }
  }else{
    document.getElementById("demot_select_color").style.display = "none";
    if(mem_patterns){
      mem_patterns.style.display = "block";
    }
    const picture_file_box = document.getElementById("picture_file_box");
    if(picture_file_box){
      picture_file_box.style.display = "none";
      document.getElementById("picture").disabled = true;
    }
  }
}

function openTab(event, tabTitle) {
    const tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    const tablinks = document.getElementsByClassName("tablinks");
    for (let i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" is-active", "");
    }
    document.getElementById(tabTitle).style.display = "block";
    event.currentTarget.parentNode.className += " is-active";
}

document.querySelectorAll(".navbar-burger").forEach(function ($el) {
  $el.addEventListener("click", function () {
    const target = $el.dataset.target;
    const $target = document.getElementById(target);
    $el.classList.toggle("is-active");
    $target.classList.toggle("is-active");
  });
});

function checkCookies(){
  if(!localStorage.cookies_accepted) {
    document.getElementById("cookies-message").style.display="block";
  }
  if(!localStorage.rodo_accepted) {
    const rodo_message_trigger = document.getElementById("rodo-message-trigger");
    if(rodo_message_trigger){
      rodo_message_trigger.click();
    }
  }
}

function closeCookiesWindow(){
  localStorage.cookies_accepted = true;
  const cookie_window = document.getElementById("cookies-message");
  cookie_window.parentNode.removeChild(cookie_window);
}

function closeRodoWindow(){
  localStorage.rodo_accepted = true;
  document.getElementById("rodo-message").classList.remove("is-active");
  document.querySelector("html").classList.remove("is-clipped");
}

window.onload = checkCookies;
