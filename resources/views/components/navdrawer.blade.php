<div onclick="closeNavbar()" id="navbar-background"
     class='as-z-index999 as-hide as-w-100 as-h-100 as-bg-transparent-black as-fixed as-top-0 as-left-0'></div>

<div id="navbar" class='as-z-index999 as-w-250px as-h-100 as-bg-white as-p-10px as-fixed as-top-0 as-left-0'>
    <div class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.dashboard-icon')
        <div class="as-simple-list-title as-ml-10px">ড্যাশবোর্ড</div>
    </div>
    <div onclick="window.location.href = '/member'" class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.member-icon')
        <div class="as-simple-list-title as-ml-10px">সদস্য</div>
    </div>
    <div class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.deposit-icon')
        <div class="as-simple-list-title as-ml-10px">জমা</div>
    </div>
    <div class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.bazar-icon')
        <div class="as-simple-list-title as-ml-10px">বাজার</div>
    </div>
    <div class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.meal-icon')
        <div class="as-simple-list-title as-ml-10px">মিল</div>
    </div>
    <div onclick="logout()" class="as-simple-list as-dynamic-cursor as-font-normal">
        @include('icons.logout-icon')
        <div class="as-simple-list-title as-ml-10px">লগআউট</div>
    </div>
</div>
