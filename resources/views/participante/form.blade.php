<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $participante?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="celular" class="form-label">{{ __('Celular') }}</label>
            <input type="text" name="celular" class="form-control @error('celular') is-invalid @enderror"
                value="{{ old('celular', $participante?->celular) }}" id="celular" placeholder="Celular">
            {!! $errors->first('celular', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $participante?->email) }}" id="email" placeholder="Email">
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <select name="estado" id="estado" class="form-select">
                <option value="1" {{ old('estado', $participante?->estado) == '1' ? 'selected' : '' }}>Activo
                </option>
                <option value="0" {{ old('estado', $participante?->estado) == '0' ? 'selected' : '' }}>Inactivo
                </option>
            </select>
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="imagen_qr" class="form-label">{{ __('Imagen QR (Opcional)') }}</label>
            <input type="file" name="imagen_qr" class="form-control @error('imagen_qr') is-invalid @enderror" 
                   id="imagen_qr" accept="image/*" onchange="previewImage(event)">
            {!! $errors->first('imagen_qr', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            
            @if(isset($participante) && $participante->qr)
                <div class="mt-2">
                    <label class="form-label">Imagen Actual:</label>
                    <div>
                        <img src="{{ asset('storage/' . $participante->qr) }}" alt="QR Actual" accept="image/*"
                             style="max-width: 200px; border-radius: 8px; border: 2px solid #ddd;">
                    </div>
                </div>
            @endif
            
            <div id="preview-container" class="mt-2" style="display: none;">
                <label class="form-label">Vista Previa:</label>
                <div>
                    <img id="preview-image" src="" alt="Vista Previa" 
                         style="max-width: 200px; border-radius: 8px; border: 2px solid #00d2ff;">
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Guardar <i class="fas fa-save"></i></button>
    </div>
</div>

@section('js')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
@endsection
