@extends('app')

@section('content')
    <div class="as-app-body-content as-flex as-flex-space-between as-h-95">
        {{-- menus --}}
        @include('components.menu')

        {{-- meal --}}
        <div  class="as-w-100 as-bg-white as-p-10px md:as-w-70 as-card">
            <div class="as-flex as-flex-space-between">
                <button onclick="openDialog()" class="as-button as-dynamic-cursor">মিল যুক্ত করুন</button>

                <select class="as-select-free" id="filter-member">
                    <option value="" hidden>ফিল্টার করুন</option>
                    <option value="">সব দেখুন</option>
                </select>
            </div>

            {{-- total --}}
            <div class="as-flex as-flex-end as-mt-10px">
                <b>মোট মিল:</b> &nbsp 
                <b class="as-color-primary" id="totalMeals"></b>
            </div>

             {{-- meals --}}
            <div style="overflow-y: auto; height: 85%" id="meals" class="as-mt-10px"></div>
        </div>

        {{-- create dialog --}}
        <div style="z-index:999" id="dialog" class="as-hide as-absolute as-w-100 as-h-100 as-top-0 as-left-0 as-bg-transparent-black">
            <div class="as-w-100 as-h-100 as-flex as-flex-center">
                <div class="as-grow as-w-300px as-bg-white as-card as-p-20px">

                    <input value="2.5" id="meal-quantity" class="as-input as-mt-10px" type="number" placeholder="Meal quantity"><br>
                    <select class="as-select as-mt-10px" id="select-member">
                        <option value="" hidden>Select member</option>
                    </select>

                    <div class="as-flex as-flex-center as-mt-15px">
                        <button id="saveButton" onclick="saveMeal()" class="as-button as-mr-5px as-dynamic-cursor">Save</button>
                        <button id="updateButton" onclick="updateMeal()" class="as-button as-mr-5px as-dynamic-cursor">Update</button>
                        <button class="as-bg-black as-btn as-dynamic-cursor as-min-w-70px" onclick="hideDialog()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
