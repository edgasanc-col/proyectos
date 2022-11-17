<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 mt-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    @if($user->img_user == "null")
                    <img class="img-profile rounded-circle img-thumbnail" src="{{asset('sb-admin/img/user.svg')}}" width="50%">
                    @else
                    <img class="img-profile rounded-circle img-thumbnail" src="{{ asset('storage/profile-photos/'.$user->img_user) }}">
                    @endif
                    <h3 class="mt-4">{{ $user->nombres }} {{ $user->apellidos }}</h3>
                    <hr>
                    <h5>{{ $user->nombreRol }}</h5>
                    <hr>
                    <h5>{{ $user->email }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 mt-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-dark">Actualizar Contraseña</h5>
                </div>
                @if (session()->has('message_actualizar'))
                <div class="card-body">
				    <div wire:poll.4s class="btn btn-lg btn-success btn-block" style="margin-top:0px; margin-bottom:0px;"> {{ session('message_actualizar') }} </div>
                </div>
				@endif
                    <form>
                        <input type="hidden" wire:model="selected_id">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="password">Nueva Contraseña:</label>
                                <input type="password" wire:model="password" id="password" class="form-control">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña:</label>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button wire:click.prevent="actualizar()" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-dark">Actualizar Imagen Perfil</h5>
                </div>
                @if (session()->has('message_upload'))
                <div class="card-body">
				    <div wire:poll.4s class="btn btn-lg btn-success btn-block" style="margin-top:0px; margin-bottom:0px;"> {{ session('message_upload') }} </div>
                </div>
				@endif
                <div class="card-body">
                    @if ($img_user)
                        <p>Vista previa de la imagen:</p>
                        <img src="{{ $img_user->temporaryUrl() }}" class="img-profile rounded-circle img-thumbnail" width="10%">
                    @endif
                </div>
                    <form>
                        <input type="hidden" wire:model="selected_id">
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" wire:model="img_user" id="img_user">
                                <label class="custom-file-label" for="img_user">Seleccione un archivo...</label>
                                @error('img_user') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button wire:click.prevent="upload()" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>   
</div>
