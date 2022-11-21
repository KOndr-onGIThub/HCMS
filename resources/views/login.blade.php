


    <div class="container">
        <div class="row text-center">            
            <h3 class="w-100">
                Přihlášení
            </h3>
        </div>

        <div class="row">     
            <div class="errors">
            @if ($errors->any())            
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
            </div>
                        
            <div class="panel panel-default w-100">

                <div class="panel-body">
                    <br><br>
                    <div class="row">
                        <div class="col-lg-4 col-md-2 col-sm-1"></div>
                        <div class="col-lg-4 col-md-8 col-sm-10">
                            <form class="form-horizontal" method="POST" action="{{ route('authenticate') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">Login</label>

                                    <div class="col-12">
                                        <input id="login" type="text" class="form-control" name="login"
                                               value="{{ old('login') }}" required autofocus>

                                        @if ($errors->has('login'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Heslo</label>

                                    <div class="col-12">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mt-4 text-center">
                                    <div class="offset-lg-2 col-lg-8">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Přihlásit
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-2 col-sm-1"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

