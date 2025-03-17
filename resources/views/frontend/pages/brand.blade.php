@extends('frontend.layouts.master')

@section('content')
    <div class="ws-container">

        @php
            $data = [];
            $data[$totalBrands . ' Marken ' . ($category ? 'aus dem Bereich ' . optional($category)->name : '')] = null;
        @endphp

        @include('frontend.pages.include.breadcrumb', [
            'data' => $data,
        ])


        <h1 class="ws-c" id="backUp">Markenübersicht {{ optional($category)->name }}</a></h1>

        <p class="ws-c">{{ $totalBrands }} Marken</p>

        <div class="headline ws-g ws-c search-filter">
            <div class="ws-u-1" style="background-color:#666">
                <ul class="ws-u-1 filter-dropnav" id="headLineMobile" style="display: block; padding: 10px 0 ;">
                    <li class="filter-item noHover">
                        <div id="markenabisz_suche">
                            <input placeholder="Suchbegriff eingeben..." type="text" list="markendata">
                            <datalist id="markendata">

                                <option value="Zorr"></option>
                            </datalist>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        @foreach ($brands as $key => $brand)
            <div class="ws-c "id="markenabisz">
                <div class="charContainer">
                    <h2 id="keychar{{ $key }}">{{ $key }}</h2>
                    <div class="markenListe ws-g">

                        @foreach ($brand as $item)
                            <a href="{{ route('products', $item['slug']) }}"
                                class="markeContainer ws-u-1 ws-u-sm-1-3 ws-u-md-1-4 ws-u-lg-1-6"
                                data-marke="{{ $item['name'] }}" data-isvisible="true">
                                <div class="markeInnerContainer search-result-item-inner">
                                    <div class="markeLink">
                                        <div class="markeInnerBildContainer image">

                                            <img class="markeInnerBild markeBild"
                                                alt="Wir haben die Marke {{ $item['name'] }} mit {{ $item['products_count'] }} Produkten."
                                                title="{{ $item['name'] }} mit {{ $item['products_count'] }} Produkten."
                                                src="{{ showImage($item['image']) }}"
                                                data-src="{{ showImage($item['image']) }}" />

                                        </div>
                                        <div class="markeTextContainer">
                                            <span class="markeTextSpan">{{ $item['name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        <div class="markeContainer backUp ws-u-1-1">
                            <a class="backUpLink ws-u-1-1" href="#backUp">
                                nach Oben </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach




    </div>

    <div class="ws-container">
        <div class="modal fade modal-regional-settings" id="modal_regional_settings" tabindex="-1" role="dialog"
            aria-labelledby="modal_regional_settings_label">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">loading...</div>
                </div>
            </div>
        </div>


    </div>
@endsection


@push('scripts')
    <script>
        var DDHeight = 1;
        var DDdynamic = document.getElementById("myDropdown10");
        if (DDdynamic != null) {
            DDHeight = DDdynamic.getElementsByTagName('a').length;
        }

        DDHeight = DDHeight * 38 - 3;



        var marken = $('[data-marke]');
        var input = $('#markenabisz_suche > input[type="text"]');

        input.on('keyup input', function(e) {
            e.preventDefault();
            var el = $(this);
            var val = el.val();

            $.each(marken, function() {
                var obj = $(this);
                var marke = obj.attr('data-marke');
                if (marke.toLowerCase().indexOf(val.toLowerCase()) == -1) {
                    obj.css('display', 'none');
                    obj.attr('data-isVisible', 'false')
                } else {
                    obj.attr('data-isVisible', 'true')
                    obj.css('display', 'inline-block');
                }
            });

            var found = false;
            $('.charContainer').each(function() {
                var el = $(this);
                if (el.find('[data-isVisible="true"]').length == 0) {
                    el.css('display', 'none');
                } else {
                    el.css('display', 'block');
                    found = true;
                }
            });

            if (!found) {
                $('.noresult').css('display', 'block');
            } else {
                $('.noresult').css('display', 'none');
            }

        });

        var open = 0;

        function closeDropdown() {
            var dropdowns = document.getElementsByClassName("dropdownContent");
            var activeArrow = document.getElementsByClassName("dropDownActivator");

            var i;
            var j;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('showDD') && openDropdown.classList.contains('DDdynamic')) {
                    console.log('dropdowns:' + i);
                    openDropdown.classList.remove('showDD');
                    openDropdown.classList.remove('DDdynamic');
                    openDropdown.style.height = "0";
                } else if (openDropdown.classList.contains('showDD')) {
                    openDropdown.classList.remove('showDD');
                }
            }
            /*
            for (j = 0; j < activeArrow.length; j++) {
                console.log('activeArrow outer:'+j);
              var openActive = activeArrow[j];
              if (openActive.classList.contains('active')){
                       console.log('activeArrow:'+j);
                   openActive.classList.remove('active');
              }
            }*/
            for (j = 0; j < activeArrow.length; j++) {
                var openActive = activeArrow[j];
                if (openActive.classList.contains('active')) {
                    openActive.classList.remove('active');
                }
            }
        }


        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function myDropdown(field) {
            //console.log('myDropdown:'+field);
            if (open != field) {
                closeDropdown();
                document.getElementById("indiC" + field).classList.toggle("active");
                document.getElementById("myDropdown" + field).classList.toggle("showDD");
                if (field >= 9) {
                    document.getElementById("myDropdown" + field).classList.add("DDdynamic");
                    var element = document.getElementsByClassName("DDdynamic");
                    element[0].style.height = DDHeight + "px";
                }
                open = field;
            } else {
                closeDropdown();
                open = 0;
            }

        }

        // Close the dropdown menu if the user clicks outside of it

        onclick = function(event) {
            if (window.innerWidth >= 1024) {
                if (!event.target.matches('.dropDownActivator')) {
                    closeDropdown();
                }
            }
        }
    </script>
@endpush


@push('styles')
    <style>
        .headerCharContainer {
            background-color: yellow;
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #666;
        }

        .headerCharItem {
            width: 5em;
            float: left;
            /*padding: 0.2rem 1.8rem;*/
            border-right: 1px solid rgba(255, 255, 255, 0.75);
        }

        .headerCharItemLink {
            display: block;
            color: white;
            text-align: center;
            padding: 15px;
            text-decoration: none;
        }

        .headerCharItemLink:hover {
            background-color: rgba(255, 255, 255, .15);
        }

        .markenListe {
            /*list-style-type: none;
                                                                                                                                        margin: 0;
                                                                                                                                        padding: 0;*/
            /*display: block;
                                                                                                                                        margin-bottom: 1%;*/

        }

        .markeContainer {
            /*width: 49%;overflow: hidden;float: left;margin-right: 1%;height: 240px;background: #fff;margin-bottom: 1em;position: relative;*/
            /*height: 55px;
                                                                                                                                        width: 130px;
                                                                                                                                        margin: 13px;
                                                                                                                                        display: block;
                                                                                                                                        float: left;
                                                                                                                                        text-align: center;
                                                                                                                                        outline: none;*/
            padding: 0.625rem;
            text-align: center;
            /*background-color: violet;*/
        }

        .markeInnerContainer {
            padding: 0.625rem;
            min-height: 200px;
            position: relative;
        }

        .markeLink {
            /*display: block;
                                                                                                                                        padding: 8px;
                                                                                                                                        background-color: #dddddd;*/
        }

        .markeInnerBildContainer {
            /*width: 100%;height: 100px;display: block;text-align: center;margin-bottom: 2em;*/
            /*width: 120px;
                                                                                                                                        height: 120px;*/
        }

        .markeInnerBild {
            max-width: 110px;
            max-height: 110px;
            top: 41%;
            transform: translate(-50%, -50%);
            position: absolute;
        }

        .markeTextContainer {
            /*font-weight: bold;display: block;padding: 1em;color:#000;*/
            background-color: rgba(0, 0, 0, 0.035);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;

        }

        .markeTextSpan {
            text-transform: uppercase;

            font-weight: 700;

            text-align: right;
            font-size: 1.2em;
            line-height: 2em;
            color: #555;

            /*
                                                                                                                                        color: #fff;
                                                                                                                                        background-color: #7B2222;*/
        }

        .backUp {
            text-transform: uppercase;
            background-color: #7B2222;
            font-weight: 700;
            font-size: 1.2em;
            line-height: 2em;
            color: #fff;
            margin-top: 1rem;
        }

        #markenabisz_suche {
            width: 100%;
            font-size: 2rem;
            padding-left: 1.8rem;
        }

        #markenabisz_suche input[type="text"] {
            font-size: 2rem;
            display: inline-block;
            width: 85%;
            vertical-align: middle;
            font-weight: 700;
            border: none;
            background-color: #ddd;
            font-size: 18px;
            padding: 5px;
            width: 261px;

        }

        @media screen and (max-width: 1024px) {
            #markenabisz_suche {
                padding: 1rem !important;
            }

            .markeTextSpan {
                font-size: 1.8rem !important;
                line-height: 1em !important;
            }
        }

        .noHover :hover {
            background-color: #666;
        }

        .showDD.DDshort {
            display: block;
            line-height: 3.5rem;
            font-size: 1.1em;
            background-color: rgba(228, 228, 228, 1);
            height: 72px;
        }

        .filter-item>.headerItem>.caret-indicators {
            position: absolute !important;
            right: 10px !important;
            top: 20px;
            pointer-events: none;
        }

        .active>.caret-indicators {
            transform: rotateX(180deg);
            -webkit-transform: rotateX(180deg);
        }
    </style>
@endpush
