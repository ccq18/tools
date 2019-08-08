<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    <ul class="nav navbar-nav">
        &nbsp;

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li><a href="{{ login_url() }}">登 录</a></li>
            <li><a href="{{ register_url() }}">注 册</a></li>
        @else

            <li>
                <a href="{{ url('/words/read-word') }}">
                    背单词
                </a>

            </li>
            <li>
                <a href="{{ url('/words/search') }}">
                    查单词
                </a>

            </li>
            <li class="dropdown">
                {{--<a href="{{ url('/words') }}" >--}}
                {{--单词表-顺序--}}
                {{--</a>--}}
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    单词 <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ url('/words/config') }}">
                            单词设置
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/words') }}">
                            顺序单词表
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/words/learned-list') }}">
                            已学列表
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/words/read-list') }}">
                            分组单词表
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/words/collects') }}">
                            收藏
                        </a>

                    </li>

                </ul>

            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">

                    <li>
                        <a href="{{ url('/questions/create') }}">
                            发布问题
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/notifications') }}">
                            消息通知
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/questions/create') }}">
                            发布问题
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/inbox') }}">
                            私信列表
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/url/index') }}">
                            短网址
                        </a>

                    </li>

                    @if(!is_production())
                        <li>
                            <a href="{{ url('/account/index') }}">
                                资金
                            </a>

                        </li>

                    @endif
                    <li>
                        <a href="{{ logout_url() }}">
                            退出登录
                        </a>

                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>