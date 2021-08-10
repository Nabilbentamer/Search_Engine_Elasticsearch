// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");

inputBox.onkeyup = (e)=>{
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
                    searchWrapper.classList.remove("active"); //hide autocomplete box
                    console.log(data);
                }
                


                searchWrapper.classList.add("active"); //show autocomplete box
                showSuggestions(suggestions);
    
            }
            else{
                console.log("no working");
            }
        }

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('q='+userData);

        searchWrapper.classList.add("active"); //show autocomplete box
        showSuggestions(suggestions);

    }
    else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }    

}


function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>${userValue}</li>`;
    }else{
      listData = list.join('');
    }
    suggBox.innerHTML = listData;
}