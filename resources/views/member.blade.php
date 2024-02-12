@extends('app')

@section('content')
    <div class="as-app-body-content">
        {{-- menus --}}
        @include('components.menu')

        {{--member mobile--}}
        <button onclick="openDialog()" class="as-fab as-dynamic-cursor">সদস্য যুক্ত করুন</button>
        <div id="members"></div>


        {{-- create member dialog --}}
        <div style="z-index:999" id="dialog" class="as-hide as-absolute as-w-100 as-h-100 as-top-0 as-left-0 as-bg-transparent-black">
            <div class="as-w-100 as-h-100 as-flex as-flex-center">
                <div class="as-grow as-w-300px as-bg-white as-card as-p-20px">

                    <input id="memberName" class="as-input" type="text" placeholder="সদস্যের নাম"><br>
                    <input id="memberEmail" class="as-input as-mt-10px" type="text" placeholder="সদস্যের ইমেইল"><br>
                    <input id="memberNumber" class="as-input as-mt-10px" type="number" placeholder="সদস্যের নাম্বার"><br>

                    <div class="as-flex as-flex-center as-mt-15px">
                        <button id="saveButton" onclick="saveMember()" class="as-button as-mr-5px as-dynamic-cursor">সংরক্ষণ করুন</button>
                        <button id="updateButton" onclick="updateMember()" class="as-button as-mr-5px as-dynamic-cursor">হালনাগাদ করুন</button>
                        <button class="as-bg-black as-btn as-dynamic-cursor as-min-w-70px" onclick="hideDialog()">বাতিল করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    getMembers()
    //getMembersCount()

    var memberId

    //getting total member
    function getMembersCount(){
        axios.post('/get-members-count')
        .then((res)=>{
            document.getElementById('membersCount').innerHTML = res.data
        })
        .catch((err)=>{})
    }

    //create
    function saveMember(){
        var memberName   = document.getElementById('memberName').value
        var memberEmail  = document.getElementById('memberEmail').value
        var memberNumber = document.getElementById('memberNumber').value

        if(memberName == ''){
            barToast.warning({text: "সদস্যের নাম লিখুন", parent: 'dialog'})
        }
        else if(memberEmail == ''){
            barToast.warning({text: "সদস্যের ইমেইল লিখুন", parent: 'dialog'})
        }
        else if(memberNumber == ''){
            barToast.warning({text: "সদস্যের নাম্বার লিখুন", parent: 'dialog'})
        }
        else{
            axios.post('/save-member', {'member_name': memberName, 'member_email': memberEmail, 'member_number': memberNumber})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMembers()
                    //getTotalMembers()

                    document.getElementById('memberName').value   = ''
                    document.getElementById('memberEmail').value  = ''
                    document.getElementById('memberNumber').value = ''

                    barToast.success({text: 'সদস্য সংরক্ষণ করা হয়েছে', parent: 'dialog'})
                }
                else if(res.data['status'] == 409){
                    barToast.error({text: 'সদস্য ইতমধ্য সংরক্ষিত আছে', parent: 'dialog'})
                }
                else{
                    barToast.error({text: 'সদস্য সংরক্ষণ করা যায়নি', parent: 'dialog'})
                }
            })
            .catch((error)=>{
                barToast.error({text: 'সদস্য সংরক্ষণ করা যায়নি', parent: 'dialog'})
            })
        }
    }

    //read
    function getMembers(){
        axios.post('/get-members')
        .then((res)=>{
            var data    = res.data
            var members = document.getElementById('members')

            members.innerHTML = ''

            data.forEach((element, index) => {
                members.innerHTML +=
                `<div class="as-card as-bg-white as-p-10px as-mb-5px">
                    <div class="as-flex as-flex-space-between">
                        <div>
                            <div class="as-simple-list-title">${element['member_name']}</div>
                            <div class="">Email: ${element['member_email']}</div>
                            <div class="">Phone: ${element['member_number']}</div>
                        </div>
                        <div onclick="showMenu(${index})">
                            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                        </div>
                    </div>
                </div>
                <div onclick="hideMenu()" class="menu as-hide as-absolute as-w-100 as-h-100 as-top-0 as-left-0 as-bg-transparent-black">
                    <div class="as-anim-slideup as-h-100px as-w-100 as-bg-white as-absolute as-bottom-0 as-brr-t-10px as-p-10px as-border-box">
                        <button class="as-btn as-bg-green as-color-white as-w-100">হালনাগাদ করুন</button><br>
                        <button class="as-btn as-bg-red as-color-white as-w-100 as-mt-5px">মুছে ফেলুন</button>
                    </div>
                </div>`
            })
        })
        .catch((error)=>{})
    }

    //showing update dialog
    function showUpdateDialog(memberName, memberNumber, id){
        memberId = id
        openDialog()

        document.getElementById('memberName').value = memberName
        document.getElementById('memberNumber').value = memberNumber

        document.getElementById('saveButton').classList.add('as-hide')
        document.getElementById('updateButton').classList.remove('as-hide')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }
    }



    //update
    function updateMember(){
        var memberNewName   = document.getElementById('memberName').value
        var memberNewNumber = document.getElementById('memberNumber').value

        if(memberNewName == ''){
            barToast.warning({text: "Enter member's name", parent: 'dialog'})
        }
        else if(memberNewNumber == ''){
            barToast.warning({text: "Enter member's number", parent: 'dialog'})
        }
        else{
            axios.post('/update-member', {'member_name': memberNewName, 'member_number': memberNewNumber, 'member_id': memberId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMembers()
                    document.getElementById('memberName').value = ''
                    document.getElementById('memberNumber').value = ''
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
    function deleteMember(memberId){
        var confirmation = confirm('Do you want to delete?')

        var actionMenuList  = document.querySelectorAll(".actionMenu")
        for(var i=0; i<actionMenuList.length; i++){
            actionMenuList[i].style.display = "none"
        }

        if(confirmation){
            axios.post('/delete-member', {'member_id': memberId})
            .then((res)=>{
                if(res.data['status'] == 200){
                    getMembers()
                    getTotalMembers()
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

    //search
    function searchMember(){
        var memberName = document.getElementById('searchMember').value

        axios.post('/search-member', {'member_name': memberName})
        .then((res)=>{
            console.log(res.data)
            var data    = res.data
            var members = document.getElementById('members')

            members.innerHTML = ''

            data.forEach((element, index) => {
                members.innerHTML +=
                `<div class="as-relative">
                    <div class="as-flex as-flex-space-between as-mb-5px as-card as-bg-white as-simple-list as-dynamic-cursor as-font-normal">
                        <div>
                            <div class="as-simple-list-title">${element['member_name']}</div>
                            <div class="">Phone: ${element['member_number']}</div>
                        </div>
                        <div onclick="showMenu(${index})">
                            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                        </div>
                    </div>
                    <div style="z-index:1; display: none" class="actionMenu as-absolute as-right-30px as-top-20px as-font-15px as-bg-white as-card as-p-20px">
                        <div class="as-flex as-flex-v-center as-dynamic-cursor" onclick="showUpdateDialog('${element['member_name']}', '${element['member_number']}', ${element['id']})"><ion-icon name="create-outline" class="as-mr-5px"></ion-icon>Edit</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="deleteMember(${element['id']})"><ion-icon name="close-circle-outline" class="as-mr-5px"></ion-icon>Delete</div>
                        <div class="as-flex as-flex-v-center as-dynamic-cursor as-mt-10px" onclick="hideActionMenu(${index})"><ion-icon name="close-outline" class="as-mr-5px"></ion-icon>Cancel</div>
                    </div>
                </div>`
            })
        })
        .catch((error)=>{})
    }
</script>
@endsection
