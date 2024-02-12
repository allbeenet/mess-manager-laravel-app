<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="as-app-container">
            <div class="as-app-navbar">
                <div class="as-app-navbar-content">
                    <div class="as-flex as-flex-center">
                        @if(Request::path() == '/')
                            <div class="as-dynamic-cursor as-app-navbar-name">মেস ম্যানেজার</div>
                        @else
                            @include('icons.menu-icon')
                            <div class="as-ml-10px as-dynamic-cursor as-app-navbar-name">মেস ম্যানেজার</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="as-app-body">
                @include('components.navdrawer')
                @yield('content')
            </div>
        </div>

        <script>
            function logout() {
                axios.post('/logout')
                    .then((res) => {
                        if (res.data['status'] == 200) {
                            location.replace('/')
                        } else {
                            barToast.error({text: 'Failed to logout'})
                        }
                    })
                    .catch((error) => {
                        barToast.error({text: 'Failed to logout'})
                    })
            }

            function closeNavbar(){
                document.getElementById('navbar-background').style.display = 'none'
                document.getElementById('navbar').style.left = '-300px'
            }
            function showNavbar(){
                document.getElementById('navbar-background').style.display = 'block'
                document.getElementById('navbar').style.left = '0px'
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="{{asset('js/asteroid-v1.js')}}"></script>
        <script src="{{asset('js/bartoast-v1.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        @yield('script')
    </body>
</html>
