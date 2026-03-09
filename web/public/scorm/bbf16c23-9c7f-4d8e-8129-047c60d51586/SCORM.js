var API = null;
function findAPI(win){
    while(win){
        if(win.API) return win.API;
        win = win.parent;
    }
    return null;
}
window.onload = function(){
    API = findAPI(window);
};