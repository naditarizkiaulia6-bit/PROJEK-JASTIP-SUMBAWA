// LOGIN
function login(){
  const role = document.getElementById("role")?.value;
  const username = document.getElementById("username")?.value;
  const password = document.getElementById("password")?.value;

  if(!role || !username || !password){
    alert("Lengkapi semua data!");
    return;
  }

  localStorage.setItem("login","true");
  localStorage.setItem("role",role);

  if(role === "agen"){
    window.location.href = "dashboard-agen-jastip.html";
  }else{
    window.location.href = "dashboard-user-jastip.html";
  }
}

// LOGOUT
function logout(){
  if(confirm("Yakin ingin logout?")){
    localStorage.clear();
    window.location.href = "login.html";
  }
}

// PROTEKSI HALAMAN
function protectPage(role){
  if(localStorage.getItem("login") !== "true" ||
     localStorage.getItem("role") !== role){
    window.location.href = "login.html";
  }
}