<script>
    getMembers()
    getMeals()
    getTotalMeals()

    var mealId

    function getMembers(){
        axios.post('/get-members')
        .then((res)=>{
            var data    = res.data
            var selectMember = document.getElementById('select-member')
            var filterMember  = document.getElementById('filter-member')

            data.forEach((element, index) => {
                selectMember.innerHTML += `<option value="${element['id']}">${element['member_name']}</option>`
                filterMember.innerHTML  += `<option value="${element['id']}">${element['member_name']}</option>`
            })
        })
        .catch((error)=>{})
    }

    //filtering
    const filterMember = document.getElementById("filter-member");

    filterMember.addEventListener("change", function() {
        const memberId = filterMember.value;

        axios.post('filter-meal', {'member_id': memberId})
        .then((res)=>{
            console.log(res)
            var data  = res.data.records
            var meals = document.getElementById('meals') 
            document.getElementById('totalMeals').innerHTML = res.data.amount

            meals.innerHTML = ''

            data.forEach((element, index) => {
                meals.innerHTML +=
                `<div class="as-relative">
                    <div class="as-flex as-flex-space-between as-mb-5px as-card as-bg-white as-simple-list as-dynamic-cursor as-font-normal">
                        <div>
                            <div class="as-simple-list-title">${element['member_name']}</div>
                            <div class="">Amount: ${element['meal_quantity']}</div>
                            <div class="">Date: ${element['meal_date']}</div>
                        </div>
                        <div onclick="showMenu(${index})">
                            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                        </div> 
                    </div>
                    <div style="z-index:1; display: none" class="actionMenu as-absolute as-right-30px as-top-20px as-font-15px as-bg-white as-card as-p-20px">
                        <div class="as-flex as-flex-v-center as-dynamic-cursor" onclick="showUpdateDialog('${element['meal_quantity']}', ${element['id']})"><ion-icon name="create-outline" class="as-mr-5px"></ion-icon>Edit</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="deleteMeal(${element['id']})"><ion-icon name="close-circle-outline" class="as-mr-5px"></ion-icon>Delete</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="hideActionMenu(${index})"><ion-icon name="close-outline" class="as-mr-5px"></ion-icon>Cancel</div>
                    </div>
                </div>`
            })
        })
        .catch((err)=>{})
    });

    //getting total deposit amount
    function getTotalMeals(){
        axios.post('/get-total-meals')
        .then((res)=>{
            document.getElementById('totalMeals').innerHTML = res.data
        })
        .catch((err)=>{})
    }

    //create
    function saveMeal(){
        var mealQuantity = document.getElementById('meal-quantity').value
        var memberId     = document.getElementById('select-member').value

        if(mealQuantity == ''){
            barToast.warning({text: "Enter meal quantity", parent: 'dialog'})
        }
        else if(memberId == ''){
            barToast.warning({text: "Select member", parent: 'dialog'})
        }
        else{
            axios.post('/save-meal', {'meal_quantity': mealQuantity, 'member_id': memberId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMeals()
                    getTotalMeals()
                    document.getElementById('select-member').value = ''
                    barToast.success({text: 'Successfully saved', parent: 'dialog'})
                }
                else{
                    barToast.error({text: 'Failed to save', parent: 'dialog'})
                }
            })
            .catch((error)=>{
                barToast.error({text: 'Failed to save', parent: 'dialog'})
            })
        }
    }

    //read
    function getMeals(){
        axios.post('/get-meals')
        .then((res)=>{
            var data  = res.data
            var meals = document.getElementById('meals')

            meals.innerHTML = ''

            data.forEach((element, index) => {
                meals.innerHTML +=
                `<div class="as-relative">
                    <div class="as-flex as-flex-space-between as-mb-5px as-card as-bg-white as-simple-list as-dynamic-cursor as-font-normal">
                        <div>
                            <div class="as-simple-list-title">${element['member_name']}</div>
                            <div class="">Amount: ${element['meal_quantity']}</div>
                            <div class="">Date: ${element['meal_date']}</div>
                        </div>
                        <div onclick="showMenu(${index})">
                            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                        </div> 
                    </div>
                    <div style="z-index:1; display: none" class="actionMenu as-absolute as-right-30px as-top-20px as-font-15px as-bg-white as-card as-p-20px">
                        <div class="as-flex as-flex-v-center as-dynamic-cursor" onclick="showUpdateDialog('${element['meal_quantity']}', ${element['id']})"><ion-icon name="create-outline" class="as-mr-5px"></ion-icon>Edit</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="deleteMeal(${element['id']})"><ion-icon name="close-circle-outline" class="as-mr-5px"></ion-icon>Delete</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="hideActionMenu(${index})"><ion-icon name="close-outline" class="as-mr-5px"></ion-icon>Cancel</div>
                    </div>
                </div>`
            })
        })
        .catch((error)=>{})
    }

    //showing update dialog
    function showUpdateDialog(mealQuantity, id){
        mealId = id
        openDialog()

        document.getElementById('meal-quantity').value = mealQuantity
        document.getElementById('select-member').style.display = "none"

        document.getElementById('saveButton').classList.add('as-hide')
        document.getElementById('updateButton').classList.remove('as-hide')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }
    }

    //update
    function updateMeal(){
        var mealQuantity = document.getElementById('meal-quantity').value

        if(mealQuantity == ''){
            barToast.warning({text: "Enter meal quantity", parent: 'dialog'})
        }
        else{
            axios.post('/update-meal', {'meal_quantity': mealQuantity, 'meal_id': mealId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMeals()
                    getTotalMeals()
                    document.getElementById('meal-quantity').value = ''
                    hideDialog()
                    barToast.success({text: 'Successfully updated'})
                }
                else{
                    barToast.error({text: 'Failed to update', parent: 'dialog'})
                }
            })
            .catch((err)=>{
                barToast.error({text: 'Failed to update', parent: 'dialog'})
            })
        }
    }

    //delete
    function deleteMeal(mealId){
        var confirmation = confirm('Do you want to delete?')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }

        if(confirmation){
            axios.post('/delete-meal', {'meal_id': mealId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMeals()
                    getTotalMeals()
                    barToast.success({text: 'Successfully deleted'})
                }
                else{
                    barToast.error({text: 'Failed to delete'})
                }
            })
            .catch((error)=>{
                barToast.error({text: 'Failed to delete'})
            })
        }
    }
</script>
@endsection
