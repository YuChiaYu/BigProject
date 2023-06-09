@extends('main')


@section('head')
    <title>登山心得 | 與山同行</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/feelIndex.css') }}">
@endsection


@section('content')
    <div id="content-container">
        <div class="row">
            <div class="column1">
                <h1>心得</h1>
                @if(Auth::check())
                    <button id="btPublish" onclick="window.location.href = '{{ route('femes') }}'">
                        發文
                    </button>
                @else
                <button id="btPublish" onclick="window.location.href = '{{ route('login') }}'">
                        發文
                    </button>
                @endif
                <div>
                    <div id="articles">
                        <form class="example" type="get" action="{{ route('feindex') }}">
                            <input type="text" placeholder="輸入關鍵字" name="search" id="search-input"
                                value="{{ $search }}">
                            <button type="submit" id="searchbt">搜索</button>
                        </form>
                        @if (isset($outputs))
                            @foreach ($outputs as $output)
                                <a href="{{ route('fedetail', ['id' => $output->fid]) }}" class="linking">
                                    <div class="article">
                                        <div class="articlePic">
                                            <img src="{{ $output->fpicture }}">
                                        </div>
                                        <div class="articleCon">
                                            <h2 class="searchtitle">{{ $output->title }}</h2>
                                            <p>作者：{{ $output->name }}</p>
                                            <p>發布日期：{{ $output->date }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            {{ $outputs->links() }}
                            @if ($outputs->isEmpty())
                                <p class="noResult">查無相關資料</p>
                            @endif
                        @else
                            @foreach ($datas as $data)
                                <a href="{{ route('fedetail', ['id' => $data->fid]) }}" class="linking">
                                    <div class="article">
                                        <div class="articlePic">
                                            <img src="{{ $data->fpicture }}">
                                        </div>
                                        <div class="articleCon">
                                            <h4 class="searchtitle">{{ $data->title }}</h4>
                                            <h5>作者：{{ $data->name }}</h5>
                                            <h5>發布日期：{{ $data->date }}</h5>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            {{ $datas->links() }}
                        @endif
                    </div>
                </div>

            </div>



            <aside class="column2">
                <h1>-最新文章-</h1>
                @foreach ($feelNews as $feelNew)
                    <a href="{{ route('fedetail', ['id' => $feelNew->fid]) }}" class="linking2">
                        <div class="article2">
                            <div class="article2Con">
                                <h3>{{ $feelNew->title }}</h3>
                                <div class="new">
                                    @if (empty($feelNew->upicture))
                                        <img class="newpic" src="{{ asset('pic/admin.png') }}" alt="">
                                    @else
                                        <img class="newpic" src="{{ $feelNew->upicture }}">
                                    @endif
                                    <span class="newname">{{ $feelNew->name }}</span><br />
                                    <span class="newtime">{{ $feelNew->date }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </aside>
        </div>
    </div>

@endsection
