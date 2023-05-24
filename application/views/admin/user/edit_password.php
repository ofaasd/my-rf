<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                    <p class="bg-danger"><?php echo validation_errors(); ?></p>
                    <form method="POST" action="<?= base_url('index.php/admin/user/update_password') ?>">
						<input type="hidden" name='id' value='<?= (empty($user))?"":$user->id ?>'>
						<div class="row mb-3">
							<label for="password" class="col-md-4 col-form-label text-md-end">Password Baru</label>
							
							<div class="col-md-6">
								<input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" onkeyup='check();' placeholder="Password | cth : P@ssw0rd (gunakan kombinasi huruf & angka)">
								<small id="passwordHelp" class="form-text text-muted">Password min. 8 karakter</small>
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