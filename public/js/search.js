var arr_t = [];

function init(){
    var tags = ["p", "h1", "h2", "h3", "h4", "h5", "h6", "span", "a"];

    


    for (let tag of tags){
        arr_t = arr_t.concat(Array.from(document.getElementsByTagName(tag)));
    }

    
    var findContainer = document.createElement("div");
    findContainer.style.position = "absolute";
    findContainer.style.top = (searchInside.offsetTop+searchInside.getBoundingClientRect().height)+"px";
    findContainer.style.left = (searchInside.offsetLeft-200)+"px";
    findContainer.style.width = "400px";
    findContainer.style.textAlign ="center";
    findContainer.classList.add("list-group")
    findContainer.setAttribute("id", "findContainer");
    findContainer.style.overflow = "hidden";
    findContainer.style.textOverflow = "ellipsis";
    findContainer.style.whiteSpace = "nowrap"; 
    searchInside.after(findContainer);



    document.getElementById("searchInside").addEventListener("keyup", function(e){

        search(document.getElementById("searchInside").value);

    });
}




function search(searchval){

    document.getElementById("findContainer").innerHTML = "";
    var limit = 7;
    var count = 0;
    if(searchval.length > 0){
        for(let cont of arr_t){

            if(cont.innerText.toLowerCase().indexOf(searchval.toLowerCase()) != -1){
                count++;
                console.log(cont);
                
                var chunks = cont.innerText.toLowerCase().split(searchval.toLowerCase());
                var text = "";
                if(typeof chunks[0] != "undefined"){
                    text += "..."+chunks[0].substring(chunks[0].length - 30); 
                }
    
                text += "<span class='text-danger-emphasis'>"+searchval+"</span>";
                
                if(typeof chunks[1] != "undefined"){
                    text += chunks[1].substring(0,30)+"...";
                }
                
                
                createFind(text, cont);
                if(count >= limit ){
                    break;
                }
            }
    
        }
    }
    
     

}

function createFind(text, obj){

    var fcont = document.createElement("a");
    fcont.setAttribute("href", "#");
    fcont.classList.add("list-group-item");
    fcont.classList.add("list-group-item-action");
    fcont.innerHTML = text;
    fcont.onclick = function(){
        window.scrollTo(0, obj.getBoundingClientRect().y)
        console.log(obj)
    }


    var pater = document.getElementById("findContainer");
    pater.appendChild(fcont);

}

document.addEventListener("DOMContentLoaded", function(event) { 

    init();

});