@extends('app')

@section('content')
    <div class="as-app-body-content as-flex as-flex-space-between as-h-95">
        {{-- menus --}}
        @include('components.menu')

        <div class="as-w-100 as-bg-white as-p-10px md:as-w-70 as-card">
            <div class="as-flex as-flex-space-between">
                <button onclick="openDialog()" class="as-button as-dynamic-cursor">বাজার যুক্ত করুন</button>
            
                {{-- total --}}
                <div class="as-flex as-flex-end as-mt-10px">
                    <b>মোট পরিমান:</b> &nbsp 
                    <b class="as-color-primary" id="totalBazarAmount"></b>
                    <b class="as-color-primary">/-</b>
                </div>
            </div>

             {{-- bazars --}}
            <div style="overflow-y: auto; height: 90%" id="bazars" class="as-mt-10px"></div>
        </div>

        {{-- create dialog --}}
        <div style="z-index:999" id="dialog" class="as-hide as-absolute as-w-100 as-h-100 as-top-0 as-left-0 as-bg-transparent-black">
            <div class="as-w-100 as-h-100 as-flex as-flex-center">
                <div class="as-grow as-w-300px as-bg-white as-card as-p-20px">

                    <input id="bazarAmount" class="as-input as-mt-10px" type="number" placeholder="Bazar's Amount"><br>

                    <div class="as-flex as-flex-center as-mt-15px">
                        <button id="saveButton" onclick="saveBazar()" class="as-button as-mr-5px as-dynamic-cursor">Save</button>
                        <button id="updateButton" onclick="updateBazar()" class="as-button as-mr-5px as-dynamic-cursor">Update</button>
                        <button class="as-bg-black as-btn as-dynamic-cursor as-min-w-70px" onclick="hideDialog()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
<script>
    getTotalBazarAmount()
    getBazars()
    var bazarId

    //getting total member
    function getTotalBazarAmount(){
        axios.post('/get-total-bazar-amount')
        .then((res)=>{
            document.getElementById('totalBazarAmount').innerHTML = res.data
        })
        .catch((err)=>{})
    }

    //create
    function saveBazar(){
        var bazarAmount = document.getElementById('bazarAmount').value

        if(bazarAmount == ''){
            barToast.warning({text: "Enter bazar's amount", parent: 'dialog'})
        }
        else{
            axios.post('/save-bazar', {'bazar_amount': bazarAmount})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getBazars()
                    getTotalBazarAmount()
                    document.getElementById('bazarAmount').value = ''
                    barToast.success({text: 'Saved', parent: 'dialog'})
                }
                else if(res.data['status'] == 409){
                    barToast.error({text: 'Bazar already exists', parent: 'dialog'})
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
    function getBazars(){
        axios.post('/get-bazars')
        .then((res)=>{
            var data   = res.data
            var bazars = document.getElementById('bazars')

            bazars.innerHTML = ''

            data.forEach((element, index) => {
                bazars.innerHTML +=
                `<div class="as-relative">
                    <div class="as-flex as-flex-space-between as-mb-5px as-card as-bg-white as-simple-list as-dynamic-cursor as-font-normal">
                        <div>
                            <div class="as-title">Amount: ${element['bazar_amount']}/-</div>
                            <div class="">Date: ${element['bazar_date']}</div>
                        </div>
                        <div onclick="showMenu(${index})">
                            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                        </div> 
                    </div>
                    <div style="z-index:1; display: none" class="actionMenu as-absolute as-right-30px as-top-20px as-font-15px as-bg-white as-card as-p-20px">
                        <div class="as-flex as-flex-v-center as-dynamic-cursor" onclick="showUpdateDialog('${element['bazar_amount']}', ${element['id']})"><ion-icon name="create-outline" class="as-mr-5px"></ion-icon>Edit</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="deleteBazar(${element['id']})"><ion-icon name="close-circle-outline" class="as-mr-5px"></ion-icon>Delete</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="hideActionMenu(${index})"><ion-icon name="close-outline" class="as-mr-5px"></ion-icon>Cancel</div>
                    </div>
                </div>`
            })
        })
        .catch((error)=>{})
    }

    //showing update dialog
    function showUpdateDialog(bazarAmount, id){
        bazarId = id
        openDialog()

        document.getElementById('bazarAmount').value = bazarAmount

        document.getElementById('saveButton').classList.add('as-hide')
        document.getElementById('updateButton').classList.remove('as-hide')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }
    }
    
    //update
    function updateBazar(){
        var bazarAmount = document.getElementById('bazarAmount').value

        if(bazarAmount == ''){
            barToast.warning({text: "Enter bazar's amount", parent: 'dialog'})
        }
        else{
            axios.post('/update-bazar', {'bazar_amount': bazarAmount, 'bazar_id': bazarId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getBazars()
                    getTotalBazarAmount()
                    document.getElementById('bazarAmount').value = ''
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
    function deleteBazar(bazarId){
        var confirmation = confirm('Do you want to delete?')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }

        if(confirmation){
            axios.post('/delete-bazar', {'bazar_id': bazarId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getBazars()
                    getTotalBazarAmount()
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
