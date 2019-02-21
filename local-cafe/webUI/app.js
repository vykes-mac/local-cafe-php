const cafeList = $("#cafe-list").get(0);
const form = $("#add-cafe-form").get(0);

let update = false;
let updateId = -1;

function renderCafe(cafe) {
    let li = document.createElement("li");
    let name = document.createElement("span");
    let location = document.createElement("span");
    let del = document.createElement("div");

    li.setAttribute('data-id',cafe.id);
    name.textContent = cafe.name;
    location.textContent = cafe.location;
    del.textContent = 'x';

    li.appendChild(name);
    li.appendChild(location);
    li.appendChild(del);

    cafeList.appendChild(li);

    //delete data
    del.addEventListener('click', (e)=> {
        e.stopPropagation();
        let id = e.target.parentElement.getAttribute('data-id');
        deleteData(id);
    });

    li.addEventListener('click', (e)=> {
        e.stopImmediatePropagation();
        updateId = e.target.parentElement.getAttribute('data-id');
        form.name.value = name.textContent;
        form.location.value = location.textContent;
        update = true;
        $('#button').get(0).textContent = 'Save';
    });
}

function removeElement(id){
    $(`[data-id=${id}]`).remove();
}

function updateCafe(cafe) {
    console.log(cafe);
    $(`[data-id=${cafe.id}] span:first-child`).text(cafe.name);
    $(`[data-id=${cafe.id}] span:nth-child(2)`).text(cafe.location);
    form.name.value = "";
    form.location.value="";
    update = false;
    $('#button').get(0).textContent = 'Add Cafe';
}

//saving data
form.addEventListener('submit', (e) => {
    e.preventDefault();
    let data = {
        'name' : form.name.value,
        'location': form.location.value
    }
    if (update == false){
        saveData(data);
    }else {
        updateData(data);
    }
   
});

form.addEventListener('reset', (e) => {
    //e.preventDefault();
    update = false;
    $('#button').get(0).textContent = 'Add Cafe';

});


//Api calls to fetch,create, update and delete data

$.ajax({
    method: "GET",
    url: "http://localhost:8080/",
    crossDomain: true,
    cache: false
}).done((data)=> {
    data.forEach(cafe => {
        renderCafe(cafe);
    });
});

//delete record

function deleteData(id){
    $.ajax({
        method: "DELETE",
        url: `http://localhost:8080/cafe/${id}`,
        crossDomain: true,
        cache: false
    }).done((data)=> {
            removeElement(id);
    });
}


//save data to db
function saveData(data){
    fetch("http://localhost:8080/create",{
            method: "post",
            headers: {"Content-type" : "json"},
            body: JSON.stringify(data)
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
           renderCafe(data);
           form.reset();
        })
        .catch((error)=>{
            console.log(error);
        });
}

//update
function updateData(data){
    fetch(`http://localhost:8080/update/${updateId}`,{
            method: "put",
            headers: {"Content-type" : "json"},
            body: JSON.stringify(data)
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
           updateCafe(data);
        })
        .catch((error)=>{
            console.log(error);
        });
}