
    <input type="hidden" name="id" value="{{ Crypt::encrypt($users->id)}}" class="form-control" id="recipient-name1" required/>
    
    <div class="mb-3">
        <label for="recipient-name" class="">Nama :</label>
        <input type="text" name="nama" value="{{ $users->name}}" class="form-control" id="recipient-name1" required/>
    </div>
    <div class="mb-3">
        <label for="recipient-name" class="">Email :</label>
        <input type="text" name="email" value="{{ $users->email}}" class="form-control" id="recipient-name1" required/>
    </div>
    <div class="mb-3">
        <label for="recipient-name" class="">Password :</label>
        <input type="text" name="password" value="" class="form-control" id="recipient-name1"/>
        <small class="text-danger">*Kosongkan jika tidak ingin mengubah password</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="">- Pilih Role -</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $users->hasRole($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>