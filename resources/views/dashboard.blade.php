@extends('app')

@section('content')
    <div class="as-app-body-content as-flex as-flex-space-between as-h-95">
        {{-- menus --}}
        @include('components.menu')

        {{-- dashboard desktop --}}
        <div class="as-hide as-w-100 as-bg-white as-p-10px md:as-w-70 as-card">

            <section class="splide splide-box">
                <div class="splide__track">
                    <ul class="splide__list">

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$total_members}}</div>
                            <div class="title-view as-mt-5px">মোট সদস্য</div>
                        </div>

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$total_deposited_amount}}/-</div>
                            <div class="title-view as-mt-5px">মোট জমা</div>
                        </div>

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$total_bazar_amount}}/-</div>
                            <div class="title-view as-mt-5px">মোট বাজার</div>
                        </div>

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$total_remaining}}/-</div>
                            <div class="title-view as-mt-5px">অবশিষ্ট</div>
                        </div>

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$total_meals}}</div>
                            <div class="title-view as-mt-5px">মোট মিল</div>
                        </div>

                        <div class="splide__slide as-card as-bg-primary as-color-white as-p-10px">
                            <div class="number-view as-br-b-1px as-font-bold as-font-22px">{{$meal_rate}}/-</div>
                            <div class="title-view as-mt-5px">মিল রেট</div>
                        </div>

                    </ul>
                </div>
            </section>

        </div>

        {{--dashboard mobile--}}

    </div>
@endsection

@section('script')
<script>
    new Splide('.splide-box', {
        perPage: 5,
        perMove: 1,
        autoplay: false,
        arrows: true,
        pagination: false,
        rewind: false,
        gap: '.5rem',
        breakpoints: {
            '640': {
                perPage: 3,
                gap: '.5rem',
            },
            '480': {
                perPage: 2,
                gap: '.5rem',
            },
        }
    }).mount();
</script>
@endsection
