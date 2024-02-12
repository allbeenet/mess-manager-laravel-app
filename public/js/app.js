//showing menu
function showMenu(id){
    var menuList = document.querySelectorAll(".menu")

    for(var i=0; i<menuList.length; i++){
        menuList[i].classList.add('as-hide')
    }
    menuList[id].classList.remove('as-hide')
}

//hide menu
function hideMenu(){
    var menuList = document.querySelectorAll(".menu")

    for(var i=0; i<menuList.length; i++){
        menuList[i].classList.add('as-hide')
    }
}

activeMenu()
function activeMenu(){
    var pathName = window.location.pathname.split('/')[1]
    var menuItem = document.getElementById("menu-" + pathName)
    menuItem.classList.add("as-simple-list-active")
}

//dialog
function openDialog(){
    var dialog = document.getElementById('dialog')
    document.getElementById('saveButton').classList.remove('as-hide')
    document.getElementById('updateButton').classList.add('as-hide')
    dialog.classList.remove('as-hide')
}

function hideDialog(){
    var dialog = document.getElementById('dialog')
    dialog.classList.add('as-hide')
}
