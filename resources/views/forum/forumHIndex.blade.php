@extends('main')


@section('head')
    <title>論壇首頁</title>
    <link rel="stylesheet" href="{{ asset('css/forumQIndex.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endsection


@section('content')
    <div id="content-container">
        <div class="row">
            <div class="column1">
                <h1>論壇</h1>
                @if(Auth::check())
                    <button id="btPublish" onclick="window.location.href ='{{ route('fomes') }}'">
                        發文
                    </button>
                @else
                    <button id="btPublish" onclick="window.location.href ='{{ route('login') }}'">
                        發文
                    </button>
                @endif
                <div id="tabContainer">
                    <div class="tab">
                        <button class="tablinks" onclick="window.location.href ='{{ route('foqindex') }}'">問題</button>
                        <button class="tablinks" onclick="window.location.href ='{{ route('fogindex') }}'">揪團</button>
                        <button class="tablinks" onclick="openCity(event, 'Paris')" id="defaultOpen">黑特</button>
                    </div>
                    <div id="Paris" class="tabcontent">
                        <form class="example" type="get" action="{{ route('fohindex') }}">
                            <input type="text" placeholder="輸入關鍵字" name="search" id="search-input"
                                value="{{ $search }}">
                            <button type="submit" id="searchbt-tokyo" type="get" class="BU">搜索</button>
                        </form>
                        <div id="articles">
                            @if (isset($Houtputs))
                                @if ($Houtputs->isEmpty())
                                    <p class="noResult">查無相關資料</p>
                                @else
                                    @foreach ($Houtputs as $Houtput)
                                        <a href="{{ route('fodetail', ['sfid' => 3, 'foid' => $Houtput->foid]) }}"
                                            class="linking">
                                            <div class="article">
                                                <div class="articlePic">
                                                    <img src="{{ $Houtput->fpicture }}" class="articleImg">
                                                </div>
                                                <div class="articleCon">
                                                    <h2 class="searchtitle">{{ $Houtput->title }}</h2>
                                                    <p>作者：{{ $Houtput->name }}</p>
                                                    <p>發布日期：{{ $Houtput->date }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                    {{ $Houtputs->links() }}
                                @endif
                            @else
                                @foreach ($haters as $hater)
                                    <a href="{{ route('fodetail', ['sfid' => 3, 'foid' => $hater->foid]) }}"
                                        class="linking">
                                        <div class="article">
                                            <div class="articlePic">
                                                <img src="{{ $hater->fpicture }}">
                                            </div>
                                            <div class="articleCon">
                                                <h4 class="searchtitle">{{ $hater->title }}</h4>
                                                <h5>作者：{{ $hater->name }}</h5>
                                                <h5>發布日期：{{ $hater->createtime }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                {{ $haters->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('js/forumIndex.js') }}"></script>

            <aside class="column2">
                <h1>-最新文章-</h1>
                @foreach ($forumNew2s as $forumNew2)
                    <a href="{{ route('fodetail', ['sfid' => $forumNew2->sfid, 'foid' => $forumNew2->foid]) }}"
                        class="linking2">
                        <div class="article2">
                            <div class="article2Con">
                                <h3>{{ $forumNew2->title }}</h3>
                                <div class="new">
                                    @if (empty($forumNew2->upicture))
                                        <img class="newpic" src="{{ asset('pic/admin.png') }}" alt="">
                                    @else
                                        <img class="newpic" src="{{ $forumNew2->upicture }}">
                                    @endif
                                    <span class="newname">{{ $forumNew2->name }}</span><br />
                                    <span class="newtime">{{ $forumNew2->date }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </aside>
        </div>
    </div>
@endsection
