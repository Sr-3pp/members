

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right" style="padding:0!important; margin-top:-17px">
                        <!-- Authentication Links -->
                        @if (Auth::guest())

                        @else
                           
                            <li class="dropdown">
                                <a href="{{url('show/'.Auth::user()->id)}}" class="dropdown-toggle user-name" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/show/'.Auth::user()->id) }}">
                                            Ver Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('auth/edit-profile/'.Auth::user()->id)}}">
                                            Editar Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            
                        @endif
                    </ul>      
                
