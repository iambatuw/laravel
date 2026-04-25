<?php $__env->startSection('title', 'Profilim | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title', 'Kişisel Profil Ayarları'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4 justify-content-center">
        <!-- Profil Bilgileri -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-light"><i class="bi bi-person-bounding-box me-2 text-primary"></i>Profil Detayları</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="text-center mb-5">
                            <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:32px;border-radius:20px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                            </div>
                            <h5 class="fw-bold text-light mb-1"><?php echo e($user->name); ?></h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill border border-primary border-opacity-25" style="font-size: 11px;">
                                <?php echo e($user->isAdmin() ? 'Sistem Yöneticisi' : 'Öğretmen'); ?>

                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Tam Ad Soyad</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-white">E-posta Adresi</label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-white">İletişim No</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="05XX XXX XX XX">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="text-end mt-5 pt-4 border-top border-light border-opacity-10">
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg">
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Şifre Güncelleme -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-light"><i class="bi bi-shield-lock me-2 text-primary"></i>Güvenlik Ayarları</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Geçerli Parola</label>
                            <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="current_password" required>
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Yeni Parola</label>
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Parola Tekrarı</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="p-3 bg-dark bg-opacity-25 rounded-3 mb-4">
                            <div class="d-flex gap-3">
                                <i class="bi bi-info-circle text-info fs-5"></i>
                                <small class="text-muted">Güçlü bir parola için en az 8 karakter, rakam ve sembol kullanmanız önerilir.</small>
                            </div>
                        </div>

                        <div class="text-end mt-auto">
                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold py-2">
                                Parolayı Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/profile/edit.blade.php ENDPATH**/ ?>