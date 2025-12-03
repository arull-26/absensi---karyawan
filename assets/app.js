console.log("APP JS LOADED");

// ===================================================
//  SPA NAVIGATION
// ===================================================
function showPage(id){
    document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
    document.getElementById(id).classList.add("active");
}

// ===================================================
//  LOGIN (DATABASE)
// ===================================================
async function loginPegawai() {
    const nik = document.getElementById("login-nik").value;
    const password = document.getElementById("login-password").value;
    const msg = document.getElementById("login-msg");

    // Jika mau tetap pakai login statis admin/emp
    if (nik === "admin" && password === "123") {
        localStorage.setItem("role", "admin");
        showPage("page-admin");
        return;
    }

    if (nik === "emp" && password === "123") {
        localStorage.setItem("role", "employee");
        showPage("page-employee");
        return;
    }

    // LOGIN VIA DATABASE
    let form = new FormData();
    form.append("nik", nik);
    form.append("password", password);

    try {
        const res = await fetch("api/login.php", {
            method: "POST",
            body: form
        });

        const data = await res.json();

        if (data.status === "error") {
            msg.textContent = data.msg;
            msg.style.color = "red";
            return;
        }

        // login sukses → simpan user
        localStorage.setItem("user", JSON.stringify(data.user));
        localStorage.setItem("role", data.user.role);

        msg.textContent = "Login berhasil!";
        msg.style.color = "green";

        setTimeout(() => {
            if (data.user.role === "admin") showPage("page-admin");
            else showPage("page-employee");
        }, 400);

    } catch (err) {
        msg.textContent = "Terjadi kesalahan pada server.";
        msg.style.color = "red";
    }
}

// EVENT LOGIN BUTTON
document.getElementById("btn-login").onclick = loginPegawai;


// ===================================================
//  LOGOUT
// ===================================================
function logout(){
    localStorage.removeItem("role");
    localStorage.removeItem("user");
    showPage("page-login");
}


// ===================================================
//  FIRST LOAD
// ===================================================
let role = localStorage.getItem("role");

if (role === "admin") showPage("page-admin");
else if (role === "employee" || role === "pegawai") showPage("page-employee");
else showPage("page-login");
