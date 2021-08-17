// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");



function keyUpFunction(e){
    let userData = e.target.value; //retrieve the data that the user enetered
    let suggestions = [];

    if(userData){
        let xhr = new XMLHttpRequest();
        method = "POST";
        url = "search_as_you_type.php";
        xhr.open(method,url,true);
    
        xhr.onload = () => {
            if(xhr.readyState === 4 && xhr.status === 200){
    
                let data = xhr.response ;
                if(data!="no success"){

                    suggestions = JSON.parse(data);
                    suggestions = suggestions.map((data)=>{
                        return data = `<li>${data}</li>`;
                    })                    

                    

                }

                else if(data=="no success"){
                    console.log("cette reference n'exsite pas dans le moteur de recherche");
                }
                
                // show the box text: les reference possible ou bien 'cette reference n'existe pas"
                searchWrapper.classList.add("active"); //show autocomplete box
                showSuggestions(suggestions);
    
            }
            else{
                console.log("problem with loading php file");
            }
        }

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('q='+userData);

    }
    else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }
}



function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>Pas de fiche produit unique avec cette recherche</li>`;
    }else{
      listData = list.join('');
    }
    suggBox.innerHTML = listData;
}

// debounce function: 

const after_debounce = debounce((e) => keyUpFunction(e));

function debounce(func, timeout = 300){
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
  }

  inputBox.onkeyup = after_debounce;
