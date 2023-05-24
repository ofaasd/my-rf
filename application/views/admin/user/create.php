<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                    <p class="bg-danger"><?php echo validation_errors(); ?></p>
                    <form method="POST" action="<?= (empty($user))?base_url('index.php/admin/user/insert'):base_url('index.php/admin/user/update') ?>">
						<input type="hidden" name='id' value='<?= (empty($user))?"":$user->id ?>'>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nama</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?= (empty($user))?"":$user->name ?>" required autocomplete="name" autofocus placeholder="Nama Lengkap | Cth : Abdul Ghofar">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="<?= (empty($user))?"":$user->username ?>" required autocomplete="name" autofocus placeholder="Nama Pengguna | Cth : abdulghofar (tanpa spasi)">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Alamat Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?= (empty($user))?"":$user->email ?>" required autocomplete="email" placeholder="Email | cth : testing@gmail.com">
                            </div>
                        </div>
						<?php
							if (empty($user)){
						?>
							<div class="row mb-3">
								<label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
								
								<div class="col-md-6">
									<input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" onkeyup='check();' placeholder="Password | cth : P@ssw0rd (gunakan kombinasi huruf & angka)">
									<small id="passwordHelp" class="form-text text-muted">Password min. 8 karakter</small>
								</div>
							</div>
						<?php
							}
						?>
						<div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">Roles</label>
                            <div class="col-md-6">
                                <select name="roles" class="form-control">
									<option value="Guest" <?= (!empty($user) && $user->roles=='Guest')?"selected":"" ?>>Guest</option>
									<option value="Admin" <?= (!empty($user) && $user->roles=='Admin')?"selected":"" ?>>Admin</option>
								</select>
                            </div>
                        </div>
						

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?= (empty($user))?"Simpan":"Update" ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var check = function() {
    if (document.getElementById('password').value ==
        document.getElementById('password-confirm').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'Password Sama';
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Password Beda';
        return false;
    }
    }
</script>