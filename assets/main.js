/**
 * @author Gaëllan
 * @author Elefranc1
 */

// AJAX function compatible with all browsers
function ajaxJS(type, url, data, response)
{
    var xhttp = new XMLHttpRequest();
    xhttp.open(type, url, true);
    xhttp.onreadystatechange = function() 
    {
        // staut 200 = statut OK, readyState 4 = prêt
        if (this.readyState == 4 && this.status == 200) 
        {
          // Response
          response.call(this,this.responseText)
        }
    
    };
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    console.log(JSON.stringify(data));
    xhttp.send(data);
    
}

window.addEventListener("DOMContentLoaded", (event) => {
    
    // PAGINATION Admin Pannel Products

    let categoryFilter = document.getElementById("categoryFilter");
    let allPageButtons = document.querySelectorAll("[id^='page']");
     if(allPageButtons!=null && categoryFilter!=null)
     {
        let categoryFilterId=categoryFilter.value;
        for (var i = 0; i < allPageButtons.length; i++) 
            {
                allPageButtons[i].addEventListener('click', function(event) {
                console.log("click changement de page!");      
                let pageNumber=this.id;
                pageNumber=pageNumber.substring(4)
                
                formDataPage = new FormData();
                formDataPage.append('data', 'pageChange');
                formDataPage.append('pageNumber', pageNumber);
                
                console.log(formDataPage);
                console.log(pageNumber);
                console.log(categoryFilterId);
               
                const optionsPage = {
                    method: 'POST',
                    body: JSON.stringify({page : pageNumber, categoryId : categoryFilterId},)
                };
                
                let req= new Request('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/changePage', optionsPage)
                console.log(req);
                
                // fetch('/ProjetFinal/projet_freaky-kawaii-molds/src/templates/formData/_manageProductChangePage.phtml', optionsPage)
                //         .then(response => response.json())
                //         .then(data => {
                //         }); 
                
                fetch(req)
                    .then(response => response.text())
                    .then(response => {
                        document.getElementById("target").innerHTML = response;
                    })
    
              });
            }
     }
    
    
    
    // SEARCH PRODUCTS ADMIN
    let input = document.querySelector("#search");
    if(input!=null && categoryFilter!=null)
    {
        let categoryFilterId=categoryFilter.value;
        input.addEventListener('keyup', ()=>{
        // Everytime the user presses a key
        // we retrieve the text written 
        let textFind = document.querySelector("#search").value;
        
        // We create a request object
         let req = new Request('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/searchProduct',{
             method: "POST",
             body: JSON.stringify({textToFind : textFind, categoryId : categoryFilterId})
         })
         console.log(req);
        
        // We fetch the PHP response
        fetch(req)
            .then(response => response.text())
            .then(response => {
                document.getElementById("target").innerHTML = response;
            })
    
    // ajaxJS(
    //     'POST',
    //     '/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/searchProduct',
    //     'searchField='+textFind,
    //     function(retour){
    //         document.getElementById("target").innerHTML = retour;
    //     }
    // );
        
    });
    }
    
   
    // // CATEGORY FILTER ADMIN
    // let categoryFilter = document.querySelector("#categoryFilter"); 
    // if(categoryFilter!=null)
    // {
    //     categoryFilter.addEventListener('change', ()=>{
    //     // Everytime the user selects a category
    //     // we retrieve the value selected 
    //     let categoryFilterId = document.querySelector("#categoryFilter").value;
        
    //     console.log(categoryFilterId);
        
    //     // We create a request object
    //      let req = new Request('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/filterByCategory',{
    //          method: "POST",
    //          body: JSON.stringify({categoryId : categoryFilterId})
    //      })
    //      console.log(req);
        
    //     // // We fetch the PHP response
    //     // fetch(req)
    //     //     .then(response => response.text())
    //     //     .then(response => {
    //     //         document.getElementById("target").innerHTML = response;
    //     //     })
        
    // });
    // }
    
    
    
    
    
    // VARIANTS
        
        let variantIdCount=0;
        
        // We add a listener on every button that will remove an
        // existing variant
        let allRemoveButtons = document.querySelectorAll("[id^='remove']");
        //console.log(allRemoveButtons);
        //console.log("Found", allRemoveButtons.length, "button which id starts with “remove”.");
        if(allRemoveButtons!=null)
        {
            for (var i = 0; i < allRemoveButtons.length; i++) 
            {
              allRemoveButtons[i].addEventListener('click', function(event) {
                event.preventDefault();
                //console.log("You clicked:", this.innerHTML);
                this.parentNode.parentNode.removeChild(this.parentNode);
                
                
                // FETCH to call the "removeVariant" method
               let variantId=this.id;
               variantId=variantId.substring(15)
               console.log(variantId);
               
               formDataRemove = new FormData();
               formDataRemove.append('data', 'remove');
               formDataRemove.append('variantId', variantId);
               
                const optionsRemove = {
                    method: 'POST',
                    body: formDataRemove
                };
                
                 fetch('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/removeVariant', optionsRemove)
                        .then(response => response.json())
                        .then(data => {
                        });
                
              });
            }
        }
        
        
        
        
        // Everytime we click on "Ajouter une variante", we add 
        // another variant on the list and on the corresponding array
       addVariant = document.getElementById("addVariant");
       
        if(addVariant!=null)
        {
           addVariant.addEventListener('click', function(event){
               event.preventDefault();
               variantLabel = document.getElementById("newVariantLabel").value;
               variantPrice = document.getElementById("newVariantPrice").value;
               
               formData = new FormData();
               formData.append('data', true);
               formData.append('variantLabel', variantLabel);
               formData.append('variantPrice', variantPrice); 
               
               
               const options = {
                    method: 'POST',
                    body: formData
                };
                
                if(variantLabel!="" && variantPrice!="")
                {
                    //We add the new variant in the html list
                    fetch('/ProjetFinal/projet_freaky-kawaii-molds/src/templates/formData/_addVariant.phtml', options)
                        .then(response => response.text())
                        .then(data => {
                            addedVariant = document.getElementById("addedVariant");
                            let ul = document.getElementById("variantsList");
                            let li = document.createElement("li");
                            li.innerHTML=data;
                            let children = ul.children.length + 1;
                            ul.appendChild(li);
                            delbttn=document.getElementById("removeNewVariant");
                            //let newId="removeNewVariant".concat(children);
                            let newId=variantIdCount;
                            variantIdCount++;
                            delbttn.setAttribute("id", newId);
                            
                            delbttn.addEventListener('click', function(event) {
                            event.preventDefault();
                            // We add a listener so we can cancel the new Variant
                            // if we click on the delete button
                            console.log("You clicked:", this);
                            this.parentNode.parentNode.removeChild(this.parentNode);
                            
                             // FETCH to call the "cancelVariant" method
                               let variantId=this.id;
                               
                               formDataCancel = new FormData();
                               formDataCancel.append('data', 'remove');
                               formDataCancel.append('variantId', variantId);
                               
                                const optionsCancel = {
                                    method: 'POST',
                                    body: formDataCancel
                                };
                                
                                 fetch('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/cancelVariant', optionsCancel)
                                        .then(response => response.json())
                                        .then(data => {
                                        });
                            
                            
                            });
                        });
                        
                
    
                formDataAdd = new FormData();
                formDataAdd.append('data', 'add');
                formDataAdd.append('variantLabel', variantLabel);
                formDataAdd.append('variantPrice', variantPrice); 
                // stocking the ID :
                let ul = document.getElementById("variantsList");
                let addedVariantId = variantIdCount;
                formDataAdd.append('variantId', addedVariantId); 
                
                const optionsAdd = {
                    method: 'POST',
                    body: formDataAdd
                };
                    
                    
                fetch('/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/addVariant', optionsAdd)
                        .then(response => response.json())
                        .then(data => {
                        });
                }
    
           });
      
        }



  }
  
  
  
  );
  
  
